<?php

namespace App\Controller;

use App\Component\TextParser;
use App\Entity\Texts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    public function prepareText()
    {
        $originalText = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Sit amet porttitor eget dolor morbi non arcu. Consectetur lorem donec massa sapien faucibus.
                    Pulvinar pellentesque habitant morbi tristique senectus. Cursus metus aliquam eleifend mi in nulla posuere sollicitudin aliquam.
                    Urna et pharetra pharetra massa massa ultricies mi quis. Lacinia quis vel eros donec ac odio. Consectetur adipiscing elit ut aliquam purus.
                    Aenean pharetra magna ac placerat vestibulum. Sed elementum tempus egestas sed sed risus. Viverra justo nec ultrices dui. Arcu non sodales neque sodales.
                    Vel elit scelerisque mauris pellentesque. Placerat duis ultricies lacus sed turpis tincidunt id. At auctor urna nunc id cursus metus.
                    Adipiscing vitae proin sagittis nisl rhoncus mattis rhoncus. Et sollicitudin ac orci phasellus egestas tellus. Orci ac auctor augue mauris.
                    Mattis pellentesque id nibh tortor. Etiam non quam lacus suspendisse faucibus interdum posuere.";
    }

    public function getText($duration = 1)
    {
        /** @var Texts $text */
        $text = $this->getDoctrine()->getRepository(Texts::class)->selectRandomText($duration);

        return new JsonResponse([
            'parsedText' => $text->getParsedText(),
            'wordsCount' => $text->getWordsCount(),
            'lettersCount' => $text->getLetterCounts(),
        ]);
    }
}