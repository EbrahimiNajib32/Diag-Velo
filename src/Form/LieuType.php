<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\TypeLieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_lieu')
            ->add('adresse_lieu')
            ->add('ville')
            ->add('code_postal')
            ->add('type_lieu_id', EntityType::class, [
                'class' => TypeLieu::class,
                'choice_label' => 'nom_type_lieu',
                'label' => 'Type de lieu',
                'placeholder' => 'Choisissez un type de lieu',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                    return $repository->createQueryBuilder('act')
                        ->where('act.actif = :actif')
                        ->setParameter('actif', true);
                },
                'attr' => [
                    'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
