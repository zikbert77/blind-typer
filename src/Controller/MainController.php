<?php

namespace App\Controller;

use App\Entity\Courses;
use App\Entity\Languages;
use App\Component\Keyboard;
use App\Entity\TestsHistory;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MainController extends AbstractController
{
    /** @var User */
    private $user = null;
    
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function index()
    {
        return $this->render('main/index.html.twig', [
            'lastResult' => $this->getDoctrine()->getRepository(TestsHistory::class)->getLast(
                $this->user
            )
        ]);
    }

    public function test(Request $request)
    {
        $selectedLanguage = Languages::DEFAULT_LANGUAGE;
        if (!empty($request->get('language'))) {
            $selectedLanguage = $request->get('language');
        } elseif (!is_string($this->user)) {
            $selectedLanguage = $this->user->getDefaultLanguage()->getId();
        }

        return $this->render('main/test.html.twig', [
            'keyboard' => Keyboard::loadKeyboard(
                is_string($this->user) ? Keyboard::KEYBOARD_ANSI : $this->user->getDefaultKeyboard() ?? Keyboard::KEYBOARD_ANSI,
                $selectedLanguage
            ),
            'languages' => $this->getDoctrine()->getRepository(Languages::class)->findAll()
        ]);
    }
    
    public function courses()
    {
        return $this->render('main/courses.html.twig', [
            'lastResult' => $this->getDoctrine()->getRepository(TestsHistory::class)->getLast(
                $this->user
            ),
            'courses' => $this->getDoctrine()->getRepository(Courses::class)->getFormatted(),
            'premiumCourses' => Courses::PREMIUM_GROUPS_TITLES,
        ]);
    }

    public function course($id)
    {
        $course = $this->getDoctrine()->getRepository(Courses::class)->find($id);
        if (!empty($course)) {
            $nextCourse = $this->getDoctrine()->getRepository(Courses::class)->findOneBy([
                'position' => $course->getPosition() + 1,
                'groupId' => $course->getGroupId(true)
            ]);

            return $this->render('main/course.html.twig', [
                'course' => $course,
                'nextCourse' => $nextCourse,
                'keyboard' => Keyboard::loadKeyboard(is_string($this->user) ? Keyboard::KEYBOARD_ANSI : $this->user->getDefaultKeyboard() ?? Keyboard::KEYBOARD_ANSI),
                'isPremium' => in_array($course->getGroupId(), Courses::PREMIUM_GROUPS_TITLES)
            ]);
        }

        return $this->redirectToRoute('courses');
    }
}