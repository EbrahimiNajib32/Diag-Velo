<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418164740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diagnostic (id INT AUTO_INCREMENT NOT NULL, id_velo INT NOT NULL, id_utilisateur INT DEFAULT NULL, id_diagnostic INT NOT NULL, id_user INT NOT NULL, date_diagnostic DATETIME NOT NULL, coup_reparation INT DEFAULT NULL, conclusion VARCHAR(255) DEFAULT NULL, INDEX IDX_FA7C8889BE696DF7 (id_velo), INDEX IDX_FA7C888950EAE44 (id_utilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element_control (id INT AUTO_INCREMENT NOT NULL, id_element INT NOT NULL, element VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proprietaire (id INT AUTO_INCREMENT NOT NULL, nom_proprio VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, role INT NOT NULL, informations_de_contact VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889BE696DF7 FOREIGN KEY (id_velo) REFERENCES velo (id)');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C888950EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE velo ADD proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE velo ADD CONSTRAINT FK_354971F576C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('CREATE INDEX IDX_354971F576C50E4A ON velo (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE velo DROP FOREIGN KEY FK_354971F576C50E4A');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889BE696DF7');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C888950EAE44');
        $this->addSql('DROP TABLE diagnostic');
        $this->addSql('DROP TABLE element_control');
        $this->addSql('DROP TABLE proprietaire');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX IDX_354971F576C50E4A ON velo');
        $this->addSql('ALTER TABLE velo DROP proprietaire_id');
    }
}
