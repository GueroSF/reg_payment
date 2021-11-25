<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            return $this->redirectToRoute('target_path');
        }

        $errorMessage = null;
        if (null !== $error = $authenticationUtils->getLastAuthenticationError()) {
            $errorMessage = $error->getMessageKey();
            foreach ($error->getMessageData() as $key => $value) {
                $errorMessage = str_replace($key, $value, $errorMessage);
            }
        }

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error_message' => $errorMessage
            ]
        );
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
