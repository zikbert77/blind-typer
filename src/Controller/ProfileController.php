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
        $testsHistoryData = $this->getDoctrine()->getRepository(TestsHistory::class)->getDataForChart(
            $tokenStorage->getToken()->getUser()
        );

        return $this->render('profile/index.html.twig', [
            'testsHistoryData' => $testsHistoryData
        ]);
    }
}