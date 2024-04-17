<?php

// src/Controller/VeloController.php
// src/Controller/VeloController.php

namespace App\Controller;

use App\Entity\Velo;
use App\Form\VeloInfoType;
use App\Form\SearchVeloType; // Importez le formulaire de recherche
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class VeloController extends AbstractController
{
    #[Route('/velo/new', name: 'velo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $velo = new Velo();
        $form = $this->createForm(VeloInfoType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($velo);
            $entityManager->flush();

            // Redirection après enregistrement
            return $this->redirectToRoute('velo_success');
        }

        // Créer le formulaire de recherche
        $searchForm = $this->createForm(SearchVeloType::class);
        $searchForm->handleRequest($request);

        // Ajouter ici la logique pour la recherche si nécessaire

        return $this->render('velo/new.html.twig', [
            'form' => $form->createView(),
            'searchForm' => $searchForm->createView(), // Passer le formulaire de recherche au template Twig
        ]);
    }
}
