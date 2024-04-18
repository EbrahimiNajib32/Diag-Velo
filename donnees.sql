INSERT INTO Velos (id_velo, ref_recyclerie, numéro_de_série, type, marque, année, couleur, poids, taille_roue, taille_cadre, photo, etat, date_reception, date_vente, date_destruction, emplacement, commentaires)
VALUES
    (1, '12345L', '241221', 'VTT', 'Bianchi', 2021, 'Bleu', 14, 27, 55, 'url_photo1', 'Neuf', '2024-04-01', NULL, NULL, 'Allée 3', 'Vélo neuf, aucun problème'),
    (2, '78901F', '412122', 'VTC', 'Trek', 2022, 'Rouge', 8, 25, 50, 'url_photo2', 'Occasion', '2024-03-21', NULL, NULL, 'Allée 1', 'Nécessite un contrôle'),
    (3, '34567F', '314123', 'Pliable', 'Giant', 2020, 'Vert', 12, 26, 52, 'url_photo3', 'Occasion', '2024-03-30', NULL, NULL, 'Allée 2', 'En très bon état');

INSERT INTO Utilisateur (id_user, nom, rôle, infos_contact, certifications)
VALUES
    (1, 'admin', 'admin', 'admin@email.com', NULL),
    (2, 'Non admin', 'Utilisateur', 'NOadmin@email.com', NULL);

INSERT INTO Element_controle (id_element, element)
VALUES
    (1, 'cadre: aspect général'),
    (2, 'cadre: béquille'),
    (3, 'cadre: commentaires'),
    (4, 'direction: guidon'),
    (5, 'direction: fourche'),
    (6, 'direction: jeu'),
    (7, 'direction: commentaires'),
    (8, 'roue avant: pneu'),
    (9, 'roue avant: chambre à air'),
    (10, 'roue avant: rayonnage'),
    (11, 'roue avant: moyeu et axe'),
    (12, 'roue avant: garde-boue'),
    (13, 'roue avant: commentaires'),
    (14, 'frein avant: levier'),
    (15, 'frein avant: patin'),
    (16, 'frein avant: câble'),
    (17, 'frein avant: tension/réglage'),
    (18, 'frein avant: commentaires'),
    (19, 'transmission: pédales'),
    (20, 'transmission: réflecteurs G+D ?'),
    (21, 'transmission: plateaux'),
    (22, 'transmission: axe'),
    (23, 'transmission: chaîne'),
    (24, 'transmission: commentaires'),
    (25, 'dérailleur avant: commande manette'),
    (26, 'dérailleur avant: câble'),
    (27, 'dérailleur avant: tension/réglage'),
    (28, 'dérailleur avant: commentaires'),
    (29, 'roue arrière: pneu'),
    (30, 'roue arrière: chambre à air'),
    (31, 'roue arrière: rayonnage'),
    (32, 'roue arrière: moyeu et axe'),
    (33, 'roue arrière: garde-boue'),
    (34, 'roue arrière: porte-bagages'),
    (35, 'roue arrière: commentaires'),
    (36, 'frein arrière: levier'),
    (37, 'frein arrière: patin'),
    (38, 'frein arrière: câble'),
    (39, 'frein arrière: tension/réglage'),
    (40, 'frein arrière: commentaires'),
    (41, 'dérailleur arrière: commande manette'),
    (42, 'dérailleur arrière: câble'),
    (43, 'dérailleur arrière: tension/réglage'),
    (44, 'dérailleur arrière: pignons'),
    (45, 'dérailleur arrière: commentaires'),
    (46, 'assise: selle'),
    (47, 'assise: fixation'),
    (48, 'assise: commentaires'),
    (49, 'sécurité: dynamo'),
    (50, 'sécurité: éclairage avant'),
    (51, 'sécurité: éclairage arrière'),
    (52, 'sécurité: lumière avant'),
    (53, 'sécurité: lumière arrière'),
    (54, 'sécurité: catadioptres Av+Ar ?'),
    (55, 'sécurité: catadioptres pédales ?'),
    (56, 'sécurité: catadioptres roues'),
    (57, 'sécurité: sonnette');

INSERT INTO Etat_controles (id_etat, nom_etat)
VALUES
    (1, 'OK'),
    (2, 'Pas OK'),
    (3, 'À reviser'),
    (4, 'N/A');

INSERT INTO Diagnostique_velo (id_diagnostique, id_velo, id_user, date_diagnostique, cout_reparation, conclusion)
VALUES
    (1, 2, 1, '2024-04-05', 0.00, 'Réparation mineure');


INSERT INTO Diagnostique_element (id_diagnostique, id_element, commentaire, id_etat)
VALUES
    (1, 1, 'Les freins usés', 2);


INSERT INTO Diagnostique_velo (id_diagnostique, id_velo, id_user, date_diagnostique, cout_reparation, conclusion)
VALUES
    (2, 3, 1, '2024-04-15', 0.00, 'Réparation majeure');

INSERT INTO Diagnostique_velo (id_diagnostique, id_velo, id_user, date_diagnostique, cout_reparation, conclusion)
VALUES
    (3, 1, 1, '2024-04-16', 150.00, 'Réparations multiples nécessaires');


INSERT INTO Diagnostique_element (id_diagnostique, id_element, commentaire, id_etat)
VALUES
    (3, 1, 'Cadre légèrement rayé mais structurellement sain', 1),
    (3, 4, 'Guidon droit et solide, aucun jeu', 1),
    (3, 5, 'Fourche nécessite un réalignement, légère déformation', 2),
    (3, 8, 'Pneu avant usé, doit être remplacé', 2),
    (3, 10, 'Rayonnage avant en bon état', 1),
    (3, 11, 'Moyeu avant nécessite graissage', 3),
    (3, 14, 'Levier de frein avant fonctionne correctement', 1),
    (3, 15, 'Plaquettes de frein avant à remplacer', 2),
    (3, 19, 'Pédales en excellent état', 1),
    (3, 21, 'Plateaux corrodés, changement nécessaire', 2),
    (3, 23, 'Chaîne rouillée, doit être changée', 2),
    (3, 25, 'Commande du dérailleur avant répond bien', 1),
    (3, 27, 'Réglage de tension du dérailleur avant nécessaire', 3),
    (3, 29, 'Pneu arrière neuf', 1),
    (3, 31, 'Rayonnage arrière en bon état, aucun rayon manquant', 1),
    (3, 32, 'Moyeu arrière bruyant, potentiellement usé', 3),
    (3, 34, 'Porte-bagages arrière stable et sécurisé', 1),
    (3, 36, 'Levier de frein arrière fonctionne correctement', 1),
    (3, 37, 'Plaquettes de frein arrière usées, à surveiller', 3),
    (3, 42, 'Câble du dérailleur arrière à remplacer', 2),
    (3, 44, 'Pignons arrière en bon état, nettoyage recommandé', 3),
    (3, 46, 'Selle confortable, aucun défaut visible', 1),
    (3, 48, 'Commentaires sur lassise: vérifier la stabilité régulièrement', 1),
    (3, 49, 'Dynamo fonctionne parfaitement', 1),
    (3, 50, 'Éclairage avant opérationnel', 1),
    (3, 51, 'Éclairage arrière faible, possible problème électrique', 2),
    (3, 54, 'Catadioptres avant et arrière en place', 1),
    (3, 57, 'Sonnette manquante, à ajouter', 2);

