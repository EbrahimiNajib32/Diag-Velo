<?php
// src/Controller/VeloController.php

namespace App\Controller;

use App\Entity\Proprietaire;
use App\Entity\Diagnostic;
use App\Entity\Velo;
use App\Form\VeloInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class VeloController extends AbstractController
{
    #[Route('/velo/new', name: 'velo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $velo = new Velo();
        $form = $this->createForm(VeloInfoType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $velo->setDateDeEnregistrement(new \DateTime());

            $entityManager->persist($velo->getProprietaire());
            $entityManager->persist($velo);

            $entityManager->flush();


            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('velo/new.html.twig', [

            'form' => $form->createView(),

        ]);
    }


    #[Route('/velo/all', name: 'velo_info', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request ): Response
    {
        // Fetch bicycles with basic pagination
        $query = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')


            ->select('v.id', 'v.numero_de_serie', 'v.marque', 'v.ref_recyclerie', 'v.couleur', 'v.date_de_enregistrement', 'v.type', 'v.public', 'v.date_de_vente', 'v.date_destruction')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        // If needed, fetch diagnostics separately for each bicycle
        $diagnostics = [];
        foreach ($pagination as $velo) {
            $veloId = $velo['id'];
            $diagnosticData = $entityManager->getRepository(Diagnostic::class)->findBy(['velo' => $veloId]);
            if (!empty($diagnosticData)) {
                $diagnostics[$veloId] = $diagnosticData;
            }
        }
        foreach ($diagnostics as $veloId => $diagnosticData) {
            usort($diagnosticData, function ($a, $b) {
                return $a->getDateDiagnostic() <=> $b->getDateDiagnostic();
            });
            $diagnostics[$veloId] = $diagnosticData;
        }

        return $this->render('velo/velo_liste.html.twig', [
            'pagination' => $pagination,
            'diagnostics' => $diagnostics,
        ]);
    }

    #[Route('/api/update-velo/{id}', name: 'api_update_velo', methods: ['POST'])]
    public function updateVelo(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, $id): JsonResponse
    {
        $velo = $entityManager->getRepository(Velo::class)->find($id);
        if (!$velo) {
            return new JsonResponse(['status' => 'Velo not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        foreach ($data as $key => $value) {
            // Check for the proprietaire update specifically
            if ($key === 'proprietaireId') {
                // Handle setting the proprietaire
                $proprietaire = $entityManager->getRepository(Proprietaire::class)->find($value);
                if ($proprietaire) {
                    $velo->setProprietaire($proprietaire);
                } else {
                    // If the new proprietaire is not found, return an error response
                    return new JsonResponse(['status' => 'error', 'message' => 'Proprietaire not found'], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                $setter = 'set' . ucfirst($key);
                if (method_exists($velo, $setter)) {
                    $velo->$setter($value);
                }
            }
        }

        $errors = $validator->validate($velo);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['status' => 'error', 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
    #[Route('/velo/edit/{ref_recyclerie}', name: 'velo_edit')]
    public function editVelo(EntityManagerInterface $entityManager, Request $request, $ref_recyclerie): Response
    {
        $velo = $entityManager->getRepository(Velo::class)->findOneBy(['ref_recyclerie' => $ref_recyclerie]);

        if (!$velo) {
            $this->addFlash('error', 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.');
          ;
        }

        $form = $this->createForm(VeloInfoType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Les informations du vélo ont été mises à jour avec succès.');
        }

        return $this->render('velo/details.html.twig', [
            'velo' => $velo,
            'form' => $form->createView(),
        ]);
    }
}
