<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221184429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAAFB88E14F');
        $this->addSql('DROP INDEX IDX_3EC63EAAFB88E14F ON destination');
        $this->addSql('ALTER TABLE destination ADD nom VARCHAR(255) NOT NULL, DROP utilisateur_id, DROP date_demande_des, DROP statut, DROP libelle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE destination ADD utilisateur_id INT NOT NULL, ADD date_demande_des DATE NOT NULL, ADD libelle VARCHAR(255) NOT NULL, CHANGE nom statut VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_3EC63EAAFB88E14F ON destination (utilisateur_id)');
    }
}
