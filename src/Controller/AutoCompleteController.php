<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
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

    public function autocompleteStructures(UtilisateurRepository $utilisateurRepository, Request $request): JsonResponse
    {
        $searchText = $request->query->get('structure');
        $structures = $utilisateurRepository->findMatchingStructures($searchText);

        if (empty($structures)) {
            return new JsonResponse(['message' => 'No structures found'], 404);
        }

        $formattedStructures = [];
        foreach ($structures as $structure) {
            $formattedStructures[] = $structure['structure'];
        }

        return new JsonResponse($formattedStructures);
    }


}

