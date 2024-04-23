<?php
namespace App\Controller;

use App\Entity\Velo;
use App\Form\SearchVeloType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {


        $searchForm = $this->createForm(SearchVeloType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
        $refRecyclerie = $searchForm->get('ref_recyclerie_search')->getData();

            return $this->redirectToRoute('velo_details', ['ref_recyclerie' => $refRecyclerie]);
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'searchForm' => $searchForm->createView(),
        ]);
    }
#[Route('/velo/details/{ref_recyclerie?}', name: 'velo_details')]
public function veloDetails(EntityManagerInterface $entityManager, Request $request, $ref_recyclerie = null): Response
{
    if ($ref_recyclerie === null) {
        $refRecyclerie = $request->query->get('ref_recyclerie');
    }
    $velo = $entityManager->getRepository(Velo::class)->findOneBy(['ref_recyclerie' => $refRecyclerie]);

    if (!$velo) {
        $this->addFlash('error', 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.');
        return $this->redirectToRoute('app_accueil');
    }

    return $this->render('velo/détails/velo_details.html.twig', ['velo' => $velo]);
}
}
