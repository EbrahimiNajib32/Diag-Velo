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
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diagnostic_element (id INT AUTO_INCREMENT NOT NULL, id_diagnostic INT NOT NULL, id_element INT NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, id_etat INT NOT NULL, INDEX IDX_BCE100665FF6085E (id_diagnostic), INDEX IDX_BCE100669FDDF749 (id_element), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diagnostic_element ADD CONSTRAINT FK_BCE100665FF6085E FOREIGN KEY (id_diagnostic) REFERENCES diagnostic (id)');
        $this->addSql('ALTER TABLE diagnostic_element ADD CONSTRAINT FK_BCE100669FDDF749 FOREIGN KEY (id_element) REFERENCES element_control (id)');
        $this->addSql('ALTER TABLE velo ADD proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE velo ADD CONSTRAINT FK_354971F576C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('CREATE INDEX IDX_354971F576C50E4A ON velo (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnostic_element DROP FOREIGN KEY FK_BCE100665FF6085E');
        $this->addSql('ALTER TABLE diagnostic_element DROP FOREIGN KEY FK_BCE100669FDDF749');
        $this->addSql('DROP TABLE diagnostic_element');
        $this->addSql('ALTER TABLE velo DROP FOREIGN KEY FK_354971F576C50E4A');
        $this->addSql('DROP INDEX IDX_354971F576C50E4A ON velo');
        $this->addSql('ALTER TABLE velo DROP proprietaire_id');
    }
}
