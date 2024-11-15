<?php

namespace App\Controller;

use App\Entity\DiagnosticType;
use App\Entity\DiagnostictypeLieutype;
use App\Entity\TypeLieu;
use App\Repository\DiagnostictypeLieutypeRepository;
use App\Repository\DiagnosticTypeRepository;
use App\Repository\TypeLieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypesDiagnosticLieuController extends AbstractController
{
    #[Route('/types/diagnostic/lieu', name: 'app_types_diagnostic_lieu_liste')]
    public function index(DiagnosticTypeRepository $diagnosticRepo, TypeLieuRepository $lieuRepo, DiagnostictypeLieutypeRepository $mappingRepo): Response
    {
        $typesDiagnostics = $diagnosticRepo->findAll();
        $typesLieux = $lieuRepo->findAll();

        $mapping = [];
        foreach ($typesDiagnostics as $diagnostic) {
            foreach ($typesLieux as $lieu) {
                $relation = $mappingRepo->findOneBy([
                    'diagnostic_type_id' => $diagnostic,
                    'Lieu_type_id' => $lieu
                ]);
                $mapping[$diagnostic->getId()][$lieu->getId()] = $relation ? $relation->isActif() : false;
            }
        }

        return $this->render('types_diagnostic_lieu/liste.html.twig', [
            'typesDiagnostics' => $typesDiagnostics,
            'typesLieux' => $typesLieux,
            'mapping' => $mapping,
        ]);
    }

    #[Route('/toggle-status/{diagnosticId}/{lieuId}', name: 'toggle_diagnostic_lieu_status', methods: ['POST'])]
    public function toggleStatus(int $diagnosticId, int $lieuId, DiagnostictypeLieutypeRepository $mappingRepo, EntityManagerInterface $entityManager): JsonResponse {

        $diagnosticType = $entityManager->getRepository(DiagnosticType::class)->find($diagnosticId);
        $lieuType = $entityManager->getRepository(TypeLieu::class)->find($lieuId);

        if (!$diagnosticType || !$lieuType) {
            return new JsonResponse([
                'error' => 'DiagnosticType ou TypeLieu introuvable',
            ], 404);
        }

        $relation = $mappingRepo->findOneBy([
            'diagnostic_type_id' => $diagnosticType,
            'Lieu_type_id' => $lieuType,
        ]);

        if ($relation) {
            $relation->setActif(!$relation->isActif());
        } else {
            $relation = new DiagnostictypeLieutype();
            $relation->setDiagnosticTypeId($diagnosticType);
            $relation->setLieuTypeId($lieuType);
            $relation->setActif(true);

            $entityManager->persist($relation);
        }

        try {
            $entityManager->flush();

            return new JsonResponse([
                'message' => 'Statut mis à jour avec succès',
                'newStatus' => $relation->isActif(),
            ]);
        } catch (\Doctrine\DBAL\Exception $dbalException) {
            return new JsonResponse([
                'error' => 'Erreur de base de données',
                'details' => $dbalException->getMessage(),
            ], 500);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'error' => 'Erreur serveur',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }
}
