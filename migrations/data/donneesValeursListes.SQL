
-- ATTENTION il faut intégrer en 1er ce fichier dans la base avant toute manipulations
-- Insérer les types de diagnostics
INSERT INTO `diagnostic_type` (`id`, `nom_type`, `date_creation_type`, `actif`)
VALUES
    ('1', 'Global', '2024-11-01', '1'),
    ('2', 'Sécurité', '2024-11-01', '1');


INSERT INTO element_control (id, element)
VALUES
    (1, 'sécurité: dynamo'),
    (2, 'sécurité: éclairage à piles'),
    (3, 'sécurité: lumière avant'),
    (4, 'sécurité: lumière arrière'),
    (5, 'sécurité: catadioptres Av+Ar'),
    (6, 'sécurité: catadioptres pédales'),
    (7, 'sécurité: catadioptres roues Av+Ar'),
    (8, 'sécurité: sonnette'),
    (9, 'cadre: aspect général'),
    (10, 'cadre: béquille'),
    (11, 'direction: guidon'),
    (12, 'direction: fourche'),
    (13, 'direction: jeu'),
    (14, 'roue avant: pneu'),
    (15, 'roue avant: chambre à air'),
    (16, 'roue avant: rayonnage'),
    (17, 'roue avant: moyeu et axe'),
    (18, 'roue avant: garde-boue'),
    (19, 'frein avant: levier'),
    (20, 'frein avant: patin'),
    (21, 'frein avant: câble'),
    (22, 'frein avant: tension/réglage'),
    (23, 'transmission: pédales'),
    (24, 'transmission: plateaux'),
    (25, 'transmission: axe'),
    (26, 'transmission: chaîne'),
    (27, 'dérailleur avant: dérailleur'),
    (28, 'dérailleur avant: commande manette'),
    (29, 'dérailleur avant: câble'),
    (30, 'dérailleur avant: tension/réglage'),
    (31, 'roue arrière: pneu'),
    (32, 'roue arrière: chambre à air'),
    (33, 'roue arrière: rayonnage'),
    (34, 'roue arrière: moyeu et axe'),
    (35, 'roue arrière: garde-boue'),
    (36, 'roue arrière: porte-bagages'),
    (37, 'frein arrière: levier'),
    (38, 'frein arrière: patin'),
    (39, 'frein arrière: câble'),
    (40, 'frein arrière: tension/réglage'),
    (41, 'dérailleur arrière: dérailleur'),
    (42, 'dérailleur arrière: commande manette'),
    (43, 'dérailleur arrière: câble'),
    (44, 'dérailleur arrière: tension/réglage'),
    (45, 'dérailleur arrière: pignons'),
    (46, 'assise: selle'),
    (47, 'assise: fixation');


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
    (9, 1, 1),
    (10, 1, 2),
    (11, 1, 3),
    (12, 1, 4),
    (13, 1, 5),
    (14, 1, 6),
    (15, 1, 7),
    (16, 1, 8),
    (17, 1, 9),
    (18, 1, 10),
    (19, 1, 11),
    (20, 1, 12),
    (21, 1, 13),
    (22, 1, 14),
    (23, 1, 15),
    (24, 1, 16),
    (25, 1, 17),
    (26, 1, 18),
    (27, 1, 19),
    (28, 1, 20),
    (29, 1, 21),
    (30, 1, 22),
    (31, 1, 23),
    (32, 1, 24),
    (33, 1, 25),
    (34, 1, 26),
    (35, 1, 27),
    (36, 1, 28),
    (37, 1, 29),
    (38, 1, 30),
    (39, 1, 31),
    (40, 1, 32),
    (41, 1, 33),
    (42, 1, 34),
    (43, 1, 35),
    (44, 1, 36),
    (45, 1, 37),
    (46, 1, 38),
    (47, 1, 39),
    (48, 1, 40),
    (49, 1, 41),
    (50, 1, 42),
    (51, 1, 43),
    (52, 1, 44),
    (53, 1, 45),
    (54, 1, 46),
    (55, 1, 47);

-- Ajout de 1 utilisateur
INSERT INTO `utilisateur` (`id`, `nom`, `role`,`password`,`is_active`) VALUES (NULL, 'Admin', '0' , '$2a$04$WgkgpAoIA.lnn.I6CzLa2uOuJGgxOuUya2cThdkBqGJFwlTSeW3Fa','1');
