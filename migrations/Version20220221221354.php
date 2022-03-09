<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221221354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cout_categorie DROP FOREIGN KEY FK_1DFD1494816C6140');
        $this->addSql('ALTER TABLE cout_categorie DROP FOREIGN KEY FK_1DFD149439251E26');
        $this->addSql('DROP INDEX IDX_1DFD149439251E26 ON cout_categorie');
        $this->addSql('DROP INDEX IDX_1DFD1494816C6140 ON cout_categorie');
        $this->addSql('ALTER TABLE cout_categorie DROP destination_id, DROP coutcategorie_id, DROP prix');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cout_categorie ADD destination_id INT NOT NULL, ADD coutcategorie_id INT NOT NULL, ADD prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE cout_categorie ADD CONSTRAINT FK_1DFD1494816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id)');
        $this->addSql('ALTER TABLE cout_categorie ADD CONSTRAINT FK_1DFD149439251E26 FOREIGN KEY (coutcategorie_id) REFERENCES cout_categorie (id)');
        $this->addSql('CREATE INDEX IDX_1DFD149439251E26 ON cout_categorie (coutcategorie_id)');
        $this->addSql('CREATE INDEX IDX_1DFD1494816C6140 ON cout_categorie (destination_id)');
    }
}
