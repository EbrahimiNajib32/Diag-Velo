<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424201017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diagnostic (id INT AUTO_INCREMENT NOT NULL, id_velo INT NOT NULL, id_user INT NOT NULL, date_diagnostic DATETIME NOT NULL, cout_reparation INT DEFAULT NULL, conclusion VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_FA7C8889BE696DF7 (id_velo), INDEX IDX_FA7C88896B3CA4B (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diagnostic_element (id INT AUTO_INCREMENT NOT NULL, id_diagnostic INT NOT NULL, id_element INT NOT NULL, id_etat INT NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, INDEX IDX_BCE100665FF6085E (id_diagnostic), INDEX IDX_BCE100669FDDF749 (id_element), INDEX IDX_BCE10066DEEAEB60 (id_etat), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element_control (id INT AUTO_INCREMENT NOT NULL, element VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_control (id INT AUTO_INCREMENT NOT NULL, nom_etat VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proprietaire (id INT AUTO_INCREMENT NOT NULL, nom_proprio VARCHAR(255) NOT NULL, telephone  VARCHAR(255) DEFAULT NULL, email VARCHAR(500) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE velo (bicycode VARCHAR(255) DEFAULT NULL,id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT NOT NULL, numero_de_serie VARCHAR(255) DEFAULT NULL, marque VARCHAR(255) NOT NULL, ref_recyclerie VARCHAR(255) DEFAULT NULL, couleur VARCHAR(255) DEFAULT NULL, poids VARCHAR(255) DEFAULT NULL, taille_roues VARCHAR(255) DEFAULT NULL, taille_cadre NUMERIC(10, 0) DEFAULT NULL, etat VARCHAR(255) NOT NULL, url_photo VARCHAR(255) DEFAULT NULL, date_de_enregistrement DATETIME NOT NULL, date_de_vente DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, emplacement VARCHAR(255) DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, date_destruction DATE DEFAULT NULL, public VARCHAR(255) DEFAULT NULL, origine VARCHAR(255) DEFAULT NULL, INDEX IDX_354971F576C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889BE696DF7 FOREIGN KEY (id_velo) REFERENCES velo (id)');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C88896B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE diagnostic_element ADD CONSTRAINT FK_BCE100665FF6085E FOREIGN KEY (id_diagnostic) REFERENCES diagnostic (id)');
        $this->addSql('ALTER TABLE diagnostic_element ADD CONSTRAINT FK_BCE100669FDDF749 FOREIGN KEY (id_element) REFERENCES element_control (id)');
        $this->addSql('ALTER TABLE diagnostic_element ADD CONSTRAINT FK_BCE10066DEEAEB60 FOREIGN KEY (id_etat) REFERENCES etat_control (id)');
        $this->addSql('ALTER TABLE velo ADD CONSTRAINT FK_354971F576C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql("
CREATE TRIGGER `insert_diagnostic_element_trigger` 
AFTER INSERT ON `diagnostic_element`
FOR EACH ROW 
BEGIN
    DECLARE type_element_control_count INT;
    DECLARE diagnostic_control_count INT;

    SELECT COUNT(*) INTO type_element_control_count
    FROM diagnostic_type_elementcontrol dtec
    WHERE dtec.id_dianostic_type_id = (
        SELECT diagnostic_type_id
        FROM diagnostic
        WHERE id = NEW.id_diagnostic
    );

    SELECT COUNT(*) INTO diagnostic_control_count
    FROM diagnostic_element
    WHERE id_diagnostic = NEW.id_diagnostic;

    IF diagnostic_control_count = type_element_control_count THEN
        UPDATE diagnostic SET status = 'terminé' WHERE id = NEW.id_diagnostic;
    ELSE
        UPDATE diagnostic SET status = 'en cours' WHERE id = NEW.id_diagnostic;
    END IF;
END;

CREATE TRIGGER `update_diagnostic_element_trigger`
AFTER UPDATE ON `diagnostic_element`
FOR EACH ROW
BEGIN
    DECLARE type_element_control_count INT;
    DECLARE diagnostic_control_count INT;
    
    SELECT COUNT(*) INTO type_element_control_count
    FROM diagnostic_type_elementcontrol dtec
    WHERE dtec.id_dianostic_type_id = (
        SELECT diagnostic_type_id
        FROM diagnostic
        WHERE id = OLD.id_diagnostic
    );
    
    SELECT COUNT(*) INTO diagnostic_control_count
    FROM diagnostic_element
    WHERE id_diagnostic = OLD.id_diagnostic;

    IF diagnostic_control_count = type_element_control_count THEN
        UPDATE diagnostic SET status = 'terminé' WHERE id = OLD.id_diagnostic;
    ELSE
        UPDATE diagnostic SET status = 'en cours' WHERE id = OLD.id_diagnostic;
    END IF;
END;

            ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889BE696DF7');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C88896B3CA4B');
        $this->addSql('ALTER TABLE diagnostic_element DROP FOREIGN KEY FK_BCE100665FF6085E');
        $this->addSql('ALTER TABLE diagnostic_element DROP FOREIGN KEY FK_BCE100669FDDF749');
        $this->addSql('ALTER TABLE diagnostic_element DROP FOREIGN KEY FK_BCE10066DEEAEB60');
        $this->addSql('ALTER TABLE velo DROP FOREIGN KEY FK_354971F576C50E4A');
        $this->addSql('DROP TABLE diagnostic');
        $this->addSql('DROP TABLE diagnostic_element');
        $this->addSql('DROP TABLE element_control');
        $this->addSql('DROP TABLE etat_control');
        $this->addSql('DROP TABLE proprietaire');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE velo');
    }
}
