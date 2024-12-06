<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206143940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE velo CHANGE taille_roues taille_roues VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_354971F5C5316157 ON velo (bicycode)');

        // Insérer les données depuis le fichier SQL
        $this->executeSqlFile(__DIR__ . '/data/donneesValeursListes.SQL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_354971F5C5316157 ON velo');
        $this->addSql('ALTER TABLE velo CHANGE taille_roues taille_roues VARCHAR(255) DEFAULT NULL');
    }

    /**
     * Fonction utilitaire pour exécuter un fichier SQL.
     */
    private function executeSqlFile(string $filePath): void
    {
        $sql = file_get_contents($filePath);
        if ($sql === false) {
            throw new \RuntimeException('Le fichier SQL ne peut pas être lu : ' . $filePath);
        }

        // Exécuter le SQL contenu dans le fichier
        $this->addSql($sql);
    }
}
