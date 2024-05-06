<?php

namespace App\Controller;

use App\Entity\DiagnosticType;
use App\Repository\DiagnosticTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class TypeDiagnosticController extends AbstractController
{
    #[Route('/type/diagnostic', name: 'app_type_diagnostic')]
public function index(EntityManagerInterface $entityManager): Response
{
    $typesDiagnostic = $entityManager->getRepository(DiagnosticType::class)->findAll();

    return $this->render('diagnostic/choixTypeDiagnostic.html.twig', [
        'typesDiagnostic' => $typesDiagnostic,
    ]);
}
}
