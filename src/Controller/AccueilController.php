<?php
// Importer les classes nécessaires
namespace App\Controller;

use App\Entity\Velo;
use App\Form\SearchVeloType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request): Response
    {
        // Créer le formulaire de recherche de vélo
        $searchForm = $this->createForm(SearchVeloType::class);
        $searchForm->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // Récupérer la référence de recyclérie saisie par l'utilisateur
            $refRecyclerie = $searchForm->getData()['ref_recyclerie_search'];

            // Rechercher le vélo correspondant dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $velo = $entityManager->getRepository(Velo::class)->findOneBy(['ref_recyclerie' => $refRecyclerie]);

            // Si un vélo correspondant est trouvé, passer ses informations au template
            if ($velo) {
                return $this->render('accueil/velo_details.html.twig', [
                    'velo' => $velo,
                ]);
            } else {
                // Gérer le cas où aucun vélo n'est trouvé avec la référence de recyclérie spécifiée
                // Par exemple, afficher un message d'erreur ou rediriger vers une autre page
                return $this->render('accueil/index.html.twig', [
                    'controller_name' => 'AccueilController',
                    'searchForm' => $searchForm->createView(),
                    'error_message' => 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.',
                ]);
            }
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher la page d'accueil avec le formulaire
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('/velo/details/{ref_recyclerie?}', name: 'velo_details')]
    public function veloDetails($ref_Recyclerie = null): Response
    {
        // Obtenez le gestionnaire d'entités de Doctrine en utilisant $this->getDoctrine()
        $entityManager = $this->getDoctrine()->getManager();

        // Recherchez le vélo correspondant dans la base de données en fonction de la référence de recyclérie
        $velo = $entityManager->getRepository(Velo::class)->findOneBy(['ref_recyclerie' => $refRecyclerie]);

        // Si un vélo correspondant est trouvé, passez ses informations au template
        if ($velo) {
            return $this->render('accueil/velo_details.html.twig', [
                'velo' => $velo,
            ]);
        } else {
            // Gérer le cas où aucun vélo n'est trouvé avec la référence de recyclérie spécifiée
            // Par exemple, afficher un message d'erreur ou rediriger vers une autre page
            return $this->render('accueil/velo_details.html.twig', [
                'error_message' => 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.',
            ]);
        }
    }
}
