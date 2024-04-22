<?php
// src/Controller/DiagosticController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Diagnostic;
use App\Entity\DiagnosticElement;
use App\Entity\EtatControl;
use App\Entity\ElementControl;


use Doctrine\ORM\EntityManagerInterface;

class DiagnosticController extends AbstractController
{
    #[Route('/diagnostic', name: 'app_diagnostic', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
        $diagnosticData = [];

        foreach ($diagnostics as $diagnostic) {
            $diagnosticData[] = [
                'id' => $diagnostic->getId(),
                'id_velo' => $diagnostic->getVelo()->getId(),
                'id_user' => $diagnostic->getIdUser(),
                'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                'cout_reparation' => $diagnostic->getCoutReparation(),
                'conclusion' => $diagnostic->getConclusion(),
            ];
        }

        return new JsonResponse($diagnosticData);
    }

    #[Route('/diagnostic/{id}', name: 'app_diagnostic_by_id', methods: ['GET'])]
    public function diagnosticById(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnostic = $entityManager->getRepository(Diagnostic::class)->find($id);

        if (!$diagnostic) {
            return new JsonResponse(['message' => 'Diagnostic not found'], Response::HTTP_NOT_FOUND);
        }

        $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

        $elementData = [];
        foreach ($elements as $element) {
            $etat = $element->getEtatControl();
            $veloElement = $element->getElementControl();

            $elementData[] = [
                'id' => $element->getId(),
                'commentaire' => $element->getCommentaire(),
                'element' => $veloElement->getElement(),
                'etat' => $etat->getNomEtat(),
            ];
        }

        $diagnosticData = [
            'id' => $diagnostic->getId(),
            'id_velo' => $diagnostic->getVelo()->getId(),
            'id_user' => $diagnostic->getIdUser(),
            'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
            'cout_reparation' => $diagnostic->getCoutReparation(),
            'conclusion' => $diagnostic->getConclusion(),
            'elements' => $elementData,
        ];

        return new JsonResponse($diagnosticData);
    }
//    #[Route('/diagnosticAvecElement', name: 'app_diagnostics_avec_elements', methods: ['GET'])]
//    public function diagnosticAvecElement(EntityManagerInterface $entityManager): JsonResponse
//    {
//
//        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
//
//        $filteredDiagnostics = [];
//
//
//        foreach ($diagnostics as $diagnostic) {
//            $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);
//
//            if (!empty($elements)) {
//                $elementData = [];
//                foreach ($elements as $element) {
//                    $etat = $element->getEtatControl();
//                    $veloElement = $element->getElementControl();
//
//                    $elementData[] = [
//                        'id' => $element->getId(),
//                        'commentaire' => $element->getCommentaire(),
//                        'element' => $veloElement->getElement(),
//                        'etat' => $etat->getNomEtat(),
//                    ];
//                }
//
//                $filteredDiagnostics[] = [
//                    'id' => $diagnostic->getId(),
//                    'id_velo' => $diagnostic->getVelo()->getId(),
//                    'id_user' => $diagnostic->getIdUser(),
//                    'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
//                    'cout_reparation' => $diagnostic->getCoutReparation(),
//                    'conclusion' => $diagnostic->getConclusion(),
//                    'elements' => $elementData,
//                ];
//            }
//        }
//
//        if (empty($filteredDiagnostics)) {
//            return new JsonResponse(['message' => 'No diagnostics with elements found'], Response::HTTP_NOT_FOUND);
//        }
//
//        return new JsonResponse($filteredDiagnostics);
//    }

    #[Route('/diagnosticEnCours', name: 'app_diagnostic_en_cours', methods: ['GET'])]
    public function diagnosticEnCours(EntityManagerInterface $entityManager, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
        $filteredDiagnostics = [];

        foreach ($diagnostics as $diagnostic) {
            $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

            if (empty($elements)) {
                continue; // Skip diagnostics with no elements
            }

            $allElementsOK = true;

            foreach ($elements as $element) {
                if ($element->getEtatControl()->getNomEtat() !== 'OK') {
                    $allElementsOK = false;
                    break; // Break early since we found an element not OK
                }
            }

            // Only include diagnostics where not all elements are 'OK'
            if (!$allElementsOK) {
                $velo = $diagnostic->getVelo(); // Assuming getVelo() fetches the bike related to the diagnostic
                $filteredDiagnostics[] = [
                    'diagnostic' => $diagnostic,
                    'veloDetails' => [
                        'id' => $velo->getId(),
                        'couleur' => $velo->getCouleur(),
                        'marque' => $velo->getMarque(),
                        'refRecyclerie' => $velo->getRefRecyclerie(),
                        'type' => $velo->getType(),
                        'dateReception' => $velo->getDateDeReception() ? $velo->getDateDeReception()->format('Y-m-d') : null,
                    ]
                ];
            }
        }

        // Render a Twig template, passing the filtered diagnostics
        return $this->render('diagnostic_en_cour/index.html.twig', [
            'filteredDiagnostics' => $filteredDiagnostics
        ]);
    }


    #[Route('/diagnosticNonCommencer', name: 'app_diagnostic_non_commencer', methods: ['GET'])]
    public function diagnosticNonCommencer(EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
        $filteredDiagnostics = [];

        foreach ($diagnostics as $diagnostic) {
            $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

            if (empty($elements)) {
                $filteredDiagnostics[] = [
                    'id' => $diagnostic->getId(),
                    'id_velo' => $diagnostic->getVelo()->getId(),
                    'id_user' => $diagnostic->getIdUser(),
                    'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                    'cout_reparation' => $diagnostic->getCoutReparation(),
                    'conclusion' => $diagnostic->getConclusion(),
                ];
            }
        }

        if (empty($filteredDiagnostics)) {
            return new JsonResponse(['message' => 'No diagnostics without started elements found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($filteredDiagnostics);
    }




}

