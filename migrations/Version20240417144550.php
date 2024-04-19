<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417144550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE velo (
        id INT AUTO_INCREMENT NOT NULL, 
        numero_de_serie VARCHAR(255) NOT NULL, 
        marque VARCHAR(255) NOT NULL, 
        ref_recyclerie INT DEFAULT NULL, 
        couleur VARCHAR(255) DEFAULT NULL, 
        poids INT DEFAULT NULL, 
        taille_roues NUMERIC(10, 0) NOT NULL, 
        taille_cadre NUMERIC(10, 0) NOT NULL, 
        etat VARCHAR(255) NOT NULL, 
        url_photo VARCHAR(255) NOT NULL, 
        date_de_reception DATETIME NOT NULL, 
        date_de_vente DATETIME NOT NULL, 
        type VARCHAR(255) NOT NULL, 
        annee INT NOT NULL, 
        emplacement VARCHAR(255) NOT NULL, 
        commentaire LONGTEXT NOT NULL, 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE utilisateur (
        id INT AUTO_INCREMENT NOT NULL, 
        nom VARCHAR(255) NOT NULL, 
        role INT NOT NULL, 
        informations_de_contact VARCHAR(255) DEFAULT NULL, 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE proprietaire (
        id INT AUTO_INCREMENT NOT NULL, 
        nom_proprio VARCHAR(255) NOT NULL, 
        telephone INT NOT NULL, 
        email VARCHAR(500) DEFAULT NULL, 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE diagnostic (
        id INT AUTO_INCREMENT NOT NULL, 
        id_velo INT NOT NULL, 
        id_user INT NOT NULL, 
        date_diagnostic DATETIME NOT NULL, 
        cout_reparation INT DEFAULT NULL, 
        conclusion VARCHAR(255) DEFAULT NULL, 
        INDEX IDX_FA7C8889BE696DF7 (id_velo), 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE element_control (
        id INT AUTO_INCREMENT NOT NULL, 
        element VARCHAR(255) NOT NULL, 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE diagnostic_element (
        id INT AUTO_INCREMENT NOT NULL, 
        id_diagnostic INT NOT NULL, 
        id_element INT NOT NULL, 
        commentaire VARCHAR(255) DEFAULT NULL, 
        id_etat INT NOT NULL, 
        INDEX IDX_BCE100665FF6085E (id_diagnostic), 
        INDEX IDX_BCE100669FDDF749 (id_element), 
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE velo ADD proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889BE696DF8 FOREIGN KEY (id_user) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889BE696DF7 FOREIGN KEY (id_velo) REFERENCES velo (id)');
        $this->addSql('ALTER TABLE diagnostic_element ADD CONSTRAINT FK_BCE100665FF6085E FOREIGN KEY (id_diagnostic) REFERENCES diagnostic (id)');
        $this->addSql('ALTER TABLE diagnostic_element ADD CONSTRAINT FK_BCE100669FDDF749 FOREIGN KEY (id_element) REFERENCES element_control (id)'); 
        $this->addSql('ALTER TABLE velo ADD CONSTRAINT FK_354971F576C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('CREATE INDEX IDX_354971F576C50E4A ON velo (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE diagnostic_element DROP FOREIGN KEY FK_BCE100665FF6085E');
        $this->addSql('ALTER TABLE diagnostic_element DROP FOREIGN KEY FK_BCE100669FDDF749');
        $this->addSql('ALTER TABLE velo DROP FOREIGN KEY FK_354971F576C50E4A');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889BE696DF7');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_FA7C8889BE696DF8');

        $this->addSql('DROP INDEX IDX_354971F576C50E4A ON velo');
        $this->addSql('DROP INDEX IDX_BCE100665FF6085E ON diagnostic_element');
        $this->addSql('DROP INDEX IDX_BCE100669FDDF749 ON diagnostic_element');
        $this->addSql('DROP INDEX IDX_FA7C8889BE696DF7 ON diagnostic');

        $this->addSql('ALTER TABLE velo DROP proprietaire_id');

        $this->addSql('DROP TABLE diagnostic_element');
        $this->addSql('DROP TABLE element_control');
        $this->addSql('DROP TABLE diagnostic');
        $this->addSql('DROP TABLE proprietaire');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE velo');
    }

}
