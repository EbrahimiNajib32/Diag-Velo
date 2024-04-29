<?php
// src/Controller/DiagosticController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Diagnostic;
use App\Entity\DiagnosticElement;
use App\Entity\EtatControl;
use App\Entity\ElementControl;
use App\Form\DiagnosticType;


use Doctrine\ORM\EntityManagerInterface;

class DiagnosticController extends AbstractController
{
    #[Route('/diagnostic', name: 'app_diagnostic', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
        $diagnosticData = [];

        foreach ($diagnostics as $diagnostic) {
            $diagnosticData[] = [
                'id' => $diagnostic->getId(),
                'id_velo' => $diagnostic->getVelo()->getId(),
                'id_user' => $diagnostic->getIdUser(),
                'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                'cout_reparation' => $diagnostic->getCoutReparation(),
                'conclusion' => $diagnostic->getConclusion(),
            ];
        }

        return new JsonResponse($diagnosticData);
    }

    #[Route('/diagnostic/{id}', name: 'app_diagnostic_by_id', methods: ['GET'])]
    public function diagnosticById(int $id, EntityManagerInterface $entityManager): Response
    {
        $diagnostic = $entityManager->getRepository(Diagnostic::class)->find($id);

        if (!$diagnostic) {
            $content = $this->renderView('error/404.html.twig', [
                'message' => 'Diagnostic not found'
            ]);
            return new Response($content, Response::HTTP_NOT_FOUND);
        }


        $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

        $categorizedElements = [];
        foreach ($elements as $element) {
            $etat = $element->getEtatControl();
            $veloElement = $element->getElementControl();
            $fullElement = $veloElement->getElement();
            $parts = explode(':', $fullElement);
            $category = $parts[0];
            $detail = $parts[1] ?? '';

            if (!array_key_exists($category, $categorizedElements)) {
                $categorizedElements[$category] = [];
            }

            $categorizedElements[$category][] = [
                'id' => $element->getId(),
                'commentaire' => $element->getCommentaire(),
                'detail' => $detail,
                'etat' => $etat->getNomEtat(),
            ];
        }

        // Fetch the bike details associated with the diagnostic
        $bike = $diagnostic->getVelo();
        $bikeDetails = [
            'id' => $bike->getId(),
            'numero_de_serie' => $bike->getNumeroDeSerie(),
            'ref_recyclerie' => $bike->getRefRecyclerie(),
            'marque' => $bike->getMarque(),
            'type' => $bike->getType(),
            'couleur' => $bike->getCouleur(),
            'taille_roues' => $bike->getTailleRoues(),
            'taille_cadre' => $bike->getTailleCadre(),
        ];

        $diagnosticData = [
            'id' => $diagnostic->getId(),
            'id_velo' => $diagnostic->getVelo()->getId(),
            'id_user' => $diagnostic->getIdUser(),
            'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
            'cout_reparation' => $diagnostic->getCoutReparation(),
            'conclusion' => $diagnostic->getConclusion(),
        ];

        return $this->render('diagnostic/show.html.twig', [
            'diagnostic' => $diagnostic,
            'bike' => $bikeDetails,
            'categorizedElements' => $categorizedElements
        ]);
    }





//    #[Route('/diagnosticAvecElement', name: 'app_diagnostics_avec_elements', methods: ['GET'])]
//    public function diagnosticAvecElement(EntityManagerInterface $entityManager): JsonResponse
//    {
//
//        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
//
//        $filteredDiagnostics = [];
//
//
//        foreach ($diagnostics as $diagnostic) {
//            $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);
//
//            if (!empty($elements)) {
//                $elementData = [];
//                foreach ($elements as $element) {
//                    $etat = $element->getEtatControl();
//                    $veloElement = $element->getElementControl();
//
//                    $elementData[] = [
//                        'id' => $element->getId(),
//                        'commentaire' => $element->getCommentaire(),
//                        'element' => $veloElement->getElement(),
//                        'etat' => $etat->getNomEtat(),
//                    ];
//                }
//
//                $filteredDiagnostics[] = [
//                    'id' => $diagnostic->getId(),
//                    'id_velo' => $diagnostic->getVelo()->getId(),
//                    'id_user' => $diagnostic->getIdUser(),
//                    'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
//                    'cout_reparation' => $diagnostic->getCoutReparation(),
//                    'conclusion' => $diagnostic->getConclusion(),
//                    'elements' => $elementData,
//                ];
//            }
//        }
//
//        if (empty($filteredDiagnostics)) {
//            return new JsonResponse(['message' => 'No diagnostics with elements found'], Response::HTTP_NOT_FOUND);
//        }
//
//        return new JsonResponse($filteredDiagnostics);
//    }

// route pour l'affichage uniquement des diagnostics en cours
#[Route('/diagnosticEnCours', name: 'app_diagnostic_en_cours', methods: ['GET'])]
public function diagnosticEnCours(EntityManagerInterface $entityManager, \Symfony\Component\HttpFoundation\Request $request): Response
{
    $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
    $filteredDiagnostics = [];

    foreach ($diagnostics as $diagnostic) {
        // Remplacez la vérification du nombre d'éléments "OK" par l'utilisation du statut de l'entité Diagnostic
        if ($diagnostic->getStatus() === 'en cours') {
            $velo = $diagnostic->getVelo();
            $filteredDiagnostics[] = [
                'diagnostic' => $diagnostic,
                'veloDetails' => [
                    'id' => $velo->getId(),
                    'couleur' => $velo->getCouleur(),
                    'marque' => $velo->getMarque(),
                    'refRecyclerie' => $velo->getRefRecyclerie(),
                    'type' => $velo->getType(),
                    'dateReception' => $velo->getDateDeEnregistrement() ? $velo->getDateDeEnregistrement()->format('Y-m-d') : null,
                ]
            ];
        }
    }

    // Render a Twig template, passing the filtered diagnostics
    return $this->render('diagnostic_en_cour/index.html.twig', [
        'filteredDiagnostics' => $filteredDiagnostics
    ]);
}

    #[Route('/diagnosticNonCommencer', name: 'app_diagnostic_non_commencer', methods: ['GET'])]
    public function diagnosticNonCommencer(EntityManagerInterface $entityManager): JsonResponse
    {
        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
        $filteredDiagnostics = [];

        foreach ($diagnostics as $diagnostic) {
            $elements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

            if (empty($elements)) {
                $filteredDiagnostics[] = [
                    'id' => $diagnostic->getId(),
                    'id_velo' => $diagnostic->getVelo()->getId(),
                    'id_user' => $diagnostic->getIdUser(),
                    'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                    'cout_reparation' => $diagnostic->getCoutReparation(),
                    'conclusion' => $diagnostic->getConclusion(),
                ];
            }
        }

        if (empty($filteredDiagnostics)) {
            return new JsonResponse(['message' => 'No diagnostics without started elements found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($filteredDiagnostics);
    }
    #[Route('/new/diagnostic', name: 'diagnostic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $diagnostic = new Diagnostic();
        $form = $this->createForm(DiagnosticType::class, $diagnostic);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $diagnostic->setDateDiagnostic(new \DateTime());

            $entityManager->persist($diagnostic);
            $entityManager->flush();

            $elements = $entityManager->getRepository(ElementControl::class)->findAll();
            foreach ($elements as $element) {
                $etatKey = 'etat_' . $element->getId();
                $commentKey = 'commentaire_' . $element->getId();

                if ($form->has($etatKey) && $form->has($commentKey)) {
                    $etatId = $form->get($etatKey)->getData();
                    $comment = $form->get($commentKey)->getData();

                    $etatControl = null;

                    if ($etatId) {
                        $etatControl = $entityManager->getRepository(EtatControl::class)->find($etatId);

                        if (!$etatControl) {
                            continue;
                        }
                    } else {
                        continue;
                    }

                    $diagnosticElement = $entityManager->getRepository(DiagnosticElement::class)->findOneBy([
                        'diagnostic' => $diagnostic,
                        'elementcontrol' => $element
                    ]) ?? new DiagnosticElement();

                    $diagnosticElement->setDiagnostic($diagnostic);
                    $diagnosticElement->setElementControl($element);
                    if ($etatControl) {
                        $diagnosticElement->setEtatControl($etatControl);
                    }
                    $diagnosticElement->setCommentaire($comment);

                    $entityManager->persist($diagnosticElement);
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        $elements = $entityManager->getRepository(ElementControl::class)->findAll();
        $categorizedElements = [];
        foreach ($elements as $element) {
            $fullElement = $element->getElement();
            $parts = explode(':', $fullElement);
            $category = $parts[0];
            if (!array_key_exists($category, $categorizedElements)) {
                $categorizedElements[$category] = [];
            }
            $categorizedElements[$category][] = $element;
        }

        return $this->render('diagnostic/new.html.twig', [
            'diagnosticForm' => $form->createView(),
            'diagnosticElements' => $categorizedElements,
        ]);
    }
    #[Route('/diagnostic/reprendre/{id}', name: 'reprendre_diagnostic', methods: ['GET', 'POST'])]
    public function reprendreDiagnostic(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $diagnostic = $entityManager->getRepository(Diagnostic::class)->find($id);
        if (!$diagnostic) {
            $this->addFlash('error', 'Diagnostic not found.');
            return $this->redirectToRoute('app_error');
        }

        $diagnosticElements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);
        $form = $this->createForm(DiagnosticType::class, $diagnostic, [
            'diagnostic' => $diagnostic,
            'diagnosticElements' => $diagnosticElements
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elements = $entityManager->getRepository(ElementControl::class)->findAll();

            foreach ($elements as $element) {
                $etatField = 'etat_' . $element->getId();
                $commentField = 'commentaire_' . $element->getId();

                $etatValue = $form->has($etatField) ? $form->get($etatField)->getData() : null;
                $commentValue = $form->has($commentField) ? $form->get($commentField)->getData() : null;

                $diagElement = $entityManager->getRepository(DiagnosticElement::class)->findOneBy([
                    'diagnostic' => $diagnostic,
                    'elementcontrol' => $element
                ]);

                if (!$diagElement) {
                    $diagElement = new DiagnosticElement();
                    $diagElement->setDiagnostic($diagnostic);
                    $diagElement->setElementControl($element);

                }

                if ($etatValue !== null) {
                    $etatControl = $entityManager->getRepository(EtatControl::class)->find($etatValue);
                    if ($etatControl) {
                        $diagElement->setEtatControl($etatControl);
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }

                $diagElement->setCommentaire($commentValue);
                $entityManager->persist($diagElement);
            }

            $entityManager->flush();
            $this->addFlash('success', 'Diagnostic updated successfully.');
            return $this->redirectToRoute('app_diagnostic_en_cours');
        }

        $elements = $entityManager->getRepository(ElementControl::class)->findAll();
        $categorizedElements = [];
        foreach ($elements as $element) {
            $fullElement = $element->getElement();
            $parts = explode(':', $fullElement);
            $category = $parts[0];
            if (!array_key_exists($category, $categorizedElements)) {
                $categorizedElements[$category] = [];
            }
            $categorizedElements[$category][] = $element;
        }

        return $this->render('diagnostic/reprendre.html.twig', [
            'diagnosticForm' => $form->createView(),
            'diagnostic' => $diagnostic,
            'diagnosticElements' => $categorizedElements,
        ]);
    }

    #[Route('/diagnostics/velo/{id}', name: 'app_diagnostics_by_velo_id', methods: ['GET'])]
    public function diagnosticsByVeloId(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les diagnostics associés au vélo en fonction de son ID
        $query = $entityManager->createQuery(
            'SELECT d FROM App\Entity\Diagnostic d WHERE d.id_velo = :id'
        )->setParameter('id', $id);

        $diagnostics = $query->getResult();

        // Construire la réponse avec les détails des diagnostics
        $diagnosticsData = [];
        foreach ($diagnostics as $diagnostic) {
            $diagnosticsData[] = [
                'id' => $diagnostic->getId(),
                'id_velo' => $diagnostic->getIdVelo(),
                'id_user' => $diagnostic->getIdUser(),
                'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                'cout_reparation' => $diagnostic->getCoutReparation(),
                'conclusion' => $diagnostic->getConclusion(),
                // Ajoutez d'autres détails du diagnostic si nécessaire
            ];
        }

        // Retourner les détails des diagnostics au format JSON
        return new JsonResponse($diagnosticsData);
    }
}

