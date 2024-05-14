<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Proprietaire;

class AutoCompleteController extends AbstractController
{
    #[Route('/autocomplete', name: 'autocomplete')]
    public function autocompleteProprietaires(Request $request): JsonResponse
    {
        $term = $request->query->get('term');

        $proprietaireRepository = $this->getDoctrine()->getRepository(Proprietaire::class);
        $proprietaires = $proprietaireRepository->findMatchingProprietaires($term);

        $formattedProprietaires = [];

        foreach ($proprietaires as $proprietaire) {
            $formattedProprietaires[] = [
                'id' => $proprietaire->getId(),
                'text' => $proprietaire->getNomProprio(),
            ];
        }

        return new JsonResponse($formattedProprietaires);
    }
}

?>