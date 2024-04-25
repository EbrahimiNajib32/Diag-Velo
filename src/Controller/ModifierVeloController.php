<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Velo;
use App\Form\VeloType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModifierVeloController extends AbstractController
{
    #[Route('/velo/edit/{id}', name: 'velo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Velo $velo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Vélo modifié avec succès!');

             return $this->redirectToRoute('velo_edit', ['id' => $velo->getId()]);
        }

         return $this->render('velo/edit.html.twig', [
           'form' => $form->createView(),
             'velo' => $velo
        ]);
    }
}
