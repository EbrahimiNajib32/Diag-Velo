-- modification table diagnostic

ALTER TABLE diagnostic ADD COLUMN statut ENUM('terminé', 'en cours') DEFAULT 'en cours';



-- trigger pour un nouveau diagnostic

CREATE TRIGGER `insert_diagnostic_element_trigger` AFTER INSERT ON `diagnostic_element`
 FOR EACH ROW BEGIN
    DECLARE diag_statut VARCHAR(10);
    DECLARE element_control_count INT;
    
    -- Obtenir le statut actuel du diagnostic
    SELECT statut INTO diag_statut FROM diagnostic WHERE id = NEW.id_diagnostic;

    -- Compter le nombre d'éléments dans element_control
    SELECT COUNT(*) INTO element_control_count FROM element_control;
    
    -- Vérifier si le diagnostic est terminé ou en cours
    IF (SELECT COUNT(*) FROM diagnostic_element WHERE id_diagnostic = NEW.id_diagnostic) = element_control_count THEN
        IF diag_statut != 'terminé' THEN
            UPDATE diagnostic SET statut = 'terminé' WHERE id = NEW.id_diagnostic;
        END IF;
    ELSE
        IF diag_statut != 'en cours' THEN
            UPDATE diagnostic SET statut = 'en cours' WHERE id = NEW.id_diagnostic;
        END IF;
    END IF;
END




-- trigger pour la mise à jour d'un diagnostic

CREATE TRIGGER `update_diagnostic_element_trigger` AFTER UPDATE ON `diagnostic_element`
 FOR EACH ROW BEGIN
    DECLARE diag_statut VARCHAR(10);
    DECLARE element_control_count INT;
    
    -- Obtenir le statut actuel du diagnostic
    SELECT statut INTO diag_statut FROM diagnostic WHERE id = OLD.id_diagnostic;

     -- Compter le nombre d'éléments dans element_control
    SELECT COUNT(*) INTO element_control_count FROM element_control;
    
    -- Vérifier si le diagnostic est terminé ou en cours
    IF (SELECT COUNT(*) FROM diagnostic_element WHERE id_diagnostic = OLD.id_diagnostic) = element_control_count THEN
        IF diag_statut != 'terminé' THEN
            UPDATE diagnostic SET statut = 'terminé' WHERE id = OLD.id_diagnostic;
        END IF;
    ELSE
        IF diag_statut != 'en cours' THEN
            UPDATE diagnostic SET statut = 'en cours' WHERE id = OLD.id_diagnostic;
        END IF;
    END IF;
END
