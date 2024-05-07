<?php

namespace App\Form;

use App\Entity\DiagnosticType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeDagnosticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomType')
            ->add('dateCreationType', null, [
                'widget' => 'single_text'
            ])
            ->add('actif')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DiagnosticType::class,
        ]);
    }
}
