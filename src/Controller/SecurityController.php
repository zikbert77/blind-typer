<?php

namespace App\Controller;

use App\Component\Email;
use App\Entity\ResetPasswordRequests;
use App\Entity\User;
use App\Repository\ResetPasswordRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Generator\UrlGenerator;


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
     * @Route("/reset", name="resetPassword")
     * @param Request $request
     * @return Response
     */
    public function resetPassword(Request $request)
    {
        $errors = [];
        if ($request->getMethod() == 'POST') {
            $email = $request->get('email', null);
            if (empty($email)) {
                $errors[] = 'Email address is empty';
            }

            /** @var User $user */
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                'email' => $email
            ]);
            if (empty($user)) {
                $errors[] = "Couldn't find user by passed email";
            } else {
                /** @var ResetPasswordRequests $resetLink */
                $resetLink = $this->getDoctrine()->getRepository(ResetPasswordRequests::class)->createForUser($user);
                if (empty($resetLink)) {
                    $errors[] = "Couldn't build reset link for user";
                }

                if (empty($errors)) {
                    $link = $this->generateUrl('proceedPasswordReset', [
                        'hash' => $resetLink->getHash()
                    ], UrlGenerator::ABSOLUTE_URL);

                    $errors = Email::send($email, 'Password reset', Email::buildResetPasswordMessage($email, $link));
                }
            }
        }
        
        return $this->render('security/restore.html.twig', [
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/reset/proceed/{hash}", name="proceedPasswordReset")
     * @param $hash
     * @return Response
     */
    public function proceedPasswordReset($hash)
    {
        $errors = [];
        /** @var ResetPasswordRequests $resetRequest */
        $resetRequest = $this->getDoctrine()->getRepository(ResetPasswordRequests::class)->findValidRequestByHash($hash);
        if (empty($resetRequest)) {
            $errors[] = 'Your request is invalid, or your password reset link expired.';
        } else {
            $user = $resetRequest->getUser();
        }

        return $this->render('security/restore_proceed.html.twig', [
            'errors' => $errors,
            'user' => $user ?? null
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
