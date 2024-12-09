<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    // Route pour la page index.html.twig
    #[Route('/statistics', name: 'app_statistics_index')]
    public function index(): Response
    {
        return $this->render('statistics/index.html.twig', [
            'controller_name' => 'StatisticsController',
        ]);
    }

    // Route pour la page Statistiques.twig
    #[Route('/statistiques', name: 'app_statistics_statistiques')]
    public function statistiques(): Response
    {
        return $this->render('statistics/Statistiques.twig');
    }
}
