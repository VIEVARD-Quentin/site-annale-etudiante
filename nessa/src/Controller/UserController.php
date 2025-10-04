<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\RegistrationType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface      $entityManager,
        UserAuthenticatorInterface  $userAuthenticator,
        LoginAuthenticator          $authenticator
    ): Response
    {
        $user = new User();

        // Création du formulaire d'inscription
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $user->setPassword(
                $passwordHasher->hashPassword($user, $user->getPassword())
            );

            // Définir un rôle par défaut pour l'utilisateur
            $user->setRoles(['ROLE_USER']);

            // Enregistrement de l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Connexion automatique de l'utilisateur
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        // Si le formulaire n'est pas soumis ou n'est pas valide, retourner la vue du formulaire
        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/profil', name: 'app_profile')]
    public function profile(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profil/profile.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/change-password', name: 'change_password', methods: ['POST'])]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non connecté.'], 403);
        }

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                return new JsonResponse(['success' => false, 'message' => 'Mot de passe actuel incorrect.']);
            }

            if ($newPassword !== $confirmPassword) {
                return new JsonResponse(['success' => false, 'message' => 'Les nouveaux mots de passe ne correspondent pas.']);
            }

            $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
            $entityManager->flush();

            return new JsonResponse(['success' => true, 'message' => 'Mot de passe mis à jour avec succès.']);
        }

        return new JsonResponse(['success' => false, 'message' => 'Données invalides.']);
    }

    #[Route('/verify-password', name: 'verify_password', methods: ['POST'])]
    public function verifyPassword(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $data = json_decode($request->getContent(), true);
        $currentPassword = $data['currentPassword'] ?? '';

        if ($passwordHasher->isPasswordValid($user, $currentPassword)) {
            return $this->json(['success' => true, 'message' => 'Mot de passe correct.']);
        }

        return $this->json(['success' => false, 'message' => 'Mot de passe incorrect.'], 400);
    }

    #[Route('/update-password', name: 'update_password', methods: ['POST'])]
    public function updatePassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['success' => false, 'message' => 'Utilisateur non connecté.'], 401);
        }

        $data = json_decode($request->getContent(), true);
        $newPassword = $data['newPassword'] ?? '';
        $confirmPassword = $data['confirmPassword'] ?? '';

        if (empty($newPassword) || $newPassword !== $confirmPassword) {
            return $this->json(['success' => false, 'message' => 'Les mots de passe ne correspondent pas.'], 400);
        }

        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['success' => true, 'message' => 'Mot de passe mis à jour avec succès.']);
    }


}