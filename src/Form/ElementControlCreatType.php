<?php

// src/Form/ElementControlCreateType.php
namespace App\Form;

use App\Entity\ElementControl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ElementControlCreatType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('element', TextType::class, [
                'label' => 'Élément',
                'attr' => [
                    'placeholder' => 'Catégorie:Élément',
                    'class' => 'form-control',
                    'id' => 'element-input' // Assurez-vous que l'ID est correct
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer Élément',
                'attr' => [
                    'class' => 'btn bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600' // Ajoutez les classes CSS ici
                ]
            ]);
    }
}
