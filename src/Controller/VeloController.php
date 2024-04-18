<?php
// src/Controller/VeloController.php

namespace App\Controller;

use App\Entity\Velo;
use App\Form\VeloInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return $this->render('velo/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/velo/all', name: 'velo_info', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $velos = $entityManager->getRepository(Velo::class)->findAll();

        $velosData = [];
        foreach ($velos as $velo) {
            $velosData[] = [
                'numero_de_serie' => $velo->getNumeroDeSerie(),
                'marque' => $velo->getMarque(),
                'ref_recyclerie' => $velo->getRefRecyclerie(),
                'couleur' => $velo->getCouleur(),
                'date_de_reception' => $velo->getDateDeReception(),
            ];
        }
        return $this->render('velo/velo_liste.html.twig', [
            'velos' => $velosData,
        ]);
    }
}
