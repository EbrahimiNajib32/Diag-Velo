<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417121326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proprietaire (id INT AUTO_INCREMENT NOT NULL, nom_proprio VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE element_control ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE velo ADD proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE velo ADD CONSTRAINT FK_354971F576C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('CREATE INDEX IDX_354971F576C50E4A ON velo (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE velo DROP FOREIGN KEY FK_354971F576C50E4A');
        $this->addSql('DROP TABLE proprietaire');
        $this->addSql('ALTER TABLE element_control MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON element_control');
        $this->addSql('ALTER TABLE element_control DROP id');
        $this->addSql('ALTER TABLE element_control ADD PRIMARY KEY (id_element)');
        $this->addSql('DROP INDEX IDX_354971F576C50E4A ON velo');
        $this->addSql('ALTER TABLE velo DROP proprietaire_id');
    }
}
