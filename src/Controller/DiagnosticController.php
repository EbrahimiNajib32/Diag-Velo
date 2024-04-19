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
                'piece' => $etat->getNomEtat(),
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
}

