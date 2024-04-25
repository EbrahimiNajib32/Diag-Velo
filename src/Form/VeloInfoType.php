<?php

namespace App\Form;
use App\Entity\Proprietaire; // Make sure this is correct
use App\Entity\Velo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Import needed for ChoiceType

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
            ->add('emplacement')
            ->add('commentaire')
             ->add('public', ChoiceType::class, [
                       'choices' => [
                           'Enfant' => 'enfant',
                           'Femme' => 'femme',
                           'Homme' => 'homme',
                           'Unisexe' => 'unisexe'
                       ],
                       'label' => 'Public cible'
                   ])


              ->add('proprietaire', ProprietaireType::class, [
                                                                                    // Les options nécessaires
                  ])



        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Velo::class,
        ]);
    }
}