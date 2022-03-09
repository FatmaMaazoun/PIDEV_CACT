<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305194305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE couleur_evenement ADD libelle_couleur VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE demande_evenement DROP FOREIGN KEY FK_7E0A92CB4B39A83E');
        $this->addSql('DROP INDEX IDX_7E0A92CB4B39A83E ON demande_evenement');
        $this->addSql('ALTER TABLE demande_evenement DROP couleur_evenement_id');
        $this->addSql('ALTER TABLE sous_categorie ADD couleur_evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7B4B39A83E FOREIGN KEY (couleur_evenement_id) REFERENCES couleur_evenement (id)');
        $this->addSql('CREATE INDEX IDX_52743D7B4B39A83E ON sous_categorie (couleur_evenement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE couleur_evenement DROP libelle_couleur');
        $this->addSql('ALTER TABLE demande_evenement ADD couleur_evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_evenement ADD CONSTRAINT FK_7E0A92CB4B39A83E FOREIGN KEY (couleur_evenement_id) REFERENCES couleur_evenement (id)');
        $this->addSql('CREATE INDEX IDX_7E0A92CB4B39A83E ON demande_evenement (couleur_evenement_id)');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7B4B39A83E');
        $this->addSql('DROP INDEX IDX_52743D7B4B39A83E ON sous_categorie');
        $this->addSql('ALTER TABLE sous_categorie DROP couleur_evenement_id');
    }
}
