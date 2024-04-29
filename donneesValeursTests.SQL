
-- Ajout du premier propriétaire
INSERT INTO `proprietaire` (`id`, `nom_proprio`, `telephone`, `email`) VALUES (NULL, 'recylcerie', '06', 'test');

-- Ajout de 2 vélos
INSERT INTO `velo` (`id`, `proprietaire_id`, `numero_de_serie`, `marque`, `ref_recyclerie`, `couleur`, `poids`, `taille_roues`, `taille_cadre`, `etat`, `url_photo`, `date_de_enregistrement`, `date_de_vente`, `type`, `emplacement`, `commentaire`, `date_destruction`, `public`) VALUES (NULL, '1', '123', 'peugeot', '456', 'vert', '12', '26', '20', '', NULL, '2024-04-25 09:08:55.000000', NULL, 'VTT', 'test', NULL, NULL, 'Femme'), (NULL, '1', NULL, 'auchan', '789', 'Bleu', '25', '24', '20', 'moyen', NULL, '2024-04-25 09:08:55.000000', NULL, 'Gravel', 'test2', 'a voir', NULL, 'Homme');

-- Ajout de 1 utilisateur 
INSERT INTO `utilisateur` (`id`, `nom`, `role`) VALUES (NULL, 'GeotrouveTout', '1');


-- Ajout de 1 diagnostique
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`) VALUES ('1', '1', '1', '2024-04-19 11:28:21.000000', NULL, 'a reparer');

-- insertion 47 elements dans diagnostic 1
INSERT INTO `diagnostic_element` (`id`, `id_diagnostic`, `id_element`, `commentaire`, `id_etat`) VALUES (NULL, '1', '1', NULL, '1'), (NULL, '1', '2', NULL, '2'), (NULL, '1', '3', NULL, '3'), (NULL, '1', '4', 'tordue', '2'), (NULL, '1', '5', NULL, '1'), (NULL, '1', '6', NULL, '3'), (NULL, '1', '7', NULL, '3'), (NULL, '1', '8', NULL, '1'), (NULL, '1', '9', NULL, '3'), (NULL, '1', '10', NULL, '2'), (NULL, '1', '11', NULL, '2'), (NULL, '1', '12', NULL, '3'), (NULL, '1', '14', NULL, '2'), (NULL, '1', '15', NULL, '1'), (NULL, '1', '16', NULL, '3'), (NULL, '1', '17', NULL, '3'), (NULL, '1', '18', NULL, '4'), (NULL, '1', '19', NULL, '1'), (NULL, '1', '20', NULL, '2'), (NULL, '1', '21', NULL, '3'), (NULL, '1', '22', NULL, '3'), (NULL, '1', '23', NULL, '4'), (NULL, '1', '24', NULL, '2'), (NULL, '1', '25', NULL, '3'), (NULL, '1', '26', NULL, '3'), (NULL, '1', '27', NULL, '4'), (NULL, '1', '28', NULL, '2'), (NULL, '1', '29', NULL, '1'), (NULL, '1', '30', NULL, '3'), (NULL, '1', '31', NULL, '1'), (NULL, '1', '32', NULL, '2'), (NULL, '1', '33', NULL, '2'), (NULL, '1', '34', NULL, '1'), (NULL, '1', '35', NULL, '2'), (NULL, '1', '36', NULL, '1'), (NULL, '1', '37', NULL, '1'), (NULL, '1', '38', NULL, '3'), (NULL, '1', '39', NULL, '1'), (NULL, '1', '40', NULL, '1'), (NULL, '1', '41', NULL, '3'), (NULL, '1', '42', NULL, '3'), (NULL, '1', '43', NULL, '1'), (NULL, '1', '44', NULL, '3'), (NULL, '1', '45', NULL, '3'), (NULL, '1', '46', NULL, '3'), (NULL, '1', '47', NULL, '3'), (NULL, '1', '13', NULL, '1');


-- insertion 2eme diagnostique
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`) VALUES (NULL, '2', '1', '2024-04-19 11:28:21', NULL, 'a reparer'); 

-- insertion 12 lignes dans diagnostic 2
INSERT INTO `diagnostic_element` (`id`, `id_diagnostic`, `id_element`, `id_etat`, `commentaire`) VALUES (NULL, '2', '1', '1', NULL), (NULL, '2', '2', '4', NULL), (NULL, '2', '3', '2', 'attention'), (NULL, '2', '4', '1', NULL), (NULL, '2', '5', '3', 'trop de jeu'), (NULL, '2', '6', '1', NULL), (NULL, '2', '7', '3', 'crevée'), (NULL, '2', '8', '2', 'voilé'), (NULL, '2', '9', '1', NULL), (NULL, '2', '10', '4', NULL), (NULL, '2', '11', '3', 'absent'), (NULL, '2', '12', '1', NULL);

