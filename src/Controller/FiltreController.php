<?php
// src/Controller/FiltreController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\VeloInfoService;

class FiltreController extends AbstractController
{
    private $veloInfoService;

    public function __construct(VeloInfoService $veloInfoService)
    {
        $this->veloInfoService = $veloInfoService;
    }

    /**
     * @Route("/filtre", name="filtre_index")
     */
    public function index(): Response
    {
        // Récupérer toutes les informations depuis le service
        $marques = $this->veloInfoService->getMarques();
        $couleurs = $this->veloInfoService->getCouleurs();
        $types = $this->veloInfoService->getTypes();
        $publics = $this->veloInfoService->getPublics();

        // Récupérer les informations sur le diagnostic
        //$datesDiagnostic = $this->veloInfoService->getDatesDiagnostic();
        $conclusionsDiagnostic = $this->veloInfoService->getConclusionsDiagnostic();
        $statusDiagnostic = $this->veloInfoService->getStatusDiagnostic();

        // Récupérer les informations sur le propriétaire
        $nomsProprio = $this->veloInfoService->getNomsProprio();
        $statutsProprio = $this->veloInfoService->getStatutsProprio();

        // Passer toutes les informations à la vue
        return $this->render('filtre/index.html.twig', [
            'marques' => $marques,
            'couleurs' => $couleurs,
            'types' => $types,
            'publics' => $publics,
           // 'datesDiagnostic' => $datesDiagnostic,
            'conclusionsDiagnostic' => $conclusionsDiagnostic,
            'statusDiagnostic' => $statusDiagnostic,
            'nomsProprio' => $nomsProprio,
            'statutsProprio' => $statutsProprio,
        ]);
    }
}
