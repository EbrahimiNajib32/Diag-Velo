DELIMITER //
CREATE TRIGGER `insert_diagnostic_element_trigger` AFTER INSERT ON `diagnostic_element`
FOR EACH ROW 
BEGIN
    DECLARE type_element_control_count INT;
    DECLARE diagnostic_control_count INT;

    -- Compter le nombre d'éléments de contrôle associés au type de diagnostic pour le diagnostic concerné
    SELECT COUNT(*) INTO type_element_control_count
    FROM diagnostic_type_elementcontrol dtec
    WHERE dtec.id_dianostic_type_id = (
        SELECT diagnostic_type_id
        FROM diagnostic
        WHERE id = NEW.id_diagnostic
    );

    -- Compter le nombre d'éléments de contrôle saisis pour le diagnostic concerné
    SELECT COUNT(*) INTO diagnostic_control_count
    FROM diagnostic_element
    WHERE id_diagnostic = NEW.id_diagnostic;

    -- Vérifier si le diagnostic est terminé ou en cours
    IF diagnostic_control_count = type_element_control_count THEN
        UPDATE diagnostic SET status = 'terminé' WHERE id = NEW.id_diagnostic;
    ELSE
        UPDATE diagnostic SET status = 'en cours' WHERE id = NEW.id_diagnostic;
    END IF;
END


//

-- Trigger pour la mise à jour d'un diagnostic.
CREATE TRIGGER `update_diagnostic_element_trigger` AFTER UPDATE ON `diagnostic_element`
FOR EACH ROW
BEGIN
    DECLARE type_element_control_count INT;
    DECLARE diagnostic_control_count INT;
    
    -- Compter le nombre d'éléments de contrôle associés au type de diagnostic pour le diagnostic concerné
    SELECT COUNT(*) INTO type_element_control_count
    FROM diagnostic_type_elementcontrol dtec
    WHERE dtec.id_dianostic_type_id = (
        SELECT diagnostic_type_id
        FROM diagnostic
        WHERE id = OLD.id_diagnostic
    );
    
    -- Compter le nombre d'éléments de contrôle mis à jour pour le diagnostic concerné
    SELECT COUNT(*) INTO diagnostic_control_count
    FROM diagnostic_element
    WHERE id_diagnostic = OLD.id_diagnostic;

    -- Vérifier si le diagnostic est terminé ou en cours
    IF diagnostic_control_count = type_element_control_count THEN
        UPDATE diagnostic SET status = 'terminé' WHERE id = OLD.id_diagnostic;
    ELSE
        UPDATE diagnostic SET status = 'en cours' WHERE id = OLD.id_diagnostic;
    END IF;
END
//
DELIMITER ;