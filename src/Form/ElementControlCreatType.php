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
                'attr' => ['placeholder' => 'Entrez le nom de l\'élément']
            ])
            ->add('save', SubmitType::class, ['label' => 'Créer Élément']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ElementControl::class,
        ]);
    }
}
