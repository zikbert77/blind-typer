<?php

namespace App\Controller;

use App\Component\Keyboard;
use App\Entity\TestsHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MainController extends AbstractController
{
    public function index(TokenStorageInterface $tokenStorage)
    {
        return $this->render('main/index.html.twig', [
            'lastResult' => $this->getDoctrine()->getRepository(TestsHistory::class)->getLast(
                $tokenStorage->getToken()->getUser()
            )
        ]);
    }

    public function test($time = 1)
    {
        return $this->render('main/test.html.twig', [
            'keyboard' => Keyboard::loadKeyboard(Keyboard::KEYBOARD_ANSI)
        ]);
    }
}