<?php

namespace App\Form;

use App\Entity\Diagnostic;
use App\Entity\DiagnosticElement;
use App\Entity\Utilisateur;
use App\Entity\Velo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{ ElementControl};
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Enum\ConclusionDiagnostic;


class DiagnosticType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Diagnostic::class,
            'diagnostic' => null,
            'diagnosticElements' => [],
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $diagnostic = $options['diagnostic'];
        $diagnosticElements = $options['diagnosticElements'];

        // Build a map of element IDs to their current states
        $elementStates = [];
        foreach ($diagnosticElements as $diagElement) {
            $elementStates[$diagElement->getElementControl()->getId()] = $diagElement->getEtatControl()->getId();
        }

        $builder
            ->add('cout_reparation')

            ->add('conclusion', ChoiceType::class, [ // Remplacer l'ancien champ "conclusion"
                'choices' => [
                    'R.A.S' => ConclusionDiagnostic::RAS,
                    'À réparer' => ConclusionDiagnostic::A_REPARER,
                    'Pour pièces' => ConclusionDiagnostic::POUR_PIECES,
                ],
                'expanded' => true, // Pour afficher des cases à cocher
                'multiple' => false, // Pour ne permettre qu'une seule sélection
            ])

            ->add('velo', EntityType::class, [
                'class' => Velo::class,
                'choice_label' => 'ref_recyclerie',
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'Nom',
            ]);

        foreach ($diagnosticElements as $diagElement) {
            $elementStates[$diagElement->getElementControl()->getId()] = $diagElement->getEtatControl()->getId();
            $elementComments[$diagElement->getElementControl()->getId()] = $diagElement->getCommentaire();
        }

        $elements = $this->entityManager->getRepository(ElementControl::class)->findAll();
        foreach ($elements as $element) {
            $elementId = $element->getId();
            $currentState = $elementStates[$elementId] ?? null;
            $currentComment = $elementComments[$elementId] ?? '';

            $builder->add('etat_' . $elementId, ChoiceType::class, [
                'choices' => [
                    'OK' => 1,
                    'Pas OK' => 2,
                    'À reviser' => 3,
                    'N/A' => 4,
                ],
                'data' => $currentState,
                'expanded' => true,
                'multiple' => false,
                'label' => $element->getElement(),
                'required' => false,
                'mapped' => false,
                'placeholder' => false,
            ]);

            $builder->add('commentaire_' . $elementId, TextareaType::class, [
                'data' => $currentComment,
                'required' => false,
                'mapped' => false,
                'attr' => ['placeholder' => 'Ajouter commentaire...'],
                'label' => false,
            ]);
        }
    }
}

