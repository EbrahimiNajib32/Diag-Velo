<?php

namespace App\Controller;

use App\Entity\DiagnosticType;
use App\Entity\DiagnosticTypeElementcontrol;
use App\Entity\ElementControl;
use App\Form\TypeDiagnosticType;
use App\Repository\DiagnosticTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class TypeDiagnosticController extends AbstractController
{
    #[Route('/type/diagnostic', name: 'app_type_diagnostic')]
    public function index(EntityManagerInterface $entityManager, SessionInterface $session,): Response
    // Récupérer uniquement les types de diagnostic actifs
    {

        // Récupérer le lieu depuis la session
        $lieu = $session->get('lieu');

        // Si le lieu n'est pas trouvé dans la session, vous pouvez choisir de rediriger l'utilisateur ou afficher un message d'erreur
        if (!$lieu) {
            $this->addFlash('error', 'Aucun lieu sélectionné.');
            return $this->redirectToRoute('app_accueil');
        }

        $typesDiagnostic = $entityManager->getRepository(DiagnosticType::class)->findBy(['actif' => true]);


        // Passer le lieu et les types de diagnostics au template
        return $this->render('diagnostic/choixTypeDiagnostic.html.twig', [
            'lieu' => $lieu, // Passer le lieu au template
            'typesDiagnostic' => $typesDiagnostic, // Passer les types de diagnostics
        ]);
    }

    #[Route('/dashboard/typediagnostic', name: 'app_type_diagnostic_liste')]
    public function listeComplete(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le paramètre 'status' de la requête, qui peut être null
        $status = $request->query->get('status');

        // Filtrer les diagnostics en fonction du statut si spécifié, sinon récupérer tous
        if ($status !== null && $status !== '') {
            $isActive = filter_var($status, FILTER_VALIDATE_BOOLEAN);
            $typesDiagnostic = $entityManager->getRepository(DiagnosticType::class)->findBy(['actif' => $isActive]);
        } else {
            $typesDiagnostic = $entityManager->getRepository(DiagnosticType::class)->findAll();
        }

        return $this->render('type_diagnostic/liste.html.twig', [
            'typesDiagnostic' => $typesDiagnostic,
        ]);
    }



// Route pour changer le statut

    #[Route('/dashboard/typediagnostic/toggle/{id}', name: 'toggle_diagnostic_status', methods: ['POST'])]
    public function toggleStatus(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnosticType = $entityManager->getRepository(DiagnosticType::class)->find($id);

        if (!$diagnosticType) {
            return new JsonResponse(['message' => 'Aucun type de diagnostic trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Toggle le statut
        $diagnosticType->setActif(!$diagnosticType->isActif());
        $entityManager->flush();

        // Return the new status
        return new JsonResponse([
            'message' => 'Statut modifié avec succès',
            'newStatus' => $diagnosticType->isActif() ? 'Active' : 'Inactive'
        ]);
    }
    #[Route('/dashboard/typediagnostic/new/diagnostic/type', name: 'app_create_diagnostic_type')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $diagnosticType = new DiagnosticType();

        $form = $this->createForm(TypeDiagnosticType::class, $diagnosticType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diagnosticType->setDateCreationType(new \DateTime());
            $diagnosticType->setActif(true);
            $selectedElements = $request->request->all('elements');

            if (is_array($selectedElements)) {
                foreach ($selectedElements as $elementId) {
                    $element = $entityManager->getRepository(ElementControl::class)->find($elementId);
                    if ($element) {
                        $diagnosticTypeElementControl = new DiagnosticTypeElementControl();
                        $diagnosticTypeElementControl->setIdDianosticType($diagnosticType);
                        $diagnosticTypeElementControl->setIdElementcontrol($element);
                        $entityManager->persist($diagnosticTypeElementControl);
                    }
                }
            }

            $entityManager->persist($diagnosticType);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_diagnostic');
        }

        $elements = $entityManager->getRepository(ElementControl::class)->findAll();
        $elementsByCategory = [];

        foreach ($elements as $element) {
            $category = explode(':', $element->getElement())[0];
            if (!isset($elementsByCategory[$category])) {
                $elementsByCategory[$category] = [];
            }
            $elementsByCategory[$category][] = $element;
        }

        return $this->render('type_diagnostic/newTypeDiagnostic.html.twig', [
            'form' => $form->createView(),
            'elementsByCategory' => $elementsByCategory,
        ]);
    }

}
