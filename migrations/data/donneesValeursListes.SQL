
-- ATTENTION il faut intégrer en 1er ce fichier dans la base avant toute manipulations
-- Insérer les types de diagnostics
INSERT INTO `diagnostic_type` (`id`, `nom_type`, `date_creation_type`, `actif`)
VALUES
    ('1', 'Global test', '2024-11-01', '1'),
    ('2', 'Sécurité test', '2024-11-01', '1');


INSERT INTO element_control (id, element)
VALUES
    (1, 'sécurité: dynamo'),
    (2, 'sécurité: éclairage à piles'),
    (3, 'sécurité: lumière avant'),
    (4, 'sécurité: lumière arrière'),
    (5, 'sécurité: catadioptres Av+Ar'),
    (6, 'sécurité: catadioptre roue Av'), -- Ligne ajoutée
    (7, 'sécurité: catadioptre roue Ar'), -- Ligne ajoutée
    (8, 'sécurité: catadioptres pédales'),
    (9, 'sécurité: catadioptre pédale Droite'), -- Ligne ajoutée
    (10, 'sécurité: catadioptre pédale Gauche'), -- Ligne ajoutée
    (11, 'sécurité: catadioptres Av+Ar'),
    (12, 'sécurité: catadioptre Av Blanc'), -- Ligne ajoutée
    (13, 'sécurité: catadioptre Ar Rouge'), -- Ligne ajoutée
    (14, 'sécurité: sonnette'),
    (15, 'sécurité: casque'),
    (16, 'cadre: aspect général'),
    (17, 'cadre: béquille'),
    (18, 'direction: guidon'),
    (19, 'direction: fourche'),
    (20, 'direction: jeu'),
    (21, 'roue avant: pneu'),
    (22, 'roue avant: chambre à air'),
    (23, 'roue avant: rayonnage'),
    (24, 'roue avant: moyeu et axe'),
    (25, 'roue avant: garde-boue'),
    (26, 'frein avant: levier'),
    (27, 'frein avant: patin'),
    (28, 'frein avant: câble'),
    (29, 'frein avant: tension/réglage'),
    (30, 'transmission: pédales'),
    (31, 'transmission: plateaux'),
    (32, 'transmission: axe'),
    (33, 'transmission: chaîne'),
    (34, 'dérailleur avant: dérailleur'),
    (35, 'dérailleur avant: commande manette'),
    (36, 'dérailleur avant: câble'),
    (37, 'dérailleur avant: tension/réglage'),
    (38, 'roue arrière: pneu'),
    (39, 'roue arrière: chambre à air'),
    (40, 'roue arrière: rayonnage'),
    (41, 'roue arrière: moyeu et axe'),
    (42, 'roue arrière: garde-boue'),
    (43, 'roue arrière: porte-bagages'),
    (44, 'frein arrière: levier'),
    (45, 'frein arrière: patin'),
    (46, 'frein arrière: câble'),
    (47, 'frein arrière: tension/réglage'),
    (48, 'dérailleur arrière: dérailleur'),
    (49, 'dérailleur arrière: commande manette'),
    (50, 'dérailleur arrière: câble'),
    (51, 'dérailleur arrière: tension/réglage'),
    (52, 'dérailleur arrière: pignons'),
    (53, 'assise: selle'),
    (54, 'assise: fixation');


INSERT INTO etat_control (id, nom_etat)
VALUES
    (1, 'OK'),
    (2, 'À reviser'),
    (3, 'Pas OK'),
    (4, 'N/A');


-- Insérer les types de diagnostic et éléments de contrôle associés
INSERT INTO `diagnostic_type_elementcontrol` (`id`, `id_dianostic_type_id`, `id_elementcontrol_id`)
VALUES
    (1, 2, 1),
    (2, 2, 2),
    (3, 2, 3),
    (4, 2, 4),
    (5, 2, 5),
    (6, 2, 6),
    (7, 2, 7),
    (8, 2, 8),
    (9, 2, 9),
    (10, 2, 10),
    (11, 2, 11),
    (12, 2, 12),
    (13, 2, 13),
    (14, 2, 14),
    (15, 2, 15),
    (16, 1, 1),
    (17, 1, 2),
    (18, 1, 3),
    (19, 1, 4),
    (20, 1, 5),
    (21, 1, 6),
    (22, 1, 7),
    (23, 1, 8),
    (24, 1, 9),
    (25, 1, 10),
    (26, 1, 11),
    (27, 1, 12),
    (28, 1, 13),
    (29, 1, 14),
    (30, 1, 15),
    (31, 1, 16),
    (32, 1, 17),
    (33, 1, 18),
    (34, 1, 19),
    (35, 1, 20),
    (36, 1, 21),
    (37, 1, 22),
    (38, 1, 23),
    (39, 1, 24),
    (40, 1, 25),
    (41, 1, 26),
    (42, 1, 27),
    (43, 1, 28),
    (44, 1, 29),
    (45, 1, 30),
    (46, 1, 31),
    (47, 1, 32),
    (48, 1, 33),
    (49, 1, 34),
    (50, 1, 35),
    (51, 1, 36),
    (52, 1, 37),
    (53, 1, 38),
    (54, 1, 39),
    (55, 1, 40),
    (56, 1, 41),
    (57, 1, 42),
    (58, 1, 43),
    (59, 1, 44),
    (60, 1, 45),
    (61, 1, 46),
    (62, 1, 47),
    (63, 1, 48),
    (64, 1, 49),
    (65, 1, 50),
    (66, 1, 51),
    (67, 1, 52),
    (68, 1, 53),
    (69, 1, 54);


-- Ajout de 1 utilisateur
INSERT INTO `utilisateur` (`id`, `nom`, `role`,`password`,`is_active`) VALUES (NULL, 'Admin', '0' , '$2a$04$WgkgpAoIA.lnn.I6CzLa2uOuJGgxOuUya2cThdkBqGJFwlTSeW3Fa','1');

-- Ajout types de lieu
INSERT INTO `type_lieu` (`id`, `nom_type_lieu`, `actif`)
VALUES
     (1, 'Ecole', 1),
     (2, 'Collège', 1),
     (3, 'Lycée', 1);

