<?php

namespace App\Controller;

use App\Entity\User;
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

    public function test(TokenStorageInterface $tokenStorage)
    {
        /** @var User $user */
        $user = $tokenStorage->getToken()->getUser();
        return $this->render('main/test.html.twig', [
            'keyboard' => Keyboard::loadKeyboard(is_string($user) ? Keyboard::KEYBOARD_ANSI : $user->getDefaultKeyboard() ?? Keyboard::KEYBOARD_ANSI)
        ]);
    }
}