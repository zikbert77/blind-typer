<?php

namespace App\Controller;

use App\Component\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
            $this->redirectToRoute('index');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/restore", name="restorePassword")
     * @param Request $request
     * @return Response
     */
    public function restorePassword(Request $request)
    {
        $errors = [];
        if ($request->getMethod() == 'POST') {
            //restoring
            $email = $request->get('email', null);
            if (empty($email)) {
                $errors[] = 'Email address is empty';
            }
            
            if (empty($errors)) {
                $errors = Email::send($email, 'Password reset', Email::buildResetPasswordMessage($email));
            }

            echo '<pre>';
            var_dump($errors);
            echo '</pre>';
            exit;
        }
        
        return $this->render('security/restore.html.twig', [
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
