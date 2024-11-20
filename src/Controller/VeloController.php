<?php
// src/Controller/VeloController.php

namespace App\Controller;

use Doctrine\ORM\Query\Expr\Join;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Proprietaire;
use App\Entity\Diagnostic;
use App\Entity\Velo;
use App\Form\VeloInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VeloController extends AbstractController
{
    // Route pour créer un nouveau vélo
    #[Route('/velo/new', name: 'velo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $velo = new Velo();
        $form = $this->createForm(VeloInfoType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $velo->setDateDeEnregistrement(new \DateTime());

            // Traitement de l'image
            $base64Image = $form->get('url_photo')->getData();
            if ($base64Image && preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type) && in_array($type[1], ['png', 'jpg', 'jpeg', 'gif'])) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $data = base64_decode($data);

                $imageName = uniqid() . '.' . $type[1];
                $filePath = $this->getParameter('images_directory') . '/' . $imageName;

                if (!file_exists($this->getParameter('images_directory'))) {
                    mkdir($this->getParameter('images_directory'), 0777, true); // Ensure directory exists
                }
                file_put_contents($filePath, $data);

                $webPath = '/images/velo/' . $imageName;
                $velo->setUrlPhoto($webPath);
            }

            if ($velo->getProprietaire()) {
                $entityManager->persist($velo->getProprietaire());
            }
            $entityManager->persist($velo);
            $entityManager->flush();

            // Vérifier l'action demandée par le bouton
            $action = $request->request->get('action');
            if ($action === 'return_home') {
                // Si "Retour Accueil", on redirige vers la page d'accueil
                $this->addFlash('success', 'Vélo enregistré avec succès !');
                return $this->redirectToRoute('app_accueil');
            }
            if ($action === 'go_to_diagnostic') {
                // Si "Aller au Diagnostic", on redirige vers la page de diagnostic avec l'ID du vélo
                $this->addFlash('success', 'Vélo enregistré avec succès !');
                return $this->redirectToRoute('app_type_diagnostic', ['id' => $velo->getId()]);
            }

            // Si "Enregistrer un autre vélo", on recharge la page
            $this->addFlash('success', 'Vélo enregistré avec succès !');
            return $this->redirectToRoute('velo_new'); // Recharge la page pour un nouvel enregistrement
        }

        return $this->render('velo/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour afficher les informations des vélos
    #[Route('/velo/all', name: 'velo_info', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request, SessionInterface $session): Response
    {
        $query = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('v.id', 'p.nom_proprio', 'v.numero_de_serie', 'v.marque', 'v.ref_recyclerie', 'v.couleur', 'v.date_de_enregistrement', 'v.type', 'v.public', 'v.date_de_vente', 'v.date_destruction')
            ->leftJoin('v.proprietaire', 'p')
            ->getQuery();

        // Pagination des résultats
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        // Si nécessaire, récupère les diagnostics séparément pour chaque vélo
        $diagnostics = [];
        foreach ($pagination as $velo) {
            $veloId = $velo['id'];
            $diagnosticData = $entityManager->getRepository(Diagnostic::class)->findBy(['velo' => $veloId]);
            if (!empty($diagnosticData)) {
                $diagnostics[$veloId] = $diagnosticData;
            }
        }

        // Trie les diagnostics par date pour chaque vélo
        foreach ($diagnostics as $veloId => $diagnosticData) {
            usort($diagnosticData, function ($a, $b) {
                return $a->getDateDiagnostic() <=> $b->getDateDiagnostic();
            });
            $diagnostics[$veloId] = $diagnosticData;
        }

        // Récupère les marques, couleurs, types et publics distincts des vélos
        $marqueQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.marque')
            ->getQuery();
        $marques = $marqueQuery->getResult();
        $marques_uniques = array_map(function ($marque) {
            return $marque['marque'];
        }, $marques);

        $couleurQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.couleur')
            ->getQuery();
        $couleurs = $couleurQuery->getResult();
        $couleurs_uniques = array_column($couleurs, 'couleur');

        $typeQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.type')
            ->getQuery();
        $types = $typeQuery->getResult();
        $types_uniques = array_map(function ($type) {
            return $type['type'];
        }, $types);

        $publicQuery = $entityManager->getRepository(Velo::class)->createQueryBuilder('v')
            ->select('DISTINCT v.public')
            ->getQuery();
        $publics = $publicQuery->getResult();
        $publics_uniques = array_map(function ($public) {
            return $public['public'];
        }, $publics);

        // Passe les données au modèle Twig, y compris les informations du lieu depuis la session
        return $this->render('velo/velo_liste.html.twig', [
            'pagination' => $pagination,
            'diagnostics' => $diagnostics,
            'marques_uniques' => $marques_uniques,
            'couleurs_uniques' => $couleurs_uniques,
            'types_uniques' => $types_uniques,
            'publics_uniques' => $publics_uniques,
            'lieu' => $session->get('lieu'), // Passer la variable 'lieu' depuis la session
        ]);
    }


    #[Route('/api/update-velo/{id}', name: 'api_update_velo', methods: ['POST'])]
    public function updateVelo(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, $id): JsonResponse
    {
        $velo = $entityManager->getRepository(Velo::class)->find($id);
        if (!$velo) {
            return new JsonResponse(['status' => 'Velo not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        foreach ($data as $key => $value) {
            if ($key === 'proprietaireId') {
                $proprietaire = $entityManager->getRepository(Proprietaire::class)->find($value);
                if ($proprietaire) {
                    $velo->setProprietaire($proprietaire);
                } else {
                    return new JsonResponse(['status' => 'error', 'message' => 'Proprietaire not found'], JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                $setter = 'set' . ucfirst($key);
                if (method_exists($velo, $setter)) {
                    if (in_array($key, ['refRecyclerie', 'poids', 'tailleRoues', 'tailleCadre'])) {
                        if ($value === null || $value === '') {
                            $valueToSet = null;
                        } else {
                            switch ($key) {
                                case 'poids':
                                    $valueToSet = (string)$value;  // Treat 'poids' as string
                                    break;
                                case 'tailleRoues':
                                case 'tailleCadre':
                                    $valueToSet = (int)$value;
                                    break;
                                default:
                                    $valueToSet = (string)$value;
                                    break;
                            }
                        }
                        $velo->$setter($valueToSet);
                    }
                }
            }
        }

        $errors = $validator->validate($velo);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['status' => 'error', 'errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $entityManager->flush();
            return new JsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }



    #[Route('/velo/reparations', name: 'velo_reparations', methods: ['GET'])]
    public function diagnosticsAReparer(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response {
        // Sous-requête pour récupérer la dernière date de diagnostic pour chaque vélo
        $subquery = $entityManager->getRepository(Diagnostic::class)
            ->createQueryBuilder('d_sub')
            ->select('MAX(d_sub.dateDiagnostic) AS max_date')
            ->groupBy('d_sub.velo')
            ->getQuery();

        // Requête principale pour récupérer les diagnostics correspondant aux dernières dates
        $query = $entityManager->getRepository(Diagnostic::class)
            ->createQueryBuilder('d')
            ->innerJoin(
                '(' . $subquery->getDQL() . ')',
                'd_max',
                Join::WITH,
                'd.dateDiagnostic = d_max.max_date'
            )
            ->andWhere('d.conclusion = :conclusion')
            ->setParameter('conclusion', 'à réparer')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('velo/details.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
