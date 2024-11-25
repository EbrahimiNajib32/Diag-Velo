<?php

namespace App\Controller;

use App\Entity\TypeLieu;
use App\Form\TypeLieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeLieuController extends AbstractController
{
    #[Route('/type/lieu', name: 'app_type_lieu_liste')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $status = $request->query->get('status');
        $typesLieu = [];

        if ($status === '1') {
            $typesLieu = $entityManager->getRepository(TypeLieu::class)->findBy(['actif' => true]);
        } elseif ($status === '0') {
            $typesLieu = $entityManager->getRepository(TypeLieu::class)->findBy(['actif' => false]);
        } else {
            $typesLieu = $entityManager->getRepository(TypeLieu::class)->findAll();
        }

        return $this->render('type_lieu/liste.html.twig', [
            'typesLieu' => $typesLieu,
        ]);
    }

// Route pour changer le statut
    #[Route('/dashboard/typelieu/toggle/{id}', name: 'toggle_lieu_status', methods: ['POST'])]
    public function toggleStatus(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $lieuType = $entityManager->getRepository(TypeLieu::class)->find($id);

        if (!$lieuType) {
            return new JsonResponse(['message' => 'Aucun type de lieu trouvé'], Response::HTTP_NOT_FOUND);
        }

        $lieuType->setActif(!$lieuType->isActif());
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Statut modifié avec succès',
            'newStatus' => $lieuType->isActif() ? 'Active' : 'Inactive'
        ]);
    }

    #[Route('/dashboard/typelieu/new/lieu/type', name: 'app_create_lieu_type')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeLieu = new TypeLieu();

        $form = $this->createForm(TypeLieuType::class, $typeLieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($typeLieu);
                $entityManager->flush();
            
                $this->addFlash('success', 'Nouveau type de lieu enregistré avec succès !');
                return $this->redirectToRoute('app_type_lieu_liste');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'enregistrement, Veuillez réasseyer ultérieurement');
                return $this->redirectToRoute('app_type_lieu_liste');
            }
        }

        return $this->render('type_lieu/newTypeLieu.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
