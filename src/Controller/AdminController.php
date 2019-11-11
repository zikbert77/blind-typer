<?php

namespace App\Controller;

use App\Entity\TestsHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function utils()
    {
        return $this->render('admin/utils.html.twig');
    }

    public function overview()
    {
        $userTestsPassed = $this->getDoctrine()->getRepository(TestsHistory::class)->getForPeriod(
            new \DateTime('now - 7 days'),
            new \DateTime('now + 1 day')
        );

        $anonymousTestsPassed = $this->getDoctrine()->getRepository(TestsHistory::class)->getForPeriod(
            new \DateTime('now - 7 days'),
            new \DateTime('now + 1 day'),
            false
        );

        return $this->render('admin/overview.html.twig', [
            'userTestsPassed' => $userTestsPassed,
            'anonymousTestsPassed' => $anonymousTestsPassed,
        ]);
    }
}