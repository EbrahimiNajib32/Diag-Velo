<?php

namespace App\Form;
use App\Entity\Proprietaire; // Make sure this is correct
use App\Entity\Velo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
                                            use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\File;

class VeloInfoType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('couleur', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('ref_recyclerie', TextType::class , [
                'required' => false,
                'label' => 'Référence Recyclerie'
            ])

           ->add('bicycode', TextType::class, [
               'required' => false,
                'label' => 'Bicycode'
           ])


            ->add('marque', ChoiceType::class, [
                'choices' => $this->getBrandChoices(),
                'label' => 'Marque'
            ])
            ->add('numero_de_serie', TextType::class , [
                'required' => false,
                'label' => 'Numéro de série'
            ])
            ->add('etat', TextType::class , [
                'required' => true,
                'label' => 'Etat'
            ])
            ->add('poids' , TextType::class , [
                        'required' => false,
                        'label' => 'Poids'
                        ])
            ->add('taille_roues', ChoiceType::class, [
                'choices' => [
                    '12 pouces (203 mm)' => '12',
                    '14 pouces (254 mm)' => '14',
                    '16 pouces (305 mm)' => '16',
                    '18 pouces (355 mm)' => '18',
                    '20 pouces (406 mm)' => '20',
                    '22 pouces (457 mm)' => '22',
                    '24 pouces (507 mm)' => '24',
                    '26 pouces (559 mm)' => '26',
                    '27.5 pouces (650B, 584 mm)' => '27.5',
                    '28 pouces (635 mm)' => '28',
                    '29 pouces (622 mm)' => '29',
                    '650C (571 mm)' => '650C',
                    '650B (584 mm)' => '650B',
                    '700C (622 mm)' => '700C',
                    '32 pouces (ISO 686)' => '32',
                    '36 pouces (914 mm)' => '36'
                ],
                'label' => 'Taille des roues',
            ])
            ->add('taille_cadre', TextType::class, [
                'required' => false,
                'label' => 'Taille du Cadre'
            ])
            ->add('url_photo', HiddenType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'attr' => ['id' => 'url_photo'],  // Ensure this attribute is set
            ])


            ->add('origine', TextType::class, [
                  'required' => false,
                   'label' => 'Origine du vélo'
             ])

            ->add('type', ChoiceType::class, [
                'choices' => [
                    'BMX' => 'BMX',
                    'Course' => 'Course',
                    'Gravel' => 'Gravel',
                    'Pliable' => 'Pliable',
                    'VILLE' => 'VILLE',
                    'VTC' => 'VTC',
                    'VTT' => 'VTT',
                    'Autres' => 'Autres',

                ],
                'label' => 'Type de vélo',
            ])
            ->add('public', ChoiceType::class , [
                    'choices' => [
                        'Homme' => 'Homme',
                        'Femme' => 'Femme',
                        'Unisex' => 'Unisex',
                        'Enfant' => 'Enfant',
                    ],
                    'label' => 'Public',]
            )
            ->add('commentaire', TextType::class , [
                'required' => false,
                'label' => 'Commentaire'
            ])
            ->add('emplacement', TextType::class , [
                'required' => false,
                'label' => 'Emplacement'
            ])
            ->add('chosir_ou_ajouter', ChoiceType::class, [
                'choices' => [
                    'Existant' => false,
                    'Nouveau' => true,
                ],
                'expanded' => true,
                'mapped' => false,
                'label' => 'Choisir ou Ajouter Proprietaire',
            ])
            ->add('proprietaire', EntityType::class, [
                'class' => Proprietaire::class,
                'choice_label' => function (Proprietaire $proprietaire) {
                    return $proprietaire->getNomProprio() . ' - ' . $proprietaire->getEmail();
                },
                'required' => false,
                'placeholder' => 'Choisir propriétaire...'
            ])
            ->add('nom_proprio', TextType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Nom ..', 'style' => 'display: none;']
            ])
            ->add('email', TextType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Email ..', 'style' => 'display: none;']
            ])

            ->add('telephone', TextType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Telephone ..', 'style' => 'display: none;']
            ])

            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Particulier' => 'Particulier',
                    'Professionnel' => 'Professionnel',
                ],
                'mapped' => false,
                'label' => 'Statut',
                'required' => false
            ]);

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $velo = $form->getData();
                $proprietaire = $velo->getProprietaire();

                if (!$proprietaire) {

                    $nomProprio = $form->get('nom_proprio')->getData();
                    $email = $form->get('email')->getData();
                    $telephone = $form->get('telephone')->getData();
                    $statut = $form->get('statut')->getData();

                    if (!empty($nomProprio) || !empty($email) || !empty($telephone) || !empty($statut)) {
                        $newProprietaire = new Proprietaire();
                        $newProprietaire->setNomProprio($nomProprio);
                        $newProprietaire->setEmail($email);
                        $newProprietaire->setTelephone($telephone);
                        $newProprietaire->setStatut($statut);

                        $this->entityManager->persist($newProprietaire);
                        $this->entityManager->flush();


                        $velo->setProprietaire($newProprietaire);
                    }
                } else {

                    if (!empty($proprietaire->getNomProprio()) || !empty($proprietaire->getEmail()) || !empty($proprietaire->getTelephone()) || !empty($proprietaire->getStatut())) {

                        $proprietaire->setNomProprio($proprietaire->getNomProprio());
                        $proprietaire->setEmail($proprietaire->getEmail());
                        $proprietaire->setTelephone($proprietaire->getTelephone());
                        $proprietaire->setStatut($proprietaire->getStatut());

                        $this->entityManager->flush();
                    }
                }
            }
        );
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $velo = $event->getData();
            $form = $event->getForm();
            if ($velo && $velo->getCouleur()) {
                $colors = explode('&', $velo->getCouleur());
                $form->get('couleur')->setData(join(',', $colors));
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $form->get('couleur')->getData();
            if ($data) {
                $colors = implode('&', $data);
                $event->getData()->setCouleur($colors);
            }
        });
        $this->addColorCheckboxes($builder);
    }


    private function getBrandChoices()
    {
        $brands = [
            'Autres', 'Basso', 'BH', 'BMC', 'Boardman Bikes', 'Breezer', 'Brooklyn Bicycle Co.',
            'Canyon', 'Cinelli', 'Cleary Bikes', 'Colnago', 'Commençal', 'Co-op Cycles (REI)', 'Dahon', 'De Rosa',
            'Diamondback', 'Dynacraft', 'Eddy Merckx', 'Electra', 'Evil Bike Co.', 'Fairdale', 'Felt', 'Focus',
            'Fuji', 'Ghost', 'GT', 'Holdsworth', 'Huffy', 'Ibis', 'Jamis', 'Kona', 'Lapierre', 'LeMond', 'Linus',
            'Look', 'Marin', 'Masi', 'Mercier', 'Mikado', 'Mongoose', 'Mondraker', 'Norco', 'Orange Bikes', 'Orient Bikes',
            'Orbea', 'Pashley Cycles', 'Peugeot', 'Pinarello', 'Pivot', 'Planet X', 'Polygon', 'Public Bikes', 'Quintana Roo',
            'Rabeneick', 'Raleigh', 'Ridley', 'Ritte', 'Rocky Mountain', 'Salsa', 'Saracen', 'Schwinn', 'Sekine', 'Serotta',
            'Simcoe', 'Sole Bicycles', 'Sommer', 'Soma', 'Spot Brand', 'Staiger', 'State Bicycle Co.', 'Storck', 'Strider',
            'Stromer', 'Surly', 'Tern', 'Throne Cycles', 'Tokyobike', 'Torpado', 'Transition', 'Union', 'Van Nicholas',
            'VanMoof', 'Veloretti', 'Vitus', 'Wilier Triestina', 'Woom', 'Yeti Cycles', 'Zinn'
        ];
        asort($brands);
        return array_combine($brands, $brands);
    }



    private function addColorCheckboxes(FormBuilderInterface $builder)
    {
        $builder->add('couleur', ChoiceType::class, [
            'choices' => [
                'Blanc' => 'white',
                'Beige' => 'beige',
                'Saumon' => 'darksalmon',
                'Rose' => 'pink',
                'Jaune' => 'yellow',
                'Or' => 'gold',
                'Orange' => 'orange',
                'Rouge' => 'red',
                'Kaki' => 'khaki',
                'Vert fluo' => 'lime',
                'Vert' => 'green',
                'Olive' => 'olive',
                'Bleu océan' => 'aqua',
                'Bleu' => 'blue',
                'Bleu foncé' => 'navy',
                'Violet' => 'violet',
                'Brun' => 'brown',
                'Gris' => 'grey',
                'Noir' => 'black',
                'Argent' => 'silver'
            ],
            'expanded' => true,
            'multiple' => true,
            'mapped' => false,
            'required' => false,
            'label' => 'Couleurs (multiples)'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Velo::class,
        ]);
    }
}