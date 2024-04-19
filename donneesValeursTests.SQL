
-- Ajout du premier propriétaire
INSERT INTO `proprietaire` (`id`, `nom_proprio`, `telephone`, `email`) VALUES ('1', 'recyclerie', '06858585', NULL);

-- Ajout de 2 vélos (devra être modifié)
INSERT INTO `velo` (`id`, `numero_de_serie`, `marque`, `ref_recyclerie`, `couleur`, `poids`, `taille_roues`, `taille_cadre`, `etat`, `url_photo`, `date_de_reception`, `date_de_vente`, `type`, `annee`, `emplacement`, `commentaire`, `proprietaire_id`) VALUES ('1', '123', 'peugeot', '456', 'vert', '15', '26', '20', 'moyen', '', '2024-04-19 11:21:25.000000', NULL, 'VTT', '2000', 'Stock', 'test1', '1'), ('2', '456', 'auchan', '963', 'bleu', '18', '26', '22', 'bon', '', '2024-04-19 11:21:25.000000', NULL, 'VTC', '2000', 'Stock', 'test2', '1');

-- Ajout de 1 utilisateur (devra être modifié)
INSERT INTO `utilisateur` (`id`, `nom`, `role`, `informations_de_contact`) VALUES ('1', 'geo trouvetout', '1', NULL);


-- Ajout de 1 diagnostique
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`) VALUES ('1', '1', '1', '2024-04-19 11:28:21.000000', NULL, 'a reparer');




-- Remplir table de liaison daignostic_element(à deplacer dans fichier valeurs listes SQL)
--INSERT INTO `diagnostic_element` (`id_diagnostic`, `id_element`, `id_etat`)
--SELECT diag.id, elem.id, etat.id
--FROM `diagnostic` AS diag
--CROSS JOIN `element_control` AS elem
--CROSS JOIN `etat_control` AS etat
--WHERE diag.id BETWEEN 1 AND 47;

-- ajout 12 elements dans diagnostique 1
INSERT INTO `diagnostic_element` (`id`, `id_diagnostic`, `id_element`, `commentaire`, `id_etat`) VALUES (NULL, '1', '1', 'test', '1'), (NULL, '1', '2', 'ff', '1'), (NULL, '1', '3', NULL, '2'), (NULL, '1', '4', 'cassée', '3'), (NULL, '1', '5', 'de cartes', '1'), (NULL, '1', '6', 'peu le plus', '1'), (NULL, '1', '7', NULL, '3'), (NULL, '1', '8', NULL, '1'), (NULL, '1', '9', NULL, '1'), (NULL, '1', '10', 'la gadoue', '1'), (NULL, '1', '11', NULL, '2'), (NULL, '1', '12', 'a glace', '4');

--requete SQL pour afficher resultat diagnostique 1
SELECT diagnostic.*, velo.*, diagnostic_element.*, element_control.element, etat_control.nom_etat
FROM diagnostic
INNER JOIN velo ON diagnostic.id_velo = velo.id
INNER JOIN diagnostic_element ON diagnostic.id = diagnostic_element.id_diagnostic
INNER JOIN element_control ON diagnostic_element.id_element = element_control.id
INNER JOIN etat_control ON diagnostic_element.id_etat = etat_control.id
WHERE diagnostic.id = [ID_DU_DIAGNOSTIC];

-- insertion 2eme diagnostique
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`) VALUES (NULL, '2', '1', '2024-04-19 11:28:21', NULL, 'a reparer'); 

-- insertion 19 elements dans diagnostic 2
INSERT INTO `diagnostic_element` (`id`, `id_diagnostic`, `id_element`, `commentaire`, `id_etat`) VALUES (NULL, '12', '1', NULL, '1'), (NULL, '12', '2', 'cassée', '3'), (NULL, '12', '3', '', '1'), (NULL, '12', '4', 'et torches', '1'), (NULL, '12', '5', 'inversée', '2'), (NULL, '12', '6', 'usé', '3'), (NULL, '12', '7', 'sans', '4'), (NULL, '12', '8', 'batons', '1'), (NULL, '12', '9', '', '1'), (NULL, '12', '10', 'absent', '4'), (NULL, '12', '11', '', '1'), (NULL, '12', '12', 'freins à disque', '4'), (NULL, '12', '13', '', '3'), (NULL, '12', '14', 'détendu', '2'), (NULL, '12', '15', '', '1'), (NULL, '12', '16', 'de fromages', '1'), (NULL, '12', '17', '', '3'), (NULL, '12', '18', 'a graisser', '2'), (NULL, '12', '19', 'rouille', '2');

-- requete pour afficher tous les diagnostic
SELECT diagnostic.*, velo.*, diagnostic_element.*, element_control.element, etat_control.nom_etat
FROM diagnostic
INNER JOIN velo ON diagnostic.id_velo = velo.id
INNER JOIN diagnostic_element ON diagnostic.id = diagnostic_element.id_diagnostic
INNER JOIN element_control ON diagnostic_element.id_element = element_control.id
INNER JOIN etat_control ON diagnostic_element.id_etat = etat_control.id;
