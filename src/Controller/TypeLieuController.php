<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeLieuController extends AbstractController
{
    #[Route('/type/lieu', name: 'app_type_lieu')]
    public function index(): Response
    {
        return $this->render('type_lieu/index.html.twig', [
            'controller_name' => 'TypeLieuController',
        ]);
    }
}
