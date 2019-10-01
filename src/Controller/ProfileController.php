<?php

namespace App\Controller;

use App\Entity\TestsHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileController extends AbstractController
{
    public function index(TokenStorageInterface $tokenStorage)
    {
        /** @var TestsHistory $lastPassedTest */
        $lastPassedTest = $this->getDoctrine()->getRepository(TestsHistory::class)->findBy(
            ['user' => $tokenStorage->getToken()->getUser()],
            ['id' => 'DESC'],
            1
        );
        
        return $this->render('profile/index.html.twig', [
            'lastPassedText' => $lastPassedTest[0]
        ]);
    }
}