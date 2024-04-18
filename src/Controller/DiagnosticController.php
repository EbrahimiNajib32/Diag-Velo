<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DiagnosticController extends AbstractController
{
    #[Route('/diagnostic', name: 'app_diagnostic')]
    public function index(): Response
    {
        return $this->render('diagnostic/index.html.twig', [
            'controller_name' => 'DiagnosticController',
        ]);
    }
}
