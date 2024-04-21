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
    public function diagnosticById(int $id, EntityManagerInterface $entityManager): Response
    {
        $diagnostic = $entityManager->getRepository(Diagnostic::class)->find($id);

        if (!$diagnostic) {
            $content = $this->renderView('error/404.html.twig', [
                'message' => 'Diagnostic not found'
            ]);
            return new Response($content, Response::HTTP_NOT_FOUND);
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

        return $this->render('diagnostic/show.html.twig', [
            'diagnostic' => $diagnostic,
            'elements' => $elementData,
        ]);
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
    public function diagnosticEnCours(EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
        $filteredDiagnostics = [];

        foreach ($diagnostics as $diagnostic) {
            $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

            if (empty($elements)) {
                continue;
            }

            $unfinishedElements = [];
            $allElementsOK = true;

            foreach ($elements as $element) {
                $etat = $element->getEtatControl();
                $veloElement = $element->getElementControl();

                if ($etat->getNomEtat() !== 'OK') {
                    $allElementsOK = false;
                    $unfinishedElements[] = [
                        'id' => $element->getId(),
                        'commentaire' => $element->getCommentaire(),
                        'element' => $veloElement->getElement(),
                        'etat' => $etat->getNomEtat(),
                    ];
                }
            }

            if (!$allElementsOK) {
                $filteredDiagnostics[] = [
                    'id' => $diagnostic->getId(),
                    'id_velo' => $diagnostic->getVelo()->getId(),
                    'id_user' => $diagnostic->getIdUser(),
                    'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                    'cout_reparation' => $diagnostic->getCoutReparation(),
                    'conclusion' => $diagnostic->getConclusion(),
                    'elements' => $unfinishedElements,
                ];
            }
        }

        if (empty($filteredDiagnostics)) {
            return new JsonResponse(['message' => 'No unfinished diagnostics found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($filteredDiagnostics);
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

