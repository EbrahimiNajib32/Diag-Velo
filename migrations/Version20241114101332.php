<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114101332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diagnostictype_lieutype (id INT AUTO_INCREMENT NOT NULL, diagnostic_type_id_id INT NOT NULL, lieu_type_id_id INT NOT NULL, actif TINYINT(1) NOT NULL, INDEX IDX_4744D7B193419374 (diagnostic_type_id_id), INDEX IDX_4744D7B124225814 (lieu_type_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, type_lieu_id_id INT NOT NULL, nom_lieu VARCHAR(255) NOT NULL, adresse_lieu VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(8) NOT NULL, INDEX IDX_2F577D59A777EF69 (type_lieu_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_lieu (id INT AUTO_INCREMENT NOT NULL, nom_type_lieu VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diagnostictype_lieutype ADD CONSTRAINT FK_4744D7B193419374 FOREIGN KEY (diagnostic_type_id_id) REFERENCES diagnostic_type (id)');
        $this->addSql('ALTER TABLE diagnostictype_lieutype ADD CONSTRAINT FK_4744D7B124225814 FOREIGN KEY (lieu_type_id_id) REFERENCES type_lieu (id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59A777EF69 FOREIGN KEY (type_lieu_id_id) REFERENCES type_lieu (id)');
        $this->addSql('ALTER TABLE diagnostic ADD lieu_id_id INT NOT NULL, ADD diagnostictype_lieu_type_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889BA74394C FOREIGN KEY (lieu_id_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C8889EA6E93ED FOREIGN KEY (diagnostictype_lieu_type_id_id) REFERENCES diagnostictype_lieutype (id)');
        $this->addSql('CREATE INDEX IDX_FA7C8889BA74394C ON diagnostic (lieu_id_id)');
        $this->addSql('CREATE INDEX IDX_FA7C8889EA6E93ED ON diagnostic (diagnostictype_lieu_type_id_id)');
        $this->addSql('ALTER TABLE proprietaire CHANGE statut statut VARCHAR(500) DEFAULT NULL');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889EA6E93ED');
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C8889BA74394C');
        $this->addSql('ALTER TABLE diagnostictype_lieutype DROP FOREIGN KEY FK_4744D7B193419374');
        $this->addSql('ALTER TABLE diagnostictype_lieutype DROP FOREIGN KEY FK_4744D7B124225814');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59A777EF69');
        $this->addSql('DROP TABLE diagnostictype_lieutype');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE type_lieu');
        $this->addSql('ALTER TABLE proprietaire CHANGE statut statut VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_FA7C8889BA74394C ON diagnostic');
        $this->addSql('DROP INDEX IDX_FA7C8889EA6E93ED ON diagnostic');
        $this->addSql('ALTER TABLE diagnostic DROP lieu_id_id, DROP diagnostictype_lieu_type_id_id');
    }
}
