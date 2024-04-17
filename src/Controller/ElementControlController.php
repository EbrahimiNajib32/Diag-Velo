<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ElementControlController extends AbstractController
{
    #[Route('/element/control', name: 'app_element_control')]
    public function index(): Response
    {
        return $this->render('element_control/index.html.twig', [
            'controller_name' => 'ElementControlController',
        ]);
    }
}
