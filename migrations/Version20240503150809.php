<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503150809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diagnostic_type (id INT AUTO_INCREMENT NOT NULL, nom_type VARCHAR(255) NOT NULL, date_creation_type DATE NOT NULL, actif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diagnostic_type_elementcontrol (id INT AUTO_INCREMENT NOT NULL, id_dianostic_type_id INT NOT NULL, id_elementcontrol_id INT NOT NULL, INDEX IDX_8E389DB5C81A73D2 (id_dianostic_type_id), INDEX IDX_8E389DB5261E202F (id_elementcontrol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diagnostic_type_elementcontrol ADD CONSTRAINT FK_8E389DB5C81A73D2 FOREIGN KEY (id_dianostic_type_id) REFERENCES diagnostic_type (id)');
        $this->addSql('ALTER TABLE diagnostic_type_elementcontrol ADD CONSTRAINT FK_8E389DB5261E202F FOREIGN KEY (id_elementcontrol_id) REFERENCES element_control (id)');
        $this->addSql('ALTER TABLE diagnostic ADD diagnostic_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C888938EDD2CC FOREIGN KEY (diagnostic_type_id) REFERENCES diagnostic_type (id)');
        $this->addSql('CREATE INDEX IDX_FA7C888938EDD2CC ON diagnostic (diagnostic_type_id)');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C888938EDD2CC');
        $this->addSql('ALTER TABLE diagnostic_type_elementcontrol DROP FOREIGN KEY FK_8E389DB5C81A73D2');
        $this->addSql('ALTER TABLE diagnostic_type_elementcontrol DROP FOREIGN KEY FK_8E389DB5261E202F');
        $this->addSql('DROP TABLE diagnostic_type');
        $this->addSql('DROP TABLE diagnostic_type_elementcontrol');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE velo CHANGE numero_de_serie numero_de_serie VARCHAR(255) DEFAULT NULL, CHANGE taille_roues taille_roues NUMERIC(10, 0) DEFAULT NULL, CHANGE taille_cadre taille_cadre NUMERIC(10, 0) DEFAULT NULL, CHANGE url_photo url_photo VARCHAR(255) DEFAULT NULL, CHANGE date_de_vente date_de_vente DATETIME DEFAULT NULL, CHANGE emplacement emplacement VARCHAR(255) DEFAULT NULL, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_FA7C888938EDD2CC ON diagnostic');
        
    }
}
