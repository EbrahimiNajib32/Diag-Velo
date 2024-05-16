<?php

namespace App\Controller;

use App\Entity\DiagnosticType;
use App\Repository\DiagnosticTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class TypeDiagnosticController extends AbstractController
{
    #[Route('/type/diagnostic', name: 'app_type_diagnostic')]
    public function index(EntityManagerInterface $entityManager): Response
    // Récupérer uniquement les types de diagnostic actifs
    {
        $typesDiagnostic = $entityManager->getRepository(DiagnosticType::class)->findBy(['actif' => true]);


        return $this->render('diagnostic/choixTypeDiagnostic.html.twig', [
            'typesDiagnostic' => $typesDiagnostic,
        ]);
    }

    #[Route('/dashboard/typediagnostic', name: 'app_type_diagnostic_liste')]
    public function listeComplete(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le paramètre 'status' de la requête, qui peut être null
        $status = $request->query->get('status');

        // Filtrer les diagnostics en fonction du statut si spécifié, sinon récupérer tous
        if ($status !== null && $status !== '') {
            $isActive = filter_var($status, FILTER_VALIDATE_BOOLEAN);
            $typesDiagnostic = $entityManager->getRepository(DiagnosticType::class)->findBy(['actif' => $isActive]);
        } else {
            $typesDiagnostic = $entityManager->getRepository(DiagnosticType::class)->findAll();
        }

        return $this->render('type_diagnostic/liste.html.twig', [
            'typesDiagnostic' => $typesDiagnostic,
        ]);
    }

    // Route pour changer le statut

    #[Route('/dashboard/typediagnostic/toggle/{id}', name: 'toggle_diagnostic_status', methods: ['POST'])]
    public function toggleStatus(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnosticType = $entityManager->getRepository(DiagnosticType::class)->find($id);

        if (!$diagnosticType) {
            return new JsonResponse(['message' => 'Aucun type de diagnostic trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Toggle le statut
        $diagnosticType->setActif(!$diagnosticType->isActif());
        $entityManager->flush();

        // Return the new status
        return new JsonResponse([
            'message' => 'Statut modifié avec succès',
            'newStatus' => $diagnosticType->isActif() ? 'Active' : 'Inactive'
        ]);
    }
}
