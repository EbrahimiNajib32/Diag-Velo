
-- Ajout du premier propriétaire
INSERT INTO `proprietaire` (`id`, `nom_proprio`, `telephone`, `email`) VALUES (NULL, 'recylcerie', '06', 'test');

-- Ajout de 2 vélos
INSERT INTO `velo` (`id`, `proprietaire_id`, `numero_de_serie`, `marque`, `ref_recyclerie`, `couleur`, `poids`, `taille_roues`, `taille_cadre`, `etat`, `url_photo`, `date_de_reception`, `date_de_vente`, `type`, `emplacement`, `commentaire`, `date_destruction`, `public`) VALUES (NULL, '1', '123', 'peugeot', '456', 'vert', '12', '26', '20', '', NULL, '2024-04-25 09:08:55.000000', NULL, 'VTT', 'test', NULL, NULL, 'Femme'), (NULL, '1', NULL, 'auchan', '789', 'Bleu', '25', '24', '20', 'moyen', NULL, '2024-04-25 09:08:55.000000', NULL, 'Gravel', 'test2', 'a voir', NULL, 'Homme');

-- Ajout de 1 utilisateur 
INSERT INTO `utilisateur` (`id`, `nom`, `role`) VALUES (NULL, 'GeotrouveTout', '1');


-- Ajout de 1 diagnostique
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`) VALUES ('1', '1', '1', '2024-04-19 11:28:21.000000', NULL, 'a reparer');


-- ajout 12 elements dans diagnostique 1
INSERT INTO `diagnostic_element` (`id`, `id_diagnostic`, `id_element`, `commentaire`, `id_etat`) VALUES (NULL, '1', '1', 'test', '1'), (NULL, '1', '2', 'ff', '1'), (NULL, '1', '3', NULL, '2'), (NULL, '1', '4', 'cassée', '3'), (NULL, '1', '5', 'de cartes', '1'), (NULL, '1', '6', 'peu le plus', '1'), (NULL, '1', '7', NULL, '3'), (NULL, '1', '8', NULL, '1'), (NULL, '1', '9', NULL, '1'), (NULL, '1', '10', 'la gadoue', '1'), (NULL, '1', '11', NULL, '2'), (NULL, '1', '12', 'a glace', '4');


-- insertion 2eme diagnostique
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`) VALUES (NULL, '2', '1', '2024-04-19 11:28:21', NULL, 'a reparer'); 



