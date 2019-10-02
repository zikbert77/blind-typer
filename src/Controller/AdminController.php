<?php

namespace App\Controller;

use App\Entity\TestsHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    public function overview()
    {
        $userTestsPassed = $this->getDoctrine()->getRepository(TestsHistory::class)->getForPeriod(
            new \DateTime('now - 7 days'),
            new \DateTime('now + 1 day')
        );
        
        return $this->render('admin/overview.html.twig', [
            'userTestsPassed' => $userTestsPassed
        ]);
    }
}