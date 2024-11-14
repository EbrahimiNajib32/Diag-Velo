<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypesDiagnosticLieuController extends AbstractController
{
    #[Route('/types/diagnostic/lieu', name: 'app_types_diagnostic_lieu')]
    public function index(): Response
    {
        return $this->render('types_diagnostic_lieu/index.html.twig', [
            'controller_name' => 'TypesDiagnosticLieuController',
        ]);
    }
}
