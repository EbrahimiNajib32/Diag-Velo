<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203123813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proprietaire ADD date_de_naissance DATE DEFAULT NULL, ADD prenom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE velo CHANGE date_de_enregistrement date_de_enregistrement DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE velo CHANGE date_de_enregistrement date_de_enregistrement DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE proprietaire DROP date_de_naissance, DROP prenom');
    }
}
