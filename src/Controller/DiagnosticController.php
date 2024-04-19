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
            $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

            $elementData = [];
            foreach ($elements as $element) {
                $etat = $element->getEtatControl();
                $veloElement = $element->getElementControl();

                $elementData[] = [
                    'id' => $element->getId(),
                    'commentaire' => $element->getCommentaire(),
                    'element' => $veloElement->getElement(),
                    'piece'=>$etat->getNomEtat(),
                ];
            }

            $diagnosticData[] = [
                'id' => $diagnostic->getId(),
                'id_velo' => $diagnostic->getVelo()->getId(), // Assuming getVelo() returns an object from which you can get the ID.
                'id_user' => $diagnostic->getIdUser(), // Directly use the user ID, no need to call getId() on it.
                'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                'cout_reparation' => $diagnostic->getCoutReparation(),
                'conclusion' => $diagnostic->getConclusion(),
                'elements' => $elementData,
            ];
        }

        return new JsonResponse($diagnosticData);
    }
}
