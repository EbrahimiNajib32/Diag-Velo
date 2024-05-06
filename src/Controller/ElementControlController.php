<?php

namespace App\Controller;

use App\Entity\ElementControl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
