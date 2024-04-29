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
            $velo->setDateDeReception(new \DateTime());

            $base64Image = $form->get('url_photo')->getData();
            if ($base64Image && preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type) && in_array($type[1], ['png', 'jpg', 'jpeg', 'gif'])) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $data = base64_decode($data);

                $imageName = uniqid() . '.' . $type[1];
                $filePath = $this->getParameter('images_directory') . '/' . $imageName;

                // Save the image file
                if (!file_exists($this->getParameter('images_directory'))) {
                    mkdir($this->getParameter('images_directory'), 0777, true); // Ensure directory exists
                }
                file_put_contents($filePath, $data);

                $velo->setUrlPhoto($filePath);
            }

            // Persist the Velo and its Proprietaire
            if ($velo->getProprietaire()) {
                $entityManager->persist($velo->getProprietaire());
            }
            $entityManager->persist($velo);
            $entityManager->flush();

            // Redirect after saving
            return $this->redirectToRoute('app_accueil');
        }

        // Render the form if not submitted or if there are validation errors
        return $this->render('velo/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/velo/all', name: 'velo_info', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request ): Response
    {
        // Fetch bicycles with basic pagination
        $query = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('v.numero_de_serie', 'v.marque', 'v.ref_recyclerie', 'v.couleur', 'v.date_de_reception', 'v.type', 'v.public', 'v.date_de_vente', 'v.date_destruction' , 'v.id')
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

}
