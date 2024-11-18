<?php
namespace App\Controller;

use App\Entity\Velo;
use App\Form\SearchVeloType;
use App\Form\LieuType;
use App\Entity\Lieu;
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
        //Récupération des lieux disponibles
        $lieu_disponible = $entityManager->getRepository(Lieu::class)->findAll();

        // Formulaire de création de lieu
        $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuType::class, $lieu);
        $lieuForm->handleRequest($request);

        if ($lieuForm->isSubmitted() && $lieuForm->isValid()) {
            $entityManager->persist($lieu);
            $entityManager->flush();

            $this->addFlash('success', 'Lieu ajouté avec succès.');
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'lieuForm' => $lieuForm->createView(),
            'lieu_disponible' => $lieu_disponible,
        ]);
    }
}
