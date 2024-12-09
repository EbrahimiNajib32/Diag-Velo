<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FooterController extends AbstractController
{
    #[Route('/Légales', name: 'app_legal')]
    public function index(): Response
    {
        return $this->render('footer/mention_legale.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }
    #[Route('/À_propos', name: 'app_propos')]
    public function a_propos(): Response
    {
        return $this->render('footer/a_propos.twig', [
            'controller_name' => 'FooterController',
        ]);
    }
}
