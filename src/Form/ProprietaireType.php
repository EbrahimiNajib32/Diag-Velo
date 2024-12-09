<?php

namespace App\Form;

use App\Entity\Proprietaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Regex;

class ProprietaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_proprio', null, [ 
                'required' => true,     
                'label' => 'Nom du propriétaire', 
                'attr' => ['class' => 'form-control'], 
            ])
            ->add('prenom', null, [
                'required' => false, 
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'required' => false, // Le champ est facultatif
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(\+33|0)[1-9](\d{2}){4}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide (format : +33 6 12 34 56 78 ou 06 12 34 56 78).',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', null, [
                'required' => false,
            ])
            ->add('statut') // Champ requis par défaut
            ->add('date_de_naissance', null, [
                'required' => false, 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proprietaire::class, 
        ]);
    }
}
