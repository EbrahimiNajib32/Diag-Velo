-- Création de la table Vélo
CREATE TABLE Velo (
    id_velo INT PRIMARY KEY,
    ref_recyclerie VARCHAR(50),
    numero_de_serie VARCHAR(50),
    marque VARCHAR(50),
    couleur VARCHAR(50),
    poids DECIMAL(5,2),
    taille_roues INT,
    taille_cadre INT,
    etat VARCHAR(50),
    url_photo VARCHAR(255),
    date_de_enregistrement DATE,
    date_de_vente DATE,
    type VARCHAR(50),
    annee_modele INT,
    emplacement VARCHAR(100),
    commentaire TEXT,
);

-- Création de la table Utilisateur
CREATE TABLE Utilisateur (
    id_utilisateur INT PRIMARY KEY,
    nom VARCHAR(100),
    role VARCHAR(50),
    informations_de_contact VARCHAR(255),
    certifications VARCHAR(255)
);

-- Création de la table Diagnostic
CREATE TABLE Diagnostic (
    id_suivi INT PRIMARY KEY,
    id_velo INT,
    id_utilisateur INT,
    date DATE,
    cout_de_reparation DECIMAL(8,2),
    etat_diagnostic VARCHAR(50),
    cadre_aspect_general VARCHAR(100),
    cadre_bequille VARCHAR(50),
    cadre_commentaires TEXT,
    direction_guidon VARCHAR(50),
    direction_fourche VARCHAR(50),
    direction_jeu VARCHAR(50),
    direction_commentaires TEXT,
    roue_avant_pneu VARCHAR(50),
    roue_avant_chambre_air VARCHAR(50),
    roue_avant_rayonnage VARCHAR(50),
    roue_avant_moyeu_axe VARCHAR(50),
    roue_avant_garde_boue VARCHAR(50),
    roue_avant_commentaires TEXT,
    frein_avant_patin VARCHAR(50),
    frein_avant_levier VARCHAR(50),
    frein_avant_cable VARCHAR(50),
    frein_avant_tension VARCHAR(50),
    frein_avant_commentaires TEXT,
    transmission_pedales VARCHAR(50),
    transmission_reflecteurs VARCHAR(50),
    transmission_plateaux VARCHAR(50),
    transmission_axe VARCHAR(50),
    transmission_chaine VARCHAR(50),
    transmission_commentaires TEXT,
    derailleur_avant_derailleur VARCHAR(50),
    derailleur_avant_commande_manette VARCHAR(50),
    derailleur_avant_cable VARCHAR(50),
    derailleur_avant_tension VARCHAR(50),
    derailleur_commentaires TEXT,
    roue_arriere_pneu VARCHAR(50),
    roue_arriere_chambre_air VARCHAR(50),
    roue_arriere_rayonnage VARCHAR(50),
    roue_arriere_moyeu_axe VARCHAR(50),
    roue_arriere_garde_boue VARCHAR(50),
    roue_arriere_porte_bagages VARCHAR(50),
    roue_arriere_commentaires TEXT,
    frein_arriere_patin VARCHAR(50),
    frein_arriere_levier VARCHAR(50),
    frein_arriere_cable VARCHAR(50),
    frein_arriere_tension VARCHAR(50),
    frein_arriere_commentaires TEXT,
    derailleur_arriere_derailleur VARCHAR(50),
    derailleur_arriere_commande_manette VARCHAR(50),
    derailleur_arriere_cable VARCHAR(50),
    derailleur_arriere_tension VARCHAR(50),
    derailleur_arriere_pignons VARCHAR(50),
    derailleur_arriere_commentaires TEXT,
    assise_selle VARCHAR(50),
    assise_fixation VARCHAR(50),
    assise_commentaires TEXT,
    securite_dynamo VARCHAR(50),
    securite_eclairage VARCHAR(50),
    securite_lumiere_avant VARCHAR(50),
    lumiere_arriere VARCHAR(50),
    securite_catadioptres VARCHAR(50),
    securite_catadioptres_pedales VARCHAR(50),
    securite_reflecteurs_roues VARCHAR(50),
    securite_sonette VARCHAR(50),
    securite_commentaires TEXT,
    conclusion TEXT,
    FOREIGN KEY (id_velo) REFERENCES Velo(id_velo),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);
-- Ajout du premier vélo en bon état
INSERT INTO Velo (id_velo, ref_recyclerie, numero_de_serie, marque, couleur, poids, taille_roues, taille_cadre, etat, url_photo, date_de_enregistrement, date_de_vente, type, annee_modele, emplacement, commentaire)
VALUES (1, 'Ref001', 'NS001', 'Marque A', 'Rouge', 12.5, 26, 18, 'Bon état', 'url_photo1.jpg', '2024-04-15', NULL, 'VTT', 2020, 'Stock', 'Aucun commentaire');

-- Ajout du diagnostic pour le premier vélo
INSERT INTO Diagnostic (id_suivi, id_velo, id_utilisateur, date, cout_de_reparation, etat_diagnostic, cadre_aspect_general, cadre_bequille, cadre_commentaires, direction_guidon, direction_fourche, direction_jeu, direction_commentaires, roue_avant_pneu, roue_avant_chambre_air, roue_avant_rayonnage, roue_avant_moyeu_axe, roue_avant_garde_boue, roue_avant_commentaires, frein_avant_patin, frein_avant_levier, frein_avant_cable, frein_avant_tension, frein_avant_commentaires, transmission_pedales, transmission_reflecteurs, transmission_plateaux, transmission_axe, transmission_chaine, transmission_commentaires, derailleur_avant_derailleur, derailleur_avant_commande_manette, derailleur_avant_cable, derailleur_avant_tension, derailleur_commentaires, roue_arriere_pneu, roue_arriere_chambre_air, roue_arriere_rayonnage, roue_arriere_moyeu_axe, roue_arriere_garde_boue, roue_arriere_porte_bagages, roue_arriere_commentaires, frein_arriere_patin, frein_arriere_levier, frein_arriere_cable, frein_arriere_tension, frein_arriere_commentaires, derailleur_arriere_derailleur, derailleur_arriere_commande_manette, derailleur_arriere_cable, derailleur_arriere_tension, derailleur_arriere_pignons, derailleur_arriere_commentaires, assise_selle, assise_fixation, assise_commentaires, securite_dynamo, securite_eclairage, securite_lumiere_avant, lumiere_arriere, securite_catadioptres, securite_catadioptres_pedales, securite_reflecteurs_roues, securite_sonette, securite_commentaires, conclusion)
VALUES (1, 1, NULL, '2024-04-15', NULL, 'Bon état', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème');

-- Ajout du deuxième vélo à réparer
INSERT INTO Velo (id_velo, ref_recyclerie, numero_de_serie, marque, couleur, poids, taille_roues, taille_cadre, etat, url_photo, date_de_enregistrement, date_de_vente, type, annee_modele, emplacement, commentaire)
VALUES (2, 'Ref002', 'NS002', 'Marque B', 'Bleu', 15.2, 28, 20, 'À réparer', 'url_photo2.jpg', '2024-04-15', NULL, 'VTT', 2018, 'Stock', 'Aucun commentaire');

-- Ajout du diagnostic pour le deuxième vélo
INSERT INTO Diagnostic (id_suivi, id_velo, id_utilisateur, date, cout_de_reparation, etat_diagnostic, cadre_aspect_general, cadre_bequille, cadre_commentaires, direction_guidon, direction_fourche, direction_jeu, direction_commentaires, roue_avant_pneu, roue_avant_chambre_air, roue_avant_rayonnage, roue_avant_moyeu_axe, roue_avant_garde_boue, roue_avant_commentaires, frein_avant_patin, frein_avant_levier, frein_avant_cable, frein_avant_tension, frein_avant_commentaires, transmission_pedales, transmission_reflecteurs, transmission_plateaux, transmission_axe, transmission_chaine, transmission_commentaires, derailleur_avant_derailleur, derailleur_avant_commande_manette, derailleur_avant_cable, derailleur_avant_tension, derailleur_commentaires, roue_arriere_pneu, roue_arriere_chambre_air, roue_arriere_rayonnage, roue_arriere_moyeu_axe, roue_arriere_garde_boue, roue_arriere_porte_bagages, roue_arriere_commentaires, frein_arriere_patin, frein_arriere_levier, frein_arriere_cable, frein_arriere_tension, frein_arriere_commentaires, derailleur_arriere_derailleur, derailleur_arriere_commande_manette, derailleur_arriere_cable, derailleur_arriere_tension, derailleur_arriere_pignons, derailleur_arriere_commentaires, assise_selle, assise_fixation, assise_commentaires, securite_dynamo, securite_eclairage, securite_lumiere_avant, lumiere_arriere, securite_catadioptres, securite_catadioptres_pedales, securite_reflecteurs_roues, securite_sonette, securite_commentaires, conclusion)
VALUES (2, 2, NULL, '2024-04-15', NULL, 'À réparer', 'Bon', 'Bon', 'Aucun problème', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes mineurs', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes mineurs', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème');

-- Ajout du troisième vélo en mauvais état
INSERT INTO Velo (id_velo, ref_recyclerie, numero_de_serie, marque, couleur, poids, taille_roues, taille_cadre, etat, url_photo, date_de_enregistrement, date_de_vente, type, annee_modele, emplacement, commentaire)
VALUES (3, 'Ref003', 'NS003', 'Marque C', 'Vert', 14.8, 24, 16, 'Mauvais état', 'url_photo3.jpg', '2024-04-15', NULL, 'VTT', 2015, 'Stock', 'Aucun commentaire');

-- Ajout du diagnostic pour le troisième vélo
INSERT INTO Diagnostic (id_suivi, id_velo, id_utilisateur, date, cout_de_reparation, etat_diagnostic, cadre_aspect_general, cadre_bequille, cadre_commentaires, direction_guidon, direction_fourche, direction_jeu, direction_commentaires, roue_avant_pneu, roue_avant_chambre_air, roue_avant_rayonnage, roue_avant_moyeu_axe, roue_avant_garde_boue, roue_avant_commentaires, frein_avant_patin, frein_avant_levier, frein_avant_cable, frein_avant_tension, frein_avant_commentaires, transmission_pedales, transmission_reflecteurs, transmission_plateaux, transmission_axe, transmission_chaine, transmission_commentaires, derailleur_avant_derailleur, derailleur_avant_commande_manette, derailleur_avant_cable, derailleur_avant_tension, derailleur_commentaires, roue_arriere_pneu, roue_arriere_chambre_air, roue_arriere_rayonnage, roue_arriere_moyeu_axe, roue_arriere_garde_boue, roue_arriere_porte_bagages, roue_arriere_commentaires, frein_arriere_patin, frein_arriere_levier, frein_arriere_cable, frein_arriere_tension, frein_arriere_commentaires, derailleur_arriere_derailleur, derailleur_arriere_commande_manette, derailleur_arriere_cable, derailleur_arriere_tension, derailleur_arriere_pignons, derailleur_arriere_commentaires, assise_selle, assise_fixation, assise_commentaires, securite_dynamo, securite_eclairage, securite_lumiere_avant, lumiere_arriere, securite_catadioptres, securite_catadioptres_pedales, securite_reflecteurs_roues, securite_sonette, securite_commentaires, conclusion)
VALUES (3, 3, NULL, '2024-04-15', NULL, 'Mauvais état', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs');
-- Ajout d'un utilisateur
INSERT INTO Utilisateur (id_utilisateur, nom, role, informations_de_contact, certifications)
VALUES (1, 'John Doe', 'Technicien', 'john.doe@example.com', 'Certification XYZ');

INSERT INTO Velos (id_velo, ref_recyclerie, numéro_de_série, type, marque, année, couleur, poids, taille_roue, taille_cadre, photo, etat, date_de_enregistrement, date_vente, date_destruction, emplacement, commentaires)
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

