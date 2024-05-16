<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516132052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proprietaire CHANGE statut statut VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE velo CHANGE numero_de_serie numero_de_serie VARCHAR(255) NOT NULL, CHANGE taille_roues taille_roues NUMERIC(10, 0) NOT NULL, CHANGE taille_cadre taille_cadre NUMERIC(10, 0) NOT NULL, CHANGE url_photo url_photo VARCHAR(255) NOT NULL, CHANGE date_de_vente date_de_vente DATETIME NOT NULL, CHANGE emplacement emplacement VARCHAR(255) NOT NULL, CHANGE commentaire commentaire LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE velo CHANGE numero_de_serie numero_de_serie VARCHAR(255) DEFAULT NULL, CHANGE taille_roues taille_roues NUMERIC(10, 0) DEFAULT NULL, CHANGE taille_cadre taille_cadre NUMERIC(10, 0) DEFAULT NULL, CHANGE url_photo url_photo VARCHAR(255) DEFAULT NULL, CHANGE date_de_vente date_de_vente DATETIME DEFAULT NULL, CHANGE emplacement emplacement VARCHAR(255) DEFAULT NULL, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE proprietaire CHANGE statut statut VARCHAR(255) DEFAULT NULL');
    }
}
