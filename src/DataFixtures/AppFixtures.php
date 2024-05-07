<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ElementControl;
use App\Entity\EtatControl;
use App\Entity\Utilisateur;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $elements = [
            ['id' => 1, 'element' => 'cadre: aspect général'],
            ['id' => 2, 'element' => 'cadre: béquille'],
            ['id' => 3, 'element' => 'direction: guidon'],
            ['id' => 4, 'element' => 'direction: fourche'],
            ['id' => 5, 'element' => 'direction: jeu'],
            ['id' => 6, 'element' => 'roue avant: pneu'],
            ['id' => 7, 'element' => 'roue avant: chambre à air'],
            ['id' => 8, 'element' => 'roue avant: rayonnage'],
            ['id' => 9, 'element' => 'roue avant: moyeu et axe'],
            ['id' => 10, 'element' => 'roue avant: garde-boue'],
            ['id' => 11, 'element' => 'frein avant: levier'],
            ['id' => 12, 'element' => 'frein avant: patin'],
            ['id' => 13, 'element' => 'frein avant: câble'],
            ['id' => 14, 'element' => 'frein avant: tension/réglage'],
            ['id' => 15, 'element' => 'transmission: pédales'],
            ['id' => 16, 'element' => 'transmission: plateaux'],
            ['id' => 17, 'element' => 'transmission: axe'],
            ['id' => 18, 'element' => 'transmission: chaîne'],
            ['id' => 19, 'element' => 'dérailleur avant: dérailleur'],
            ['id' => 20, 'element' => 'dérailleur avant: commande manette'],
            ['id' => 21, 'element' => 'dérailleur avant: câble'],
            ['id' => 22, 'element' => 'dérailleur avant: tension/réglage'],
            ['id' => 23, 'element' => 'roue arrière: pneu'],
            ['id' => 24, 'element' => 'roue arrière: chambre à air'],
            ['id' => 25, 'element' => 'roue arrière: rayonnage'],
            ['id' => 26, 'element' => 'roue arrière: moyeu et axe'],
            ['id' => 27, 'element' => 'roue arrière: garde-boue'],
            ['id' => 28, 'element' => 'roue arrière: porte-bagages'],
            ['id' => 29, 'element' => 'frein arrière: levier'],
            ['id' => 30, 'element' => 'frein arrière: patin'],
            ['id' => 31, 'element' => 'frein arrière: câble'],
            ['id' => 32, 'element' => 'frein arrière: tension/réglage'],
            ['id' => 33, 'element' => 'dérailleur arrière: dérailleur'],
            ['id' => 34, 'element' => 'dérailleur arrière: commande manette'],
            ['id' => 35, 'element' => 'dérailleur arrière: câble'],
            ['id' => 36, 'element' => 'dérailleur arrière: tension/réglage'],
            ['id' => 37, 'element' => 'dérailleur arrière: pignons'],
            ['id' => 38, 'element' => 'assise: selle'],
            ['id' => 39, 'element' => 'assise: fixation'],
            ['id' => 40, 'element' => 'sécurité: dynamo'],
            ['id' => 41, 'element' => 'sécurité: éclairage à piles'],
            ['id' => 42, 'element' => 'sécurité: lumière avant'],
            ['id' => 43, 'element' => 'sécurité: lumière arrière'],
            ['id' => 44, 'element' => 'sécurité: catadioptres Av+Ar '],
            ['id' => 45, 'element' => 'sécurité: catadioptres pédales '],
            ['id' => 46, 'element' => 'sécurité: catadioptres roues Av+Ar '],
            ['id' => 47, 'element' => 'sécurité: sonnette']
        ];

        foreach ($elements as $data) {
            $element = new ElementControl();
            $element->setElement($data['element']);
            $manager->persist($element);
        }

        // Inserting data into etat_control
        $etats = [
            ['id' => 1, 'nom_etat' => 'OK'],
            ['id' => 2, 'nom_etat' => 'À reviser'],
            ['id' => 3, 'nom_etat' => 'Pas OK'],
            ['id' => 4, 'nom_etat' => 'N/A']
        ];

        foreach ($etats as $data) {
            $etat = new EtatControl();
            $etat->setNomEtat($data['nom_etat']);
            $manager->persist($etat);
        }

        // Inserting a user
        $user = new Utilisateur();
        $user->setNom('admin');
        $user->setRole('0');  // Ensure this matches your user entity's role field definition
        $user->setPassword('$2a$04$WgkgpAoIA.lnn.I6CzLa2uOuJGgxOuUya2cThdkBqGJFwlTSeW3Fa');  // assuming this is a hashed password
        $manager->persist($user);

        $manager->flush();
    }
}
