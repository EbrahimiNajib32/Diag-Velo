<?php
 //src/Controller/DiagosticController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Lieu;
use App\Entity\TypeLieu;
use App\Entity\Diagnostic;
use App\Entity\DiagnosticElement;
use App\Entity\EtatControl;
use App\Entity\ElementControl;
use App\Entity\DiagnosticType;
use App\Entity\DiagnosticTypeElementcontrol;
use App\Entity\DiagnostictypeLieutype;
use App\Entity\Proprietaire;
use App\Entity\Utilisateur;
use App\Form\FormDiagnosticType;
use App\Form\TypeDiagnosticType;
use App\Entity\Velo;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;






class DiagnosticController extends AbstractController
{
    #[Route('/diagnostic', name: 'app_diagnostic', methods: ['GET'])]
        public function index(EntityManagerInterface $entityManager): JsonResponse
        {
            // Récupérer tous les diagnostics
            $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();
            $diagnosticData = [];

            foreach ($diagnostics as $diagnostic) {
                // Récupérer l'entité Lieu associée à ce diagnostic
                $lieu = $diagnostic->getLieuId() ? $entityManager->getRepository(Lieu::class)->find($diagnostic->getLieuId()) : null;

                $typeLieu = $lieu ? $lieu->getTypeLieuId() : null;  // On récupère le type de lieu associé au lieu
                $typeLieuNom = $typeLieu ? $typeLieu->getNomTypeLieu() : 'Non défini';  // Récupération du nom du type de lieu

                // Ajouter les données du diagnostic, y compris celles du lieu et du type de lieu
                $diagnosticData[] = [
                    'id' => $diagnostic->getId(),
                    'id_velo' => $diagnostic->getVelo()->getId(),
                    'id_user' => $diagnostic->getIdUser(),
                    'date_diagnostic' => $diagnostic->getDateDiagnostic()->format('Y-m-d H:i:s'),
                    'cout_reparation' => $diagnostic->getCoutReparation(),
                    'conclusion' => $diagnostic->getConclusion(),
                    'lieu_nom' => $lieu ? $lieu->getNomLieu() : 'Non défini',
                    'lieu_ville' => $lieu ? $lieu->getVille() : 'Non défini',
                    'type_lieu_nom' => $typeLieuNom,
                ];
            }

            return new JsonResponse($diagnosticData);
    }



    #[Route('/diagnostic/{id}', name: 'app_diagnostic_by_id', methods: ['GET'])]
    public function diagnosticById(
        int $id,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {
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

        // Récupérer le nom du type de diagnostic
        $diagnosticType = $diagnostic->getDiagnosticType();
        $nomType = $diagnosticType ? $diagnosticType->getNomType() : 'Type non défini';

        // Récupérer les informations sur le lieu et le type de lieu
        $lieu = $diagnostic->getLieuId() ? $entityManager->getRepository(Lieu::class)->find($diagnostic->getLieuId()) : null;

        $typeLieu = $lieu ? $lieu->getTypeLieuId() : null;
        $typeLieuNom = $typeLieu ? $typeLieu->getNomTypeLieu() : 'Non défini';
        $lieuNom = $lieu ? $lieu->getNomLieu() : 'Non défini';
        $lieuVille = $lieu ? $lieu->getVille() : 'Non défini';

        // Récupérer les détails du vélo associé au diagnostic
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

        // Préparer les données du diagnostic
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
            'categorizedElements' => $categorizedElements,
            'nomType' => $nomType,
            'typeLieuNom' => $typeLieuNom,
            'lieuNom' => $lieuNom,
            'lieuVille' => $lieuVille,
        ]);
    }


// route pour l'affichage uniquement des diagnostics en cours
#[Route('/diagnosticEnCours', name: 'app_diagnostic_en_cours', methods: ['GET'])]
public function diagnosticEnCours(EntityManagerInterface $entityManager, SessionInterface $session, \Symfony\Component\HttpFoundation\Request $request): Response
{
    $diagnostics = $entityManager->getRepository(Diagnostic::class)->findBy(
        ['Lieu_id' => $session->get('lieu')['id']]
    );

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
                    'numeroSerie' => $velo->getNumeroDeSerie(),
                    'bicycode' => $velo->getBicycode(),
                    'type' => $velo->getType(),
                    'proprio' => $velo->getProprietaire(),
                    'dateDeEnregistrement' => $velo->getDateDeEnregistrement() ? $velo->getDateDeEnregistrement()->format('Y-m-d') : null,
                ]
            ];
        }
    }

    // Render a Twig template, passing the filtered diagnostics
    dump($session->all());
    return $this->render('diagnostic_en_cour/index.html.twig', [
        'filteredDiagnostics' => $filteredDiagnostics,
        'lieu' => $session->get('lieu')
    ]);
}

    #[Route('/diagnostic/elements/{id}', name: 'app_diagnostic_elements_by_type', methods: ['GET', 'POST'])]
    public function diagnosticElementsByType(Request $request, int $id, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $veloId = $request->query->get('veloId');
        $typeDiagnosticId = $request->query->get('typeDiagnosticId');

        // Find the specific vélo by its ID
        $velo = $entityManager->getRepository(Velo::class)->find($veloId);

        if (!$velo) {
            throw $this->createNotFoundException('Vélo not found');
        }

        $diagnostic = new Diagnostic();
        $diagnostic->setVelo($velo);

        // Récupérer le type de diagnostic en fonction de l'ID du type
        $typeDiagnostic = $entityManager->getRepository(DiagnosticType::class)->find($id);
        if (!$typeDiagnostic) {
            // Handle the case where diagnostic type is not found
            throw $this->createNotFoundException('Diagnostic type not found');
        }

        $form = $this->createForm(FormDiagnosticType::class, $diagnostic, ['idTypeDiag' => $id]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diagnostic->setDateDiagnostic(new \DateTime());
            $diagnostic->setDiagnosticType($typeDiagnostic);

            // Récupération du lieu
            $lieu = $session->get('lieu');
            $lieuEntity = $entityManager->getRepository(Lieu::class)->find($lieu['id']);

            // Récupération de diagnostictypelieutype avec des conditions
            $diagnostictypeLieuType = $entityManager->getRepository(DiagnostictypeLieutype::class)->findOneBy([
                'Lieu_type_id' => $lieu['idType'],
                'diagnostic_type_id' => $typeDiagnostic,
                'actif' => true,
            ]);

            $diagnostic->setLieuId($lieuEntity);
            $diagnostic->setDiagnostictypeLieuTypeId($diagnostictypeLieuType);

            $entityManager->persist($diagnostic);
            $entityManager->flush();

            // Get diagnostic elements associated with this diagnostic type
            $elementsDiagnostic = $entityManager->getRepository(DiagnosticTypeElementcontrol::class)->findBy(['idDianosticType' => $typeDiagnostic]);

            // Categorize elements directly in the method
            $categorizedElements = [];
            foreach ($elementsDiagnostic as $element) {
                $fullElement = $element->getIdElementcontrol()->getElement();
                $parts = explode(':', $fullElement);
                $category = $parts[0];

                if (!array_key_exists($category, $categorizedElements)) {
                    $categorizedElements[$category] = [];
                }

                $categorizedElements[$category][] = $element->getIdElementcontrol();
            }

            // Process the diagnostic elements and save them to DB
            foreach ($elementsDiagnostic as $elementsDiagnostic) {
                $element = $elementsDiagnostic->getIdElementcontrol();
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

            $this->addFlash('success', 'Diagnostic enregistré avec succès!');
            return $this->redirectToRoute('app_diagnostic_en_cours');
        }

        // Fetch other necessary data for rendering
        $elementsDiagnostic = $entityManager->getRepository(DiagnosticTypeElementcontrol::class)->findBy(['idDianosticType' => $typeDiagnostic]);

        // Categorize elements directly
        $categorizedElements = [];
        foreach ($elementsDiagnostic as $element) {
            $fullElement = $element->getIdElementcontrol()->getElement();
            $parts = explode(':', $fullElement);
            $category = $parts[0];

            if (!array_key_exists($category, $categorizedElements)) {
                $categorizedElements[$category] = [];
            }

            $categorizedElements[$category][] = $element->getIdElementcontrol();
        }

        return $this->render('diagnostic/newDiaByType.html.twig', [
            'typeDiagnostic' => $typeDiagnostic,
            'diagnosticForm' => $form->createView(),
            'diagnosticElements' => $categorizedElements,
            'lieu' => $session->get('lieu'),
            'velo' => $velo,
        ]);
    }


    //******************************************//
    // reprise d'un diagnostique version multi diagnostic
    #[Route('/diagnostic/reprendreMulti/{id}', name: 'reprendre_Multidiagnostic', methods: ['GET', 'POST'])]
    public function reprendreMultiDiagnostic(int $id, Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {

        $lieu = $session->get('lieu');

        //recupération de l'id du daignostic dans l'URL
        $diagnostic = $entityManager->getRepository(Diagnostic::class)->find($id);
        if (!$diagnostic) {
            $this->addFlash('error', 'Diagnostic not found.');
            return $this->redirectToRoute('app_error');
        }


        //$elements = $entityManager->getRepository(ElementControl::class)->findAll();
        $diagnosticElementsDisplayed = $entityManager->getRepository(DiagnosticTypeElementcontrol::class)->findBy(['idDianosticType' => $diagnostic->getDiagnosticType()]);

        $categorizedElements = [];
        foreach ($diagnosticElementsDisplayed as $elementDiagnostic) {
            $elementControlId = $elementDiagnostic->getIdElementcontrol()->getId();
            $element = $entityManager->getRepository(ElementControl::class)->find($elementControlId);
            $fullElement = $element->getElement();
            $parts = explode(':', $fullElement);
            $category = $parts[0];
            if (!array_key_exists($category, $categorizedElements)) {
                $categorizedElements[$category] = [];
            }
            $categorizedElements[$category][] = $element;
        }
        //dd($categorizedElements);


        // dd($etatsElementsControle);
        // Récupération des éléments du diagnostic en fonction de son ID
        $diagnosticElements = $entityManager->getRepository(DiagnosticElement::class)->findBy(['diagnostic' => $diagnostic]);

        $form = $this->createForm(FormDiagnosticType::class, $diagnostic, [
            'idTypeDiag' => $diagnostic->getDiagnosticType(),
            'diagnostic' => $diagnostic,
            'diagnosticElements' => $diagnosticElements,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$elements = $entityManager->getRepository(ElementControl::class)->findAll();

            foreach ($diagnosticElementsDisplayed as $elementDiagnostic ) {
                $elementControlId = $elementDiagnostic->getIdElementcontrol()->getId();
                $element = $entityManager->getRepository(ElementControl::class)->find($elementControlId);

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
            $this->addFlash('success', 'Diagnostic modifié avec succès!');
            return $this->redirectToRoute('app_diagnostic_en_cours');
        }


        return $this->render('diagnostic/reprendreMultiDia.html.twig', [
            'diagnosticForm' => $form->createView(),
            'diagnostic' => $diagnostic,
            'diagnosticElements' => $categorizedElements,
            'lieu' => $lieu,
            'selectedVelo' => $diagnostic->getVelo(),
            //'etatsElementsControle' => $etatsElementsControle, // Ajout de la variable au rendu du template
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




    #[Route('/diagnostics/recapitulatif', name: 'diagnostics_recapitulatif', methods: ['GET'])]
    public function recapitulatif(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les diagnostics
        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findAll();

        // Récupérer les noms uniques des utilisateurs
        $noms_uniques = $entityManager->getRepository(Utilisateur::class)->createQueryBuilder('u')
            ->select('DISTINCT u.nom')
            ->getQuery()
            ->getResult();
        $noms_uniques = array_column($noms_uniques, 'nom');

        // Récupérer les dates uniques des diagnostics
        $dates_uniques = $entityManager->getRepository(Diagnostic::class)->createQueryBuilder('d')
            ->select('DISTINCT d.date_diagnostic')
            ->getQuery()
            ->getResult();
        $dates_uniques = array_column($dates_uniques, 'date_diagnostic');

        // Récupérer les types uniques de diagnostics
        $types_uniquesd = $entityManager->getRepository(DiagnosticType::class)->createQueryBuilder('dt')
            ->select('DISTINCT dt.nomType')
            ->getQuery()
            ->getResult();
        $types_uniquesd = array_column($types_uniquesd, 'nomType');

        // Récupérer les conclusions uniques
        $conclusions_uniques = $entityManager->getRepository(Diagnostic::class)->createQueryBuilder('v')
            ->select('DISTINCT v.conclusion')
            ->getQuery()
            ->getResult();
        $conclusions_uniques = array_column($conclusions_uniques, 'conclusion');

        // Récupérer les statuses uniques
        $statusd_uniques = $entityManager->getRepository(Diagnostic::class)->createQueryBuilder('v')
            ->select('DISTINCT v.status')
            ->getQuery()
            ->getResult();
        $statusd_uniques = array_column($statusd_uniques, 'status');

        // Récupérer les types de vélos uniques
        $types_uniquesv = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.type')
            ->getQuery()
            ->getResult();
        $types_uniquesv = array_column($types_uniquesv, 'type');

        // Récupérer les marques uniques de vélos
        $marques_uniques = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.marque')
            ->getQuery()
            ->getResult();
        $marques_uniques = array_column($marques_uniques, 'marque');

        // Récupérer les publics uniques de vélos
        $publics_uniques = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.public')
            ->getQuery()
            ->getResult();
        $publics_uniques = array_column($publics_uniques, 'public');

        // Récupérer les noms uniques des propriétaires
        $nomsp_uniques = $entityManager->getRepository(Proprietaire::class)->createQueryBuilder('p')
            ->select('DISTINCT p.nom_proprio')
            ->getQuery()
            ->getResult();
        $nomsp_uniques = array_column($nomsp_uniques, 'nom_proprio');

        // Récupérer les statuts uniques des propriétaires
        $statutp_uniques = $entityManager->getRepository(Proprietaire::class)->createQueryBuilder('p')
            ->select('DISTINCT p.statut')
            ->getQuery()
            ->getResult();
        $statutp_uniques = array_column($statutp_uniques, 'statut');

        // Récupérer les types uniques de lieux
        $types_lieux_uniques = $entityManager->getRepository(TypeLieu::class)->createQueryBuilder('tl')
            ->select('DISTINCT tl.nom_type_lieu')
            ->getQuery()
            ->getResult();
        $types_lieux_uniques = array_column($types_lieux_uniques, 'nom_type_lieu');

        // Récupérer les noms uniques des lieux
                $noms_lieux_uniques = $entityManager->getRepository(Lieu::class)->createQueryBuilder('l')
                    ->select('DISTINCT l.nom_lieu')
                    ->getQuery()
                    ->getResult();
                $noms_lieux_uniques = array_column($noms_lieux_uniques, 'nom_lieu');

        // Récupérer les villes uniques
                $villes_uniques = $entityManager->getRepository(Lieu::class)->createQueryBuilder('l')
                    ->select('DISTINCT l.ville')
                    ->getQuery()
                    ->getResult();
                $villes_uniques = array_column($villes_uniques, 'ville');

        // Récupérer les codes postaux uniques
                $codes_postaux_uniques = $entityManager->getRepository(Lieu::class)->createQueryBuilder('l')
                    ->select('DISTINCT l.code_postal')
                    ->getQuery()
                    ->getResult();
                $codes_postaux_uniques = array_column($codes_postaux_uniques, 'code_postal');


        // Ajouter les informations sur le lieu (type, nom, ville, code postal)
        $lieux = [];
        foreach ($diagnostics as $diagnostic) {
            $lieu = $diagnostic->getLieuId(); // Récupère l'objet Lieu
            if ($lieu) {
                // Initialiser le type de lieu si c'est un proxy
                if ($lieu->getTypeLieuId() && !$entityManager->getUnitOfWork()->isInIdentityMap($lieu->getTypeLieuId())) {
                    $entityManager->initializeObject($lieu->getTypeLieuId());
                }

                // Ajout des lieux dans le tableau
                $lieux[] = [
                    'typeLieu' => $lieu->getTypeLieuId() ? $lieu->getTypeLieuId()->getNomTypeLieu() : 'N/A', // Accède au typeLieu et au nom
                    'nomLieu' => $lieu->getNomLieu(),
                    'ville' => $lieu->getVille(),
                    'codePostal' => $lieu->getCodePostal()
                ];
            }
        }
// Ajout de dd() pour déboguer;
       //dd($diagnostics);
        //dd($noms_lieux_uniques);
        /*dd([
            'diagnostics' => $diagnostics,
            'lieux' => $lieux,  // Affiche les informations liées au lieu
        ]);*/
        // Retourner les données au template
        return $this->render('diagnostic/recapitulatif.html.twig', [
            'diagnostics' => $diagnostics,
            'types_uniquesv' => $types_uniquesv,
            'types_uniquesd' => $types_uniquesd,
            'conclusions_uniques' => $conclusions_uniques,
            'statusd_uniques' => $statusd_uniques,
            'marques_uniques' => $marques_uniques,
            'publics_uniques' => $publics_uniques,
            'nomsp_uniques' => $nomsp_uniques,
            'statutp_uniques' => $statutp_uniques,
            'dates_uniques' => $dates_uniques,
            'noms_uniques' => $noms_uniques,
            'lieux' => $lieux,// Ajout des lieux
            'types_lieux_uniques' => $types_lieux_uniques, // Ajout des types de lieux
            'noms_lieux_uniques' => $noms_lieux_uniques, // Ajout des noms de lieux
            'villes_uniques' => $villes_uniques, // Ajout des villes
            'codes_postaux_uniques' => $codes_postaux_uniques, // Ajout des codes postaux
        ]);
    }




//    #[Route('/diagnosticAReparer', name: 'app_diagnostic_a_reparer', methods: ['GET'])]
//    public function diagnosticsAReparer(EntityManagerInterface $entityManager): JsonResponse
//    {
//        // Récupérer les diagnostics avec la conclusion "À réparer"
//        $diagnostics = $entityManager->getRepository(Diagnostic::class)->findBy([
//            'conclusion' => ConclusionDiagnostic::A_REPARER
//        ]);
//
//        // Préparer les données à envoyer en réponse
//        $diagnosticData = [];
//        foreach ($diagnostics as $diagnostic) {
//            $diagnosticData[] = [
//                'conclusion' => $diagnostic->getConclusion(),
//            ];
//        }
//
//        // Retourner les données en format JSON
//        return new JsonResponse($diagnosticData);
//    }




}


