<?php
namespace App\Controller;

use App\Entity\Velo;
use App\Form\SearchVeloType;
use App\Form\LieuType;
use App\Entity\Lieu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {

        // Supprimer le lieu de la session
        $session->remove('lieu');

        //Récupération des lieux disponibles
        $lieu_disponible = $entityManager->getRepository(Lieu::class)->findAll();

        // Formulaire de création de lieu
        $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuType::class, $lieu);
        $lieuForm->handleRequest($request);

        if ($lieuForm->isSubmitted() && $lieuForm->isValid()) {
            $entityManager->persist($lieu);
            $entityManager->flush();

            // Stocker toutes les informations dans la session
            $session->set('lieu', [
                'id' => $lieu->getId(),
                'nom' => $lieu->getNomLieu(),
                'adresse' => $lieu->getAdresseLieu(),
                'ville' => $lieu->getVille(),
                'codePostal' => $lieu->getCodePostal(),
                'idType' => $lieu->getTypeLieuId(),
                'nomType' => $lieu->getTypeLieuId()->getNomTypeLieu()
            ]);
            
            $this->addFlash('success', 'Lieu ajouté avec succès.');
            return $this->redirectToRoute('app_diagnostic_en_cours');
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'lieuForm' => $lieuForm->createView(),
            'lieu_disponible' => $lieu_disponible,
        ]);
    }
    #[Route('/lieu/{id}', name: 'app_lieu_choisi')]
    public function lieuChoisi(int $id, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $lieu = $entityManager->getRepository(Lieu::class)->find($id);

        if (!$lieu) {
            throw $this->createNotFoundException('Lieu non trouvé.');
        }

        $session->set('lieu', [
            'id' => $lieu->getId(),
            'nom' => $lieu->getNomLieu(),
            'adresse' => $lieu->getAdresseLieu(),
            'ville' => $lieu->getVille(),
            'codePostal' => $lieu->getCodePostal(),
            'idType' => $lieu->getTypeLieuId(),
            'nomType' => $lieu->getTypeLieuId()->getNomTypeLieu()
        ]);

        return $this->redirectToRoute('app_diagnostic_en_cours');
    }

}
