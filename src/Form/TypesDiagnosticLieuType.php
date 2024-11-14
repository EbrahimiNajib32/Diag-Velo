<?php

namespace App\Form;

use App\Entity\DiagnosticType;
use App\Entity\DiagnostictypeLieutype;
use App\Entity\TypeLieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypesDiagnosticLieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actif')
            ->add('diagnostic_type_id', EntityType::class, [
                'class' => DiagnosticType::class,
                'choice_label' => 'id',
            ])
            ->add('Lieu_type_id', EntityType::class, [
                'class' => TypeLieu::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DiagnostictypeLieutype::class,
        ]);
    }
}
