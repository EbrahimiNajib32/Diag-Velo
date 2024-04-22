-- modification table diagnostic

ALTER TABLE diagnostic ADD COLUMN statut ENUM('terminé', 'en cours') DEFAULT 'en cours';



