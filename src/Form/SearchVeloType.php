<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class SearchVeloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('ref_recyclerie', TextType::class, [
            'label' => 'Numéro de recyclerie pour recherche',
            'required' => false, // Rend le champ obligatoire
            'mapped' => false, // Ce champ n'est pas directement lié à une propriété de l'entité
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut pas être vide.'
                ]),
                new Assert\Regex([
                    'pattern' => '/^[0-9]+$/',
                    'message' => 'Veuillez entrer un nombre valide.',
                ])
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form defaults here
        ]);
    }
}
