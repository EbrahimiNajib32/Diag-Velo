<?php

namespace App\Controller;

use App\Entity\ElementControl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ElementControlCreatType;



class ElementControlController extends AbstractController
{
    #[Route('/dashboard/element/control', name: 'app_dashboard_element_control')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Fetch elements
        $elements = $entityManager->getRepository(ElementControl::class)->findAll();
        $categorizedElements = [];

        // Categorize elements
        foreach ($elements as $element) {
            $fullElement = $element->getElement(); // Assume this returns "category:item"
            $parts = explode(':', $fullElement);
            $category = $parts[0];
            if (!array_key_exists($category, $categorizedElements)) {
                $categorizedElements[$category] = [];
            }
            $categorizedElements[$category][] = $element;
        }

        // Pass data to the template
        return $this->render('element_control/index.html.twig', [
            'controller_name' => 'ElementControlController',
            'categorizedElements' => $categorizedElements,
        ]);
    }

    #[Route('/new/element/control', name: 'app_dashboard_new_element_control', methods: ['GET', 'POST'])]
    public function addElementControl(Request $request, EntityManagerInterface $entityManager): Response
    {
        $element = new ElementControl();
        $form = $this->createForm(ElementControlCreatType::class, $element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($element);
            $entityManager->flush();
            $this->addFlash('success', 'Nouvel élément ajouté avec succès.');
            return $this->redirectToRoute('app_dashboard_element_control');
        }

        return $this->render('element_control/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}