<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Proprietaire;


class AutoCompleteController extends AbstractController
{
    #[Route('/autocomplete', name: 'autocomplete')]
    public function autocompleteProprietaires(Request $request , EntityManagerInterface $entityManager): JsonResponse
    {
        $term = $request->query->get('term');

        $proprietaireRepository = $entityManager->getRepository(Proprietaire::class);
        $proprietaires = $proprietaireRepository->findMatchingProprietaires($term);

        $formattedProprietaires = [];

        foreach ($proprietaires as $proprietaire) {
            $formattedProprietaires[] = [
                'nom_proprio' => $proprietaire->getNomProprio(),
                'id_proprio' => $proprietaire->getId(),
            ];
        }

        return new JsonResponse($formattedProprietaires);
    }
}

