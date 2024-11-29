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
use App\Entity\ElementControl;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\DiagnosticTypeElementcontrol;
use App\Entity\DiagnosticType;

class FormDiagnosticType extends AbstractType
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
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
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $diagnostic = $options['diagnostic'];
        $diagnosticElements = $options['diagnosticElements'];
        $idTypeDiag = $options['idTypeDiag'];
        $currentUser = $this->security->getUser();

        // Récupérer l'objet DiagnosticType en fonction de l'ID
        $typeDiagnostic = $this->entityManager->getRepository(DiagnosticType::class)->find($idTypeDiag);
        if (!$typeDiagnostic) {
            // Gérer le cas où le type de diagnostic n'est pas trouvé
        }

        // Initialiser les états des éléments
        $elementStates = [];
        foreach ($diagnosticElements as $diagElement) {
            $elementStates[$diagElement->getElementControl()->getId()] = $diagElement->getEtatControl()->getId();
        }

        // Ajouter le champ de coût de réparation
        $builder->add('cout_reparation');

        // Ajouter le champ de conclusion
        $builder->add('conclusion', ChoiceType::class, [
            'label' => 'Conclusion',
            'expanded' => true,
            'multiple' => false,
            'choices' => [
                'R.A.S' => 'R.A.S',
                'À réparer' => 'À réparer',
                'Pour pièces' => 'pour pièces',
            ],
            'attr' => ['class' => 'form-checkbox mr-4'],
        ]);

//        // Ajouter le champ 'velo' conditionnellement
//        if (empty($options['exclude_velo'])) {
//            $builder->add('velo', EntityType::class, [
//                'class' => Velo::class,
//                'choice_label' => function ($velo) {
//                    return sprintf(
//                        '%s - %s - %s - %s',
//                        $velo->getDateDeEnregistrement()->format('Y-m-d'),
//                        $velo->getRefRecyclerie(),
//                        $velo->getProprietaire()->getNomProprio(),
//                        $velo->getMarque()
//                    );
//                },
//                'query_builder' => function (EntityRepository $er) {
//                    return $er->createQueryBuilder('v')
//                        ->orderBy('v.date_de_enregistrement', 'DESC');
//                },
//                'label' => 'Vélo',
//            ]);
//        }

        // Ajouter le champ 'utilisateur'
        $builder->add('utilisateur', EntityType::class, [
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
            'label' => false, // Cacher le label
        ]);

        // Récupérer et traiter les éléments de diagnostic
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
