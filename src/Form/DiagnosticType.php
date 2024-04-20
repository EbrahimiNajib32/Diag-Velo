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

class DiagnosticType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $elements = $this->entityManager->getRepository(ElementControl::class)->findAll();

        $builder
            ->add('date_diagnostic', null, ['widget' => 'single_text'])
            ->add('cout_reparation')
            ->add('conclusion')
            ->add('velo', EntityType::class, [
                'class' => Velo::class,
                'choice_label' => 'ref_recyclerie',
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'Nom',
            ]);

        foreach ($elements as $element) {
            $builder->add('etat_' . $element->getId(), ChoiceType::class, [
                'choices' => [
                    'OK' => 1,
                    'Pas OK' => 2,
                    'À reviser' => 3,
                    'N/A' => 4,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => $element->getElement(),
                'required' => false,
                'mapped' => false,
            ]);
            // Ensure similar setup for 'commentaire_' fields
            $builder->add('commentaire_' . $element->getId(), TextareaType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => ['placeholder' => 'Ajouter commentaire...'],
                'label' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Diagnostic::class,
        ]);
    }
}

