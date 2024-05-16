<?php

namespace App\Controller;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{
    #[Route('/dashboard/utilisateur/new', name: 'utilisateur_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $utilisateur->getPassword();

            // Ensure a password is provided for new users
            if (empty($password)) {
                $this->addFlash('error', 'Un mot de passe est requis pour créer un nouvel utilisateur.');
                return $this->render('utilisateur/new.html.twig', [
                    'userForm' => $form->createView(),
                ]);
            }

            // Hash the password
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, $password);
            $utilisateur->setPassword($hashedPassword);

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->addFlash('success', 'Nouveau utilisateur ajouté!');
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('utilisateur/new.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }


    #[Route('/dashboard/utilisateurs', name: 'utilisateur_liste')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $utilisateurs = $entityManager->getRepository(Utilisateur::class)->findAll();

        return $this->render('utilisateur/liste.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/dashboard/utilisateur/edit/{id}', name: 'utilisateur_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, Utilisateur $utilisateur): Response
    {
        // Store the original password to compare later
        $originalPassword = $utilisateur->getPassword();

        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if password was changed
            $newPassword = $form->get('password')->getData();

            if (!empty($newPassword)) {
                $hashedPassword = $passwordHasher->hashPassword($utilisateur, $newPassword);
                $utilisateur->setPassword($hashedPassword);
            }else {
                $utilisateur->setPassword($originalPassword);
            }

            $entityManager->flush();
            $this->addFlash('success', 'User updated successfully!');
            return $this->redirectToRoute('utilisateur_liste');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/utilisateur/disable/{id}', name: 'utilisateur_disable')]
    public function disable(EntityManagerInterface $entityManager, Utilisateur $utilisateur): Response
    {
        $utilisateur->setActive(false);
        $entityManager->flush();

        return $this->json(['success' => 'Utilisateur désactivé avec succès.']);
    }


}



