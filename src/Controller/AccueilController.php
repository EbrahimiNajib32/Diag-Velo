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
    public function index(Request $request): Response
    {$velo = $entityManager->getRepository(velo::class)->findOneBy(['ref_recyclerie' => $ref_recyclerie]);
        $searchForm = $this->createForm(SearchVeloType::class); // Utilisation de SearchVeloType avec la bonne casse
        $searchForm->handleRequest($request);

      if ($searchForm->isSubmitted() && $searchForm->isValid()) {
          $refRecyclerie = $searchForm->get('ref_recyclerie')->getData(); // Récupère la valeur du champ ref_recyclerie

          // Rediriger vers la page de détails du vélo avec le numéro de recyclérie
          return $this->redirectToRoute('velo_details', ['ref_recyclerie' => $refRecyclerie]);
      }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('/velo/details/{ref_recyclerie?}', name: 'velo_details')]
    public function veloDetails(EntityManagerInterface $entityManager, $ref_recyclerie = null): Response
    {
        $velo = $entityManager->getRepository(Velo::class)->findOneBy(['ref_recyclerie' => $ref_recyclerie]); // Utilisation de Velo avec la bonne casse

        if ($velo) {
            return $this->render('velo/détails/velo_details.html.twig', ['velo' => $velo]);
        } else {
            $this->addFlash('error', 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.');
            return $this->redirectToRoute('app_accueil', ['error_message' => 'Aucun vélo trouvé avec la référence de recyclérie spécifiée.']);
        }
    }
}