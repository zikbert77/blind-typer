<?php

namespace App\Controller;

use App\Entity\User;
use App\Component\Email;
use App\Form\UserResetPasswordType;
use App\Entity\ResetPasswordRequests;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
            $this->redirectToRoute('index');
         }

        $error = $authenticationUtils->getLastAuthenticationError();
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
                $errors[] = "Couldn't find user by $email email";
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

                    $errors = Email::send($email, 'Password reset', Email::buildResetPasswordMessage($email, $link), true);
                }
            }
        }
        
        return $this->render('security/reset.html.twig', [
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/reset/proceed/{hash}", name="proceedPasswordReset")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param $hash
     * @return Response
     */
    public function proceedPasswordReset(Request $request, UserPasswordEncoderInterface $passwordEncoder, $hash)
    {
        $errors = [];
        /** @var ResetPasswordRequests $resetRequest */
        $resetRequest = $this->getDoctrine()->getRepository(ResetPasswordRequests::class)->findValidRequestByHash($hash);
        if (empty($resetRequest)) {
            $errors[] = 'Your request is invalid, or your password reset link has been expired.';
        } else {
            $user = $resetRequest->getUser();

            $form = $this->createForm(UserResetPasswordType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);

                $resetRequest->setStatus(ResetPasswordRequests::STATUS_USED);
                $entityManager->persist($resetRequest);

                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            } else {
                if ($request->get('user_reset_password')['plainPassword'] ?? false) {
                    if (
                        $request->get('user_reset_password')['plainPassword']['first'] ?? 1 !=
                        $request->get('user_reset_password')['plainPassword']['second'] ?? 2
                    ) {
                        $errors[] = 'Passwords are not same';
                    }
                }
            }

            return $this->render('security/reset_proceed.html.twig', [
                'errors' => $errors,
                'user' => $user,
                'form' => $form->createView()
            ]);
        }

        return $this->render('security/reset_proceed.html.twig', [
            'errors' => $errors,
            'user' => null
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
