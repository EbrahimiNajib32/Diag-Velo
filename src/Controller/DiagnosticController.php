<?php
// src/Controller/DiagosticController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Diagnostic;


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
                'id' => $diagnostic->getIdDiagnostic(),
                'id_velo' => $diagnostic->getIdVelo(),
                'id_user' => $diagnostic->getIdUser(),
                'date_diagnostic' => $diagnostic->getDateDiagnostic(),
                'cout_reparation' => $diagnostic->getCoutReparation(),
                'conclusion' => $diagnostic->getConclusion(),

            ];
        }


        return new JsonResponse($diagnosticData);
    }
}
