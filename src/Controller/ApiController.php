<?php

namespace App\Controller;

use App\Entity\Texts;
use App\Entity\Languages;
use App\Entity\TestsHistory;
use App\Component\TextParser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApiController extends AbstractController
{
    private static $textParser = null;

    private static function getParsedText(string $text): array
    {
        if (is_null(self::$textParser)) {
            self::$textParser = new TextParser();
        }

        self::$textParser->setOriginalText($text);
        return [
            'parsedText' => self::$textParser->parseForJs(),
            'words' => self::$textParser->calculateWords(),
            'chars' => self::$textParser->calculateLetters(),
        ];
    }

    public function prepareText(Request $request)
    {
        return new JsonResponse(
            self::getParsedText(
                $request->request->get('texts')['text_body'] ??
                $request->request->get('courses')['textBody'] ??
                'No get'
            )
        );
    }

    public function saveTestResult(Request $request, TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        $textId = $request->request->get('textId');
        $testDuration = $request->request->get('testDuration');
        $wpm = $request->request->get('wpm');
        $cpm = $request->request->get('cpm');
        $accuracy = $request->request->get('accuracy');

        $text = $this->getDoctrine()->getRepository(Texts::class)->find($textId);
        if (empty($text)) {
            return new JsonResponse([
                'status' => 'failed',
                'error' => 'Text not found',
            ]);
        }

        $result = $this->getDoctrine()->getRepository(TestsHistory::class)->save(
            is_string($user) ? null : $user,
            $text,
            $testDuration,
            $wpm,
            $cpm,
            $accuracy
        );

        return new JsonResponse([
            'status' => $result['status'],
            'error' => $result['error'] ?? '',
        ]);
    }

    public function getTestHistoryForUser(Request $request, TokenStorageInterface $tokenStorage)
    {
        return new JsonResponse($this->getDoctrine()->getRepository(TestsHistory::class)->getDataForChart(
            $tokenStorage->getToken()->getUser(),
            $request->get('limit')
        ));
    }

    public function getText(Request $request, TokenStorageInterface $tokenStorage, $duration = 1)
    {
        $user = $tokenStorage->getToken()->getUser();
        $language = $request->get('language') ?? (is_string($user) ? null : $user->getDefaultLanguage()->getId()) ?? Languages::DEFAULT_LANGUAGE;

        /** @var Texts $text */
        $text = $this->getDoctrine()->getRepository(Texts::class)->selectRandomText(
            $request,
            $language,
            $duration
        );

        if (empty($text)) {
            return new JsonResponse([
                'error' => true
            ]);
        }

        $previousText = $request->getSession()->get('previousText') ?? [];
        $previousText[] = $text->getId();

        $request->getSession()->set('previousText', $previousText);

        return new JsonResponse([
            'textId' => $text->getId(),
            'parsedText' => $text->getParsedText(),
            'wordsCount' => $text->getWordsCount(),
            'lettersCount' => $text->getLetterCounts(),
        ]);
    }
}