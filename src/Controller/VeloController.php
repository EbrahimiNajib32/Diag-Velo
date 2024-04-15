<?php
// src/Controller/VeloController.php

namespace App\Controller;

use App\Entity\Velo;
use App\Form\VeloInfoType;
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
            // La sauvegarde du nouveau vélo
            $entityManager->persist($velo);
            $entityManager->flush();

            // Vérification si une recherche par 'ref_recyclerie_search' a été demandée
            if ($form->has('ref_recyclerie')) {
                $refRecyclerie = $form->get('ref_recyclerie')->getData();
                if ($refRecyclerie) {
                    // Exécution de la recherche si un critère de recherche est fourni
                    $velos = $entityManager->getRepository(Velo::class)->findBy(['ref_recyclerie' => $refRecyclerie]);

                    // Vous pouvez ajouter ici une redirection vers une page de résultats, ou modifier la vue pour afficher les résultats
                    return $this->render('velo/search_results.html.twig', [
                        'velos' => $velos,
                        'form' => $form->createView(), // Réafficher le formulaire avec les résultats
                    ]);
                }
            }

            // Redirection après l'enregistrement si aucune recherche n'est effectuée
            return $this->redirectToRoute('velo_success');
        }

        // Affichage du formulaire (vide ou avec erreurs)
        return $this->render('velo/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
