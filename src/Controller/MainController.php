<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function index()
    {
        return $this->render('main/index.html.twig');
    }

    public function test($time = 1)
    {
        return $this->render('main/test.html.twig');
    }
}