<?php

namespace App\Form;

use App\Entity\Velo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeloInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_de_serie')
            ->add('marque')
            ->add('ref_recyclerie')
            ->add('couleur')
            ->add('poids')
            ->add('taille_roues')
            ->add('taille_cadre')
            ->add('etat')
            ->add('url_photo')
            ->add('date_de_reception', null, [
                'widget' => 'single_text'
            ])
            ->add('date_de_vente', null, [
                'widget' => 'single_text'
            ])
            ->add('type')
            ->add('annee')
            ->add('emplacement')
            ->add('commentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Velo::class,
        ]);
    }
}