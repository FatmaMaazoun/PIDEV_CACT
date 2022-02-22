<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20220220131232.php
final class Version20220220131232 extends AbstractMigration
========
final class Version20220220141435 extends AbstractMigration

>>>>>>>> b37083fe262125c823e52cf5d0272f94018987d3:migrations/Version20220220141435.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, demande_event_id INT NOT NULL, utilisateur_id INT NOT NULL, commentaire VARCHAR(255) NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_8F91ABF037AEA149 (demande_event_id), INDEX IDX_8F91ABF0FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billet (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, cout_event_id INT NOT NULL, nombre_billet INT NOT NULL, INDEX IDX_1F034AF6B83297E7 (reservation_id), INDEX IDX_1F034AF62F62617D (cout_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cout (id INT AUTO_INCREMENT NOT NULL, destination_id INT NOT NULL, coutcategorie_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_4E7C337A816C6140 (destination_id), INDEX IDX_4E7C337A39251E26 (coutcategorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cout_categorie (id INT AUTO_INCREMENT NOT NULL, destination_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_1DFD1494816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cout_evenement (id INT AUTO_INCREMENT NOT NULL, coutcategorie_id INT NOT NULL, demande_event_id INT NOT NULL, nb_billet INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_5FA6AABE39251E26 (coutcategorie_id), INDEX IDX_5FA6AABE37AEA149 (demande_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delegation (id INT AUTO_INCREMENT NOT NULL, gouvernorat_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_292F436D75B74E2D (gouvernorat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_evenement (id INT AUTO_INCREMENT NOT NULL, destination_id INT NOT NULL, date_demande DATE NOT NULL, statut VARCHAR(255) NOT NULL, description_demande VARCHAR(255) NOT NULL, date_debut_event DATE NOT NULL, date_fin_event DATE NOT NULL, heure_debut_event TIME NOT NULL, heure_fin_event TIME NOT NULL, description_event VARCHAR(255) NOT NULL, capacite INT NOT NULL, INDEX IDX_7E0A92CB816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, souscategorie_id INT NOT NULL, utilisateur_id INT NOT NULL, delegation_id INT NOT NULL, date_demande_des DATE NOT NULL, statut VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, num_tel INT NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_3EC63EAAA27126E0 (souscategorie_id), INDEX IDX_3EC63EAAFB88E14F (utilisateur_id), INDEX IDX_3EC63EAA56CBBCF5 (delegation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gouvernorat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, image VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, INDEX IDX_6A2CA10CF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, avis_id INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27197E709F (avis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_rec DATE NOT NULL, INDEX IDX_CE606404B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, demande_event_id INT NOT NULL, utilisateur_id INT NOT NULL, date_res DATE NOT NULL, heure_res TIME NOT NULL, statut VARCHAR(255) NOT NULL, cout DOUBLE PRECISION NOT NULL, INDEX IDX_42C8495537AEA149 (demande_event_id), INDEX IDX_42C84955FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_52743D7BBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, email VARCHAR(255) NOT NULL, num_tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF037AEA149 FOREIGN KEY (demande_event_id) REFERENCES demande_evenement (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF6B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF62F62617D FOREIGN KEY (cout_event_id) REFERENCES cout_evenement (id)');
        $this->addSql('ALTER TABLE cout ADD CONSTRAINT FK_4E7C337A816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id)');
        $this->addSql('ALTER TABLE cout ADD CONSTRAINT FK_4E7C337A39251E26 FOREIGN KEY (coutcategorie_id) REFERENCES cout_categorie (id)');
        $this->addSql('ALTER TABLE cout_categorie ADD CONSTRAINT FK_1DFD1494816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id)');
        $this->addSql('ALTER TABLE cout_evenement ADD CONSTRAINT FK_5FA6AABE39251E26 FOREIGN KEY (coutcategorie_id) REFERENCES cout_categorie (id)');
        $this->addSql('ALTER TABLE cout_evenement ADD CONSTRAINT FK_5FA6AABE37AEA149 FOREIGN KEY (demande_event_id) REFERENCES demande_evenement (id)');
        $this->addSql('ALTER TABLE delegation ADD CONSTRAINT FK_292F436D75B74E2D FOREIGN KEY (gouvernorat_id) REFERENCES gouvernorat (id)');
        $this->addSql('ALTER TABLE demande_evenement ADD CONSTRAINT FK_7E0A92CB816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id)');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAAA27126E0 FOREIGN KEY (souscategorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAA56CBBCF5 FOREIGN KEY (delegation_id) REFERENCES delegation (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27197E709F FOREIGN KEY (avis_id) REFERENCES avis (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495537AEA149 FOREIGN KEY (demande_event_id) REFERENCES demande_evenement (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27197E709F');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BBCF5E72D');
        $this->addSql('ALTER TABLE cout DROP FOREIGN KEY FK_4E7C337A39251E26');
        $this->addSql('ALTER TABLE cout_evenement DROP FOREIGN KEY FK_5FA6AABE39251E26');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF62F62617D');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAA56CBBCF5');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF037AEA149');
        $this->addSql('ALTER TABLE cout_evenement DROP FOREIGN KEY FK_5FA6AABE37AEA149');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495537AEA149');
        $this->addSql('ALTER TABLE cout DROP FOREIGN KEY FK_4E7C337A816C6140');
        $this->addSql('ALTER TABLE cout_categorie DROP FOREIGN KEY FK_1DFD1494816C6140');
        $this->addSql('ALTER TABLE demande_evenement DROP FOREIGN KEY FK_7E0A92CB816C6140');
        $this->addSql('ALTER TABLE delegation DROP FOREIGN KEY FK_292F436D75B74E2D');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CF347EFB');
        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF6B83297E7');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404B83297E7');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAAA27126E0');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0FB88E14F');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAAFB88E14F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955FB88E14F');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE cout');
        $this->addSql('DROP TABLE cout_categorie');
        $this->addSql('DROP TABLE cout_evenement');
        $this->addSql('DROP TABLE delegation');
        $this->addSql('DROP TABLE demande_evenement');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE gouvernorat');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE sous_categorie');
        $this->addSql('DROP TABLE utilisateur');
    }
}
