<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DiagnosticEnCourController extends AbstractController
{
    #[Route('/diagnostic/en/cour', name: 'app_diagnostic_en_cour')]
    public function index(): Response
    {
        // Expanded mock data for bicycle diagnostics
        $elements = [
            ['id_element' => 1, 'element' => 'cadre: aspect général'],
            ['id_element' => 2, 'element' => 'cadre: béquille'],
            ['id_element' => 3, 'element' => 'roue avant: pneu'],
            ['id_element' => 4, 'element' => 'roue arrière: pneu'],
            ['id_element' => 5, 'element' => 'frein avant: levier'],
            ['id_element' => 6, 'element' => 'frein arrière: levier'],
        ];

        $etatControles = [
            ['id_etat' => 1, 'nom_etat' => 'OK'],
            ['id_etat' => 2, 'nom_etat' => 'Pas OK'],
            ['id_etat' => 3, 'nom_etat' => 'À reviser'],
        ];

        $diagnosticDetails = [
            ['id_diagnostique' => 1, 'id_element' => 1, 'id_velo' => 1, 'commentaire' => 'Cadre légèrement rayé', 'id_etat' => 2],
            ['id_diagnostique' => 1, 'id_element' => 2, 'id_velo' => 1, 'commentaire' => 'Béquille manquante', 'id_etat' => 2],
            ['id_diagnostique' => 2, 'id_element' => 3, 'id_velo' => 2, 'commentaire' => 'Pneu avant usé', 'id_etat' => 2],
            ['id_diagnostique' => 2, 'id_element' => 4, 'id_velo' => 2,'commentaire' => 'Pneu arrière neuf', 'id_etat' => 1],
            ['id_diagnostique' => 3, 'id_element' => 5, 'id_velo' => 3,'commentaire' => 'Levier de frein avant en bon état', 'id_etat' => 1],
            ['id_diagnostique' => 3, 'id_element' => 6, 'id_velo' => 3,'commentaire' => 'Levier de frein arrière nécessite réglage', 'id_etat' => 3],
        ];

        // Combine diagnostic details with element and state data
        foreach ($diagnosticDetails as &$detail) {
            $detail['element'] = $this->findElementById($elements, $detail['id_element'])['element'];
            $detail['etat'] = $this->findStateById($etatControles, $detail['id_etat'])['nom_etat'];
        }

        // Expanded mock Velos data
        $velos = [
            ['id_velo' => 1, 'ref_recyclerie' => '12345L', 'numero_de_serie' => '241221', 'type' => 'VTT', 'marque' => 'Bianchi', 'annee' => 2021, 'couleur' => 'Bleu', 'poids' => 14, 'taille_roue' => 27, 'taille_cadre' => 55, 'photo' => 'url_photo1', 'etat' => 'Neuf', 'date_reception' => '2024-04-01', 'date_vente' => null, 'date_destruction' => null, 'emplacement' => 'Alle 3', 'commentaires' => 'Vélo neuf, aucun problème'],
            ['id_velo' => 2, 'ref_recyclerie' => '78901F', 'numero_de_serie' => '412122', 'type' => 'VTC', 'marque' => 'Trek', 'annee' => 2022, 'couleur' => 'Rouge', 'poids' => 8, 'taille_roue' => 25, 'taille_cadre' => 50, 'photo' => 'url_photo2', 'etat' => 'Occasion', 'date_reception' => '2024-03-21', 'date_vente' => null, 'date_destruction' => null, 'emplacement' => 'Alle 1', 'commentaires' => 'Nécessite un contrôle'],
            ['id_velo' => 3, 'ref_recyclerie' => '34567F', 'numero_de_serie' => '314123', 'type' => 'Pliable', 'marque' => 'Giant', 'annee' => 2020, 'couleur' => 'Vert', 'poids' => 12, 'taille_roue' => 26, 'taille_cadre' => 52, 'photo' => 'url_photo3', 'etat' => 'Occasion', 'date_reception' => '2024-03-30', 'date_vente' => null, 'date_destruction' => null, 'emplacement' => 'Alle 2', 'commentaires' => 'En très bon état'],
            ['id_velo' => 4, 'ref_recyclerie' => '45678G', 'numero_de_serie' => '527331', 'type' => 'Urban', 'marque' => 'Specialized', 'annee' => 2023, 'couleur' => 'Noir', 'poids' => 9, 'taille_roue' => 28, 'taille_cadre' => 54, 'photo' => 'url_photo4', 'etat' => 'Neuf', 'date_reception' => '2024-04-15', 'date_vente' => null, 'date_destruction' => null, 'emplacement' => 'Alle 4', 'commentaires' => 'Prêt pour la vente'],
        ];

        $velosWithDiagnostics = array_filter($velos, function ($velo) use ($diagnosticDetails) {
            foreach ($diagnosticDetails as $detail) {
                if ($detail['id_velo'] == $velo['id_velo']) {
                    return true;
                }
            }
            return false;
        });

        return $this->render('diagnostic_en_cour/index.html.twig', [
            'velosWithDiagnostics' => $velosWithDiagnostics,
            'diagnosticDetails' => $diagnosticDetails,
        ]);
    }

    private function findElementById(array $elements, $id)
    {
        foreach ($elements as $element) {
            if ($element['id_element'] === $id) {
                return $element;
            }
        }
        return null; // Return null if no element found
    }

    private function findStateById(array $states, $id)
    {
        foreach ($states as $state) {
            if ($state['id_etat'] === $id) {
                return $state;
            }
        }
        return null; // Return null if no state found
    }
}

