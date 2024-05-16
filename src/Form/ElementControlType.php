<?php
// src/Form/ElementControlType.php

// src/Form/ElementControlType.php

namespace App\Form;

use App\Entity\ElementControl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = $options['categories'];
        $builder
            ->add('existingCategory', ChoiceType::class, [
                'mapped' => false,
                'choices' => array_combine($categories, $categories),
                'placeholder' => 'Choisir une catégorie existante',
                'required' => false,
                'attr' => ['class' => 'form-control my-input-class']
            ])
            ->add('category', null, [
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control my-input-class border border-gray-400 rounded text-center',
                    'placeholder' => 'Nom de la catégorie'
                ]
            ])
            ->add('elementName', null, [
                'mapped' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control my-input-class border border-gray-400 text-center',
                    'placeholder' => 'Nom de l\'élément'
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ElementControl::class,
        ]);
        $resolver->setDefined(['categories']);
    }
}
