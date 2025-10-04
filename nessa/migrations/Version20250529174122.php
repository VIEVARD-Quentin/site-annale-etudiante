<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529174122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE annale (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, type_id INT NOT NULL, nom VARCHAR(255) NOT NULL, style VARCHAR(255) NOT NULL, chemin_fichier VARCHAR(255) NOT NULL, annee SMALLINT NOT NULL, date_upload DATETIME NOT NULL, INDEX IDX_3214242B60BB6FE6 (auteur_id), INDEX IDX_3214242BC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_404021BF6C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_9014574AB3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_4BDFF36B5200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, matiere_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_8CDE5729F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, universite VARCHAR(255) NOT NULL, formation VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE annale ADD CONSTRAINT FK_3214242B60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE annale ADD CONSTRAINT FK_3214242BC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matiere ADD CONSTRAINT FK_9014574AB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE type ADD CONSTRAINT FK_8CDE5729F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE annale DROP FOREIGN KEY FK_3214242B60BB6FE6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE annale DROP FOREIGN KEY FK_3214242BC54C8C93
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE matiere DROP FOREIGN KEY FK_9014574AB3E9C81
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B5200282E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE type DROP FOREIGN KEY FK_8CDE5729F46CD258
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE annale
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE formation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE matiere
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE niveau
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
