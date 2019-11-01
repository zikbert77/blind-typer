<?php

namespace App\Controller;

use App\Entity\Courses;
use App\Component\Keyboard;
use App\Entity\TestsHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MainController extends AbstractController
{
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

    public function test()
    {
        return $this->render('main/test.html.twig', [
            'keyboard' => Keyboard::loadKeyboard(is_string($this->user) ? Keyboard::KEYBOARD_ANSI : $this->user->getDefaultKeyboard() ?? Keyboard::KEYBOARD_ANSI)
        ]);
    }
    
    public function courses()
    {
        return $this->render('main/courses.html.twig', [
            'lastResult' => $this->getDoctrine()->getRepository(TestsHistory::class)->getLast(
                $this->user
            ),
            'courses' => $this->getDoctrine()->getRepository(Courses::class)->getFormatted()
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
                'keyboard' => Keyboard::loadKeyboard(is_string($this->user) ? Keyboard::KEYBOARD_ANSI : $this->user->getDefaultKeyboard() ?? Keyboard::KEYBOARD_ANSI)
            ]);
        }

        return $this->redirectToRoute('courses');
    }
}