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
    date_de_reception DATE,
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
INSERT INTO Velo (id_velo, ref_recyclerie, numero_de_serie, marque, couleur, poids, taille_roues, taille_cadre, etat, url_photo, date_de_reception, date_de_vente, type, annee_modele, emplacement, commentaire)
VALUES (1, 'Ref001', 'NS001', 'Marque A', 'Rouge', 12.5, 26, 18, 'Bon état', 'url_photo1.jpg', '2024-04-15', NULL, 'VTT', 2020, 'Stock', 'Aucun commentaire');

-- Ajout du diagnostic pour le premier vélo
INSERT INTO Diagnostic (id_suivi, id_velo, id_utilisateur, date, cout_de_reparation, etat_diagnostic, cadre_aspect_general, cadre_bequille, cadre_commentaires, direction_guidon, direction_fourche, direction_jeu, direction_commentaires, roue_avant_pneu, roue_avant_chambre_air, roue_avant_rayonnage, roue_avant_moyeu_axe, roue_avant_garde_boue, roue_avant_commentaires, frein_avant_patin, frein_avant_levier, frein_avant_cable, frein_avant_tension, frein_avant_commentaires, transmission_pedales, transmission_reflecteurs, transmission_plateaux, transmission_axe, transmission_chaine, transmission_commentaires, derailleur_avant_derailleur, derailleur_avant_commande_manette, derailleur_avant_cable, derailleur_avant_tension, derailleur_commentaires, roue_arriere_pneu, roue_arriere_chambre_air, roue_arriere_rayonnage, roue_arriere_moyeu_axe, roue_arriere_garde_boue, roue_arriere_porte_bagages, roue_arriere_commentaires, frein_arriere_patin, frein_arriere_levier, frein_arriere_cable, frein_arriere_tension, frein_arriere_commentaires, derailleur_arriere_derailleur, derailleur_arriere_commande_manette, derailleur_arriere_cable, derailleur_arriere_tension, derailleur_arriere_pignons, derailleur_arriere_commentaires, assise_selle, assise_fixation, assise_commentaires, securite_dynamo, securite_eclairage, securite_lumiere_avant, lumiere_arriere, securite_catadioptres, securite_catadioptres_pedales, securite_reflecteurs_roues, securite_sonette, securite_commentaires, conclusion)
VALUES (1, 1, NULL, '2024-04-15', NULL, 'Bon état', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème');

-- Ajout du deuxième vélo à réparer
INSERT INTO Velo (id_velo, ref_recyclerie, numero_de_serie, marque, couleur, poids, taille_roues, taille_cadre, etat, url_photo, date_de_reception, date_de_vente, type, annee_modele, emplacement, commentaire)
VALUES (2, 'Ref002', 'NS002', 'Marque B', 'Bleu', 15.2, 28, 20, 'À réparer', 'url_photo2.jpg', '2024-04-15', NULL, 'VTT', 2018, 'Stock', 'Aucun commentaire');

-- Ajout du diagnostic pour le deuxième vélo
INSERT INTO Diagnostic (id_suivi, id_velo, id_utilisateur, date, cout_de_reparation, etat_diagnostic, cadre_aspect_general, cadre_bequille, cadre_commentaires, direction_guidon, direction_fourche, direction_jeu, direction_commentaires, roue_avant_pneu, roue_avant_chambre_air, roue_avant_rayonnage, roue_avant_moyeu_axe, roue_avant_garde_boue, roue_avant_commentaires, frein_avant_patin, frein_avant_levier, frein_avant_cable, frein_avant_tension, frein_avant_commentaires, transmission_pedales, transmission_reflecteurs, transmission_plateaux, transmission_axe, transmission_chaine, transmission_commentaires, derailleur_avant_derailleur, derailleur_avant_commande_manette, derailleur_avant_cable, derailleur_avant_tension, derailleur_commentaires, roue_arriere_pneu, roue_arriere_chambre_air, roue_arriere_rayonnage, roue_arriere_moyeu_axe, roue_arriere_garde_boue, roue_arriere_porte_bagages, roue_arriere_commentaires, frein_arriere_patin, frein_arriere_levier, frein_arriere_cable, frein_arriere_tension, frein_arriere_commentaires, derailleur_arriere_derailleur, derailleur_arriere_commande_manette, derailleur_arriere_cable, derailleur_arriere_tension, derailleur_arriere_pignons, derailleur_arriere_commentaires, assise_selle, assise_fixation, assise_commentaires, securite_dynamo, securite_eclairage, securite_lumiere_avant, lumiere_arriere, securite_catadioptres, securite_catadioptres_pedales, securite_reflecteurs_roues, securite_sonette, securite_commentaires, conclusion)
VALUES (2, 2, NULL, '2024-04-15', NULL, 'À réparer', 'Bon', 'Bon', 'Aucun problème', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes mineurs', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes mineurs', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Bon', 'Aucun problème');

-- Ajout du troisième vélo en mauvais état
INSERT INTO Velo (id_velo, ref_recyclerie, numero_de_serie, marque, couleur, poids, taille_roues, taille_cadre, etat, url_photo, date_de_reception, date_de_vente, type, annee_modele, emplacement, commentaire)
VALUES (3, 'Ref003', 'NS003', 'Marque C', 'Vert', 14.8, 24, 16, 'Mauvais état', 'url_photo3.jpg', '2024-04-15', NULL, 'VTT', 2015, 'Stock', 'Aucun commentaire');

-- Ajout du diagnostic pour le troisième vélo
INSERT INTO Diagnostic (id_suivi, id_velo, id_utilisateur, date, cout_de_reparation, etat_diagnostic, cadre_aspect_general, cadre_bequille, cadre_commentaires, direction_guidon, direction_fourche, direction_jeu, direction_commentaires, roue_avant_pneu, roue_avant_chambre_air, roue_avant_rayonnage, roue_avant_moyeu_axe, roue_avant_garde_boue, roue_avant_commentaires, frein_avant_patin, frein_avant_levier, frein_avant_cable, frein_avant_tension, frein_avant_commentaires, transmission_pedales, transmission_reflecteurs, transmission_plateaux, transmission_axe, transmission_chaine, transmission_commentaires, derailleur_avant_derailleur, derailleur_avant_commande_manette, derailleur_avant_cable, derailleur_avant_tension, derailleur_commentaires, roue_arriere_pneu, roue_arriere_chambre_air, roue_arriere_rayonnage, roue_arriere_moyeu_axe, roue_arriere_garde_boue, roue_arriere_porte_bagages, roue_arriere_commentaires, frein_arriere_patin, frein_arriere_levier, frein_arriere_cable, frein_arriere_tension, frein_arriere_commentaires, derailleur_arriere_derailleur, derailleur_arriere_commande_manette, derailleur_arriere_cable, derailleur_arriere_tension, derailleur_arriere_pignons, derailleur_arriere_commentaires, assise_selle, assise_fixation, assise_commentaires, securite_dynamo, securite_eclairage, securite_lumiere_avant, lumiere_arriere, securite_catadioptres, securite_catadioptres_pedales, securite_reflecteurs_roues, securite_sonette, securite_commentaires, conclusion)
VALUES (3, 3, NULL, '2024-04-15', NULL, 'Mauvais état', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Mauvais', 'Problèmes majeurs');
-- Ajout d'un utilisateur
INSERT INTO Utilisateur (id_utilisateur, nom, role, informations_de_contact, certifications)
VALUES (1, 'John Doe', 'Technicien', 'john.doe@example.com', 'Certification XYZ');


