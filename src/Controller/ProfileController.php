<?php

namespace App\Controller;

use App\Entity\TestsHistory;
use App\Form\UserProfileType;
use Symfony\Component\HttpFoundation\Request;
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

    public function settings(TokenStorageInterface $tokenStorage, Request $request)
    {
        $user = $tokenStorage->getToken()->getUser();

        $userProfileForm = $this->createForm(UserProfileType::class, $user);
        $userProfileForm->handleRequest($request);
        if ($userProfileForm->isSubmitted() && $userProfileForm->isValid()) {
            $user = $userProfileForm->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profileSettings');
        }

        return $this->render('profile/settings.html.twig', [
            'user' => $user,
            'userProfileForm' => $userProfileForm->createView()
        ]);
    }
}