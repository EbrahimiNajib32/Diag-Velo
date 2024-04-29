<?php
// src/Controller/VeloController.php

namespace App\Controller;

use App\Entity\Diagnostic;
use App\Entity\Velo;
use App\Form\VeloInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;



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
        $query = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('v.id', 'p.nom_proprio', 'v.numero_de_serie', 'v.marque', 'v.ref_recyclerie', 'v.couleur', 'v.date_de_reception', 'v.type', 'v.public', 'v.date_de_vente', 'v.date_destruction')
            ->leftJoin('v.proprietaire', 'p')
            ->getQuery();

        // Pagination des résultats
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
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

        // Récupére les marques distinctes des vélos affichés dans le tableau
        $marqueQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.marque')
            ->getQuery();

        $marques = $marqueQuery->getResult();

        // Extraire uniquement les valeurs des marques
        $marques_uniques = array_map(function ($marque) {
            return $marque['marque'];
        }, $marques);

        // Requête pour obtenir les couleurs uniques
        $couleurQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.couleur')
            ->getQuery();

        $couleurs = $couleurQuery->getResult();

        // Extraction des valeurs des couleurs
        $couleurs_uniques = array_column($couleurs, 'couleur');

        // Requête pour obtenir les types uniques
        $typeQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.type')
            ->getQuery();

        $types = $typeQuery->getResult();

        // Extraction des valeurs des types
                $types_uniques = array_map(function ($type) {
                    return $type['type'];
                }, $types);

        // Requête pour obtenir les catégories de public uniques
        $publicQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.public')
            ->getQuery();

        $publics = $publicQuery->getResult();

        // Extraction des valeurs des catégories de public
        $publics_uniques = array_map(function ($public) {
            return $public['public'];
        }, $publics);


        // Passe les données au modèle Twig
        return $this->render('velo/velo_liste.html.twig', [
            'pagination' => $pagination,
            'diagnostics' => $diagnostics,
            'marques_uniques' => $marques_uniques,
            'couleurs_uniques' => $couleurs_uniques,
            'types_uniques' => $types_uniques,
            'publics_uniques' => $publics_uniques,
        ]);
    }
}