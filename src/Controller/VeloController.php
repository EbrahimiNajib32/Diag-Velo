<?php
// src/Controller/VeloController.php

namespace App\Controller;

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

        //$request->request->all());
       // $form->isSubmitted());
       // $form->isValid());

        if ($form->isSubmitted() && $form->isValid()) {
            //enregistrement du vélo
            $entityManager->persist($velo->getProprietaire());
            $entityManager->persist($velo);

            $entityManager->flush();

            // Redirection après enregistrement
            //return $this->redirectToRoute('velo_success');
        }

        return $this->render('velo/new.html.twig', [

            'form' => $form->createView(),

        ]);
    }

    #[Route('/velo/all', name: 'velo_info', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request ): Response
    {
        $query = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('v.numero_de_serie', 'v.marque', 'v.ref_recyclerie', 'v.couleur', 'v.date_de_reception', 'v.type', 'v.public', 'v.date_de_vente', 'v.date_destruction')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('velo/velo_liste.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
