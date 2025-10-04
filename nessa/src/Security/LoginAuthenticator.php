<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginAuthenticator extends AbstractAuthenticator
{
    private $entityManager;
    private $passwordHasher;
    private $router;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {
        return $request->isMethod('POST') && $request->request->has('_username') && $request->request->has('_password');
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('_username');  // Récupérer l'email
        $password = $request->request->get('_password');  // Récupérer le mot de passe

        // Rechercher l'utilisateur par email
        $user = $this->getUserByEmail($email);

        if (!$user) {
            throw new AuthenticationException('Email ou mot de passe invalide.');
        }

        // Vérification du mot de passe
        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new AuthenticationException('Email ou mot de passe invalide.');
        }

        // Créer un UserBadge avec l'email
        $userBadge = new UserBadge($email);

        // Créer un PasswordCredentials avec le mot de passe
        $passwordCredentials = new PasswordCredentials($password);

        // Créer le Passport avec le UserBadge et les PasswordCredentials
        return new Passport($userBadge, $passwordCredentials);
    }

    private function getUserByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('app_profile'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Rediriger vers la page de connexion avec un message d'erreur passé dans l'URL
        return new RedirectResponse($this->router->generate('app_login', [
            'error' => 'Email ou mot de passe incorrect.'
        ]));
    }
}
