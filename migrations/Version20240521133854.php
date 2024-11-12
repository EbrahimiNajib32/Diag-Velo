<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521133854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE velo ADD model VARCHAR(255) DEFAULT NULL');

        // Insérer les données depuis le fichier SQL
        $this->executeSqlFile(__DIR__ . '/data/donneesValeursListes.SQL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE velo DROP model');
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
