-- Ajout du premier propriétaire
INSERT INTO `proprietaire` (`id`, `nom_proprio`, `telephone`, `email`) VALUES (NULL, 'recylcerie', '06', 'test');

-- Ajout de 2 vélos
INSERT INTO `velo` (`id`, `proprietaire_id`, `numero_de_serie`, `marque`, `ref_recyclerie`, `couleur`, `poids`, `taille_roues`, `taille_cadre`, `etat`, `url_photo`, `date_de_enregistrement`, `date_de_vente`, `type`, `emplacement`, `commentaire`, `date_destruction`, `public`) VALUES (NULL, '1', '123', 'peugeot', '456', 'vert', '12', '26', '20', '', NULL, '2024-04-25 09:08:55.000000', NULL, 'VTT', 'test', NULL, NULL, 'Femme'), (NULL, '1', NULL, 'auchan', '789', 'Bleu', '25', '24', '20', 'moyen', NULL, '2024-04-25 09:08:55.000000', NULL, 'Gravel', 'test2', 'a voir', NULL, 'Homme');

-- Ajout de 1 utilisateur 
INSERT INTO `utilisateur` (`id`, `nom`, `role`,`password`,`is_active`) VALUES (NULL, 'Admin', '0' , '$2a$04$WgkgpAoIA.lnn.I6CzLa2uOuJGgxOuUya2cThdkBqGJFwlTSeW3Fa','1');

-- Ajout type de diagnostique
INSERT INTO `diagnostic_type` (`id`, `nom_type`, `date_creation_type`, `actif`) VALUES
(1, 'Global', '2024-05-06', 1),
(2, 'Sécurité', '2024-05-06', 1);

-- Ajout Elements dans type de diagnostique sécurité
INSERT INTO `diagnostic_type_elementcontrol` (`id`, `id_dianostic_type_id`, `id_elementcontrol_id`) VALUES (NULL, '2', '40'), (NULL, '2', '41'), (NULL, '2', '42'), (NULL, '2', '43'), (NULL, '2', '44'), (NULL, '2', '45'), (NULL, '2', '46'), (NULL, '2', '47');

-- Ajout d'un diagnostic de type sécurité
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`, `status`, `diagnostic_type_id`) VALUES (NULL, '1', '1', '2024-05-06 07:20:10.000000', NULL, NULL, NULL, '2');

-- Ajout information dans diagnostic sécurité
INSERT INTO `diagnostic_element` (`id`, `id_diagnostic`, `id_element`, `id_etat`, `commentaire`) VALUES (NULL, '1', '40', '1', NULL), (NULL, '1', '41', '3', NULL), (NULL, '1', '42', '1', NULL), (NULL, '1', '43', '4', NULL), (NULL, '1', '44', '1', NULL), (NULL, '1', '45', '1', NULL), (NULL, '1', '46', '2', NULL);

-- Ajout Elements dans type de diagnostic Global
INSERT INTO `diagnostic_type_elementcontrol` (`id`, `id_dianostic_type_id`, `id_elementcontrol_id`) VALUES (NULL, '1', '1'), (NULL, '1', '2'), (NULL, '1', '3'), (NULL, '1', '4'), (NULL, '1', '5'), (NULL, '1', '6'), (NULL, '1', '7'), (NULL, '1', '8'), (NULL, '1', '9'), (NULL, '1', '10'), (NULL, '1', '11'), (NULL, '1', '12'), (NULL, '1', '13'), (NULL, '1', '14'), (NULL, '1', '15'), (NULL, '1', '16'), (NULL, '1', '17'), (NULL, '1', '18'), (NULL, '1', '19'), (NULL, '1', '20'), (NULL, '1', '21'), (NULL, '1', '22');

-- Ajout d'un diagnostic de type global
INSERT INTO `diagnostic` (`id`, `id_velo`, `id_user`, `date_diagnostic`, `cout_reparation`, `conclusion`, `status`, `diagnostic_type_id`) VALUES (NULL, '1', '1', '2024-05-06 13:35:46.000000', NULL, NULL, NULL, '1');

-- Ajout informations dans diagnostic global
INSERT INTO `diagnostic_element` (`id`, `id_diagnostic`, `id_element`, `id_etat`, `commentaire`) VALUES (NULL, '2', '1', '1', NULL), (NULL, '2', '2', '1', NULL), (NULL, '2', '3', '2', NULL), (NULL, '2', '4', '1', NULL), (NULL, '2', '5', '1', NULL), (NULL, '2', '6', '1', NULL), (NULL, '2', '7', '2', NULL), (NULL, '2', '8', '1', NULL), (NULL, '2', '9', '3', NULL), (NULL, '2', '10', '4', NULL), (NULL, '2', '11', '1', NULL), (NULL, '2', '12', '1', NULL), (NULL, '2', '13', '1', NULL), (NULL, '2', '14', '1', NULL), (NULL, '2', '15', '1', NULL), (NULL, '2', '16', '1', NULL), (NULL, '2', '17', '1', NULL), (NULL, '2', '18', '1', NULL), (NULL, '2', '19', '1', NULL), (NULL, '2', '20', '1', NULL), (NULL, '2', '21', '1', NULL), (NULL, '2', '22', '1', NULL);

