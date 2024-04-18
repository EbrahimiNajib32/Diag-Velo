<?php
// Importer les classes nécessaires
namespace App\Controller;

use App\Entity\Velo;
use App\Form\SearchVeloType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; // Gardez cette ligne ici, une seule fois

class AccueilController extends AbstractController
{
    // Route pour la page d'accueil
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request): Response
    {
        // Créer le formulaire de recherche de vélo
        $searchForm = $this->createForm(SearchVeloType::class);
        $searchForm->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $refRecyclerie = $searchForm->getData()['ref_recyclerie_search'];

            $entityManager = $this->getDoctrine()->getManager();
            $velo = $entityManager->getRepository(Velo::class)->findOneBy(['ref_recyclerie' => $refRecyclerie]);

            if ($velo) {
                return $this->render('accueil/velo_details.html.twig', [
                    'velo' => $velo,
                ]);
            } else {
                return $this->render('accueil/index.html.twig', [
                    'controller_name' => 'AccueilController',
                    'searchForm' => $searchForm->createView(),
                    'error_message' => 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.',
                ]);
            }
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'searchForm' => $searchForm->createView(),
        ]);
    }

    // Route pour les détails du vélo
    #[Route('/velo/details/{ref_recyclerie?}', name: 'velo_details')]
    public function veloDetails(EntityManagerInterface $entityManager, $ref_recyclerie = null): Response
    {
        $velo = $entityManager->getRepository(Velo::class)->findOneBy(['ref_recyclerie' => $ref_recyclerie]);

        if ($velo) {
            return $this->render('accueil/velo_details.html.twig', [
                'velo' => $velo,
            ]);
        } else {
            return $this->render('accueil/velo_details.html.twig', [
                'error_message' => 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.',
            ]);
        }
    }
}
