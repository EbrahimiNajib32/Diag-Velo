<?php

namespace App\Form;
use App\Entity\Proprietaire; // Make sure this is correct
use App\Entity\Velo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
                                            use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VeloInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('couleur', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('ref_recyclerie')
            ->add('marque', ChoiceType::class, [
                'choices' => $this->getBrandChoices(),
                'label' => 'Marque'
            ])
            ->add('numero_de_serie')
            ->add('etat')
            ->add('poids')
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
            ->add('taille_cadre')
            ->add('date_de_reception', null, [
                'widget' => 'single_text'
            ])
            ->add('url_photo')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Autres' => 'Autres',
                    'VTC' => 'VTC',
                    'Gravel' => 'Gravel',
                    'Pliable' => 'Pliable',
                    'VTT' => 'VTT',
                ],
                'label' => 'Type de vélo',
            ])
            ->add('commentaire')
            ->add('emplacement')
            ->add('proprietaire', ProprietaireType::class);
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
            'Autres', 'All-City', 'Alchemy', 'Argon 18', 'Basso', 'BH', 'BMC', 'Boardman Bikes', 'Breezer', 'Brooklyn Bicycle Co.',
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
                'Rouge' => 'red',
                'Bleu' => 'blue',
                'Vert' => 'green',
                'Jaune' => 'yellow',
                'Orange' => 'orange',
                'Violet' => 'violet',
                'Noir' => 'black',
                'Gris' => 'grey',
                'Blanc' => 'white',
                'Brun' => 'brown'
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