DELIMITER //
-- trigger pour un nouveau diagnostic
CREATE TRIGGER `insert_diagnostic_element_trigger` AFTER INSERT ON `diagnostic_element`
FOR EACH ROW 
BEGIN
    DECLARE diag_status VARCHAR(10);
    DECLARE element_control_count INT;
    


    -- Compter le nombre d'éléments dans element_control
    SELECT COUNT(*) INTO element_control_count FROM element_control;
    
    -- Vérifier si le diagnostic est terminé ou en cours
    IF (SELECT COUNT(*) FROM diagnostic_element WHERE id_diagnostic = NEW.id_diagnostic) = element_control_count THEN
        
            UPDATE diagnostic SET status = 'terminé' WHERE id = NEW.id_diagnostic;
        ELSE
            UPDATE diagnostic SET status = 'en cours' WHERE id = NEW.id_diagnostic;
        
    END IF;
END
//


-- trigger pour la mise à jour d'un diagnostic
CREATE TRIGGER `update_diagnostic_element_trigger` AFTER UPDATE ON `diagnostic_element`
FOR EACH ROW
BEGIN
    DECLARE diag_status VARCHAR(10);
    DECLARE element_control_count INT;
    
   

     -- Compter le nombre d'éléments dans element_control
    SELECT COUNT(*) INTO element_control_count FROM element_control;
    
    -- Vérifier si le diagnostic est terminé ou en cours
    IF (SELECT COUNT(*) FROM diagnostic_element WHERE id_diagnostic = OLD.id_diagnostic) = element_control_count THEN
        
            UPDATE diagnostic SET status = 'terminé' WHERE id = OLD.id_diagnostic;
        ELSE
            UPDATE diagnostic SET status = 'en cours' WHERE id = OLD.id_diagnostic;
       
    END IF;
END
//
DELIMITER ;