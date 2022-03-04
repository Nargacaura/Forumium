<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304093206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, noteur_id INT NOT NULL, est_utile TINYINT(1) NOT NULL, INDEX IDX_CFBDFA1452798DD4 (noteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_reponse (note_id INT NOT NULL, reponse_id INT NOT NULL, INDEX IDX_DE101A5D26ED0855 (note_id), INDEX IDX_DE101A5DCF18BB82 (reponse_id), PRIMARY KEY(note_id, reponse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, topic_id INT NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_5FB6DEC760BB6FE6 (auteur_id), INDEX IDX_5FB6DEC71F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, creation DATETIME NOT NULL, mise_ajour DATETIME NOT NULL, INDEX IDX_9D40DE1B60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1452798DD4 FOREIGN KEY (noteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE note_reponse ADD CONSTRAINT FK_DE101A5D26ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_reponse ADD CONSTRAINT FK_DE101A5DCF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC760BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note_reponse DROP FOREIGN KEY FK_DE101A5D26ED0855');
        $this->addSql('ALTER TABLE note_reponse DROP FOREIGN KEY FK_DE101A5DCF18BB82');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71F55203D');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1452798DD4');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC760BB6FE6');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B60BB6FE6');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE note_reponse');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE utilisateur');
    }
}
