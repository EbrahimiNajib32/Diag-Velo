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
    $datesDiagnostic = $this->veloInfoService->getDatesDiagnostic();
    $conclusionsDiagnostic = $this->veloInfoService->getConclusionsDiagnostic();
    $statusDiagnostic = $this->veloInfoService->getStatusDiagnostic();
    $nomsProprio = $this->veloInfoService->getNomsProprio();
    $statutsProprio = $this->veloInfoService->getStatutsProprio();
    // Récupérer les détails des lieux et types de lieux
     $lieuxDetails = $this->veloInfoService->getLieuxDetails(); // Liste complète des lieux
     $typesLieu = $this->veloInfoService->getNomsTypesLieu(); // Noms des types de lieux

    // Extraire uniquement les valeurs des marques
    $marques_uniques = array_map(function ($marque) {
        return $marque['marque'];
    }, $marques);

    // Extraire uniquement les valeurs des couleurs
    $couleurs_uniques = array_map(function ($couleur) {
        return $couleur['couleur'];
    }, $couleurs);

    // Extraire uniquement les valeurs des types
    $types_uniquesz = array_map(function ($type) {
        return $type['type'];
    }, $types);

    // Extraire uniquement les valeurs des publics
    $publics_uniques = array_map(function ($public) {
        return $public['public'];
    }, $publics);

    // Extraire uniquement les valeurs des conclusions de diagnostic
    $conclusions_uniques = array_map(function ($conclusion) {
        return $conclusion['conclusion'];
    }, $conclusionsDiagnostic);

    // Extraire uniquement les valeurs des statuts de diagnostic
    $status_uniques = array_map(function ($statut) {
        return $statut['status'];
    }, $statusDiagnostic);

    // Extraire uniquement les valeurs des noms de propriétaire
    $nomsProprio_uniques = array_map(function ($nom) {
        return $nom['nom_proprio'];
    }, $nomsProprio);

    // Extraire uniquement les valeurs des statuts de propriétaire
    $statutsProprio_uniques = array_map(function ($statut) {
        return $statut['statut'];
    }, $statutsProprio);

    // Passer toutes les informations à la vue
    //return $this->render('filtre/index.html.twig', [
         return $this->render('diagnostic/recapitulatif.html.twig', [
        'marques' => $marques_uniques,
        'couleurs' => $couleurs_uniques,
        'types' => $types_uniquesz,
        'publics' => $publics_uniques,
        'date_diagnostic' => $datesDiagnostic,
        'conclusions' => $conclusions_uniques,
        'status' => $status_uniques,
        'nomsProprio' => $nomsProprio_uniques,
        'statuts' => $statutsProprio_uniques,
        'lieuxDetails' => $lieuxDetails, // Détails des lieux
        'typesLieu' => $typesLieu, // Noms des types de lieux
    ]);
}

}
