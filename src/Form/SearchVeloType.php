<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchVeloType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options): void
       {
           $builder
               ->add('ref_recyclerie_search', TextType::class, [
                   'label' => 'Numéro de recyclerie pour recherche',
                   'required' => true, // Rend le champ obligatoire
                   'mapped' => false,
                   'constraints' => [
                       new NotBlank(), // Applique la contrainte NotBlank
                   ],
               ]);
       }
   }
