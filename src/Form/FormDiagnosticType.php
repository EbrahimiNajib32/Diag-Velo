<?php

namespace App\Form;

use App\Entity\Diagnostic;
use App\Entity\DiagnosticElement;
use App\Entity\Utilisateur;
use App\Entity\Velo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{ ElementControl};
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\ConclusionDiagnostic;
use App\Entity\DiagnosticTypeElementcontrol;
use App\Entity\DiagnosticType;


class FormDiagnosticType extends AbstractType
{
    private $entityManager;
    private $security;


    public function __construct(EntityManagerInterface $entityManager ,Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Diagnostic::class,
            'diagnostic' => null,
            'diagnosticElements' => [],
            'idTypeDiag' => 0,
            //'diagnostic_type_id' => null // Ajouter l'option diagnostic_type_id ici
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $diagnostic = $options['diagnostic'];
        $diagnosticElements = $options['diagnosticElements'];
        $idTypeDiag = $options["idTypeDiag"];
        $currentUser = $this->security->getUser();
        //TEST
        // Utiliser l'ID pour récupérer l'objet DiagnosticType correspondant
        $typeDiagnostic = $this->entityManager->getRepository(DiagnosticType::class)->find($idTypeDiag);
    
        // Assurez-vous que le type de diagnostic est récupéré avec succès
         if (!$typeDiagnostic) {
        // Gérer le cas où le type de diagnostic n'est pas trouvé
    }
        // FIN TEST


        $elementStates = [];
        foreach ($diagnosticElements as $diagElement) {
            $elementStates[$diagElement->getElementControl()->getId()] = $diagElement->getEtatControl()->getId();
        }

       

        $builder ->add('cout_reparation');
        $builder
            ->add('cout_reparation')

            ->add('conclusion', ChoiceType::class, [
                'label' => 'Conclusion',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'R.A.S' => 'R.A.S',
                    'À réparer' => 'À réparer',
                    'Pour pièces' => 'pour pièces',
                ],
                'attr' => ['class' => 'form-checkbox mr-4'],
            ])

            ->add('velo', EntityType::class, [
                'class' => Velo::class,
                'choice_label' => function ($velo) {
                    return sprintf(
                        '%s - %s - %s - %s ',
                        $velo->getDateDeEnregistrement()->format('Y-m-d'),
                        $velo->getRefRecyclerie(),
                        $velo->getProprietaire()->getNomProprio(),
                        $velo->getMarque()
                    );
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.date_de_enregistrement', 'DESC');
                },
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'Nom',
                'query_builder' => function (EntityRepository $er) use ($currentUser) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id = :userId')
                        ->setParameter('userId', $currentUser->getId());
                },
                'data' => $currentUser,
                'attr' => ['style' => 'display:none;'],
                'required' => true,
                'label' => false, // Make the label disappear
            ]);

        foreach ($diagnosticElements as $diagElement) {
            $elementStates[$diagElement->getElementControl()->getId()] = $diagElement->getEtatControl()->getId();
            $elementComments[$diagElement->getElementControl()->getId()] = $diagElement->getCommentaire();
        }


        
        // Récupérer le type de diagnostic en fonction de l'ID du type
        $typeDiagnostic = $this->entityManager->getRepository(DiagnosticType::class)->find($idTypeDiag);
        //var_dump($typeDiagnostic);
        if (!$typeDiagnostic) {
            // Gérer le cas où le type de diagnostic n'est pas trouvé
        }

        // Récupérer les éléments de diagnostic associés à ce type de diagnostic
        $elementsDiagnostic = $this->entityManager->getRepository(DiagnosticTypeElementcontrol::class)->findBy(['idDianosticType' => $typeDiagnostic]);

        foreach ($elementsDiagnostic as $elementDiagnostic) {

            $elementControlId = $elementDiagnostic->getIdElementcontrol()->getId();
            $element = $this->entityManager->getRepository(ElementControl::class)->find($elementControlId);

            $elementId = $element->getId();
            $currentState = $elementStates[$elementId] ?? null;
            $currentComment = $elementComments[$elementId] ?? '';

            $builder->add('etat_' . $elementId, ChoiceType::class, [
                'choices' => [
                    'OK' => 1,
                    'À reviser' => 2,
                    'Pas OK' => 3,
                    'N/A' => 4,
                ],
                'data' => $currentState,
                'expanded' => true,
                'multiple' => false,
                'label' => $element->getElement(),
                'required' => false,
                'mapped' => false,
                'placeholder' => false,
            ]);

            $builder->add('commentaire_' . $elementId, TextareaType::class, [
                'data' => $currentComment,
                'required' => false,
                'mapped' => false,
                'attr' => ['placeholder' => 'Ajouter commentaire...'],
                'label' => false,
            ]);
        }
    }
}

