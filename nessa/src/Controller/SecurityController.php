<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs de connexion et le dernier nom d'utilisateur utilisé
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Retourner le formulaire de connexion avec les erreurs et le dernier nom d'utilisateur
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route("/deconnexion", name: 'app_logout')]
    public function logout()
    {
        // Symfony gère automatiquement la déconnexion
        throw new \LogicException('Cette méthode peut rester vide - elle est interceptée par le système de sécurité.');
    }
}
