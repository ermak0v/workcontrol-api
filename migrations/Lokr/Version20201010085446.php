<?php

declare(strict_types=1);

namespace LokrMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201010085446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE criterion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, small_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, head_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CD1DE18AF41A619E (head_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, target_id INT NOT NULL, criterion_id INT NOT NULL, description LONGTEXT NOT NULL, proof LONGTEXT NOT NULL, f_positive TINYINT(1) NOT NULL, f_delete TINYINT(1) NOT NULL, f_moder TINYINT(1) DEFAULT NULL, f_epic TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_3D03A11AF675F31B (author_id), INDEX IDX_3D03A11A158E0B66 (target_id), INDEX IDX_3D03A11A97766307 (criterion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, incident_id INT NOT NULL, creator_id INT NOT NULL, target_id INT NOT NULL, criterion_id INT NOT NULL, action VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, proof LONGTEXT NOT NULL, f_positive TINYINT(1) NOT NULL, f_epic TINYINT(1) NOT NULL, f_moder TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_8F3F68C559E53FB9 (incident_id), INDEX IDX_8F3F68C561220EA6 (creator_id), INDEX IDX_8F3F68C5158E0B66 (target_id), INDEX IDX_8F3F68C597766307 (criterion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18AF41A619E FOREIGN KEY (head_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A158E0B66 FOREIGN KEY (target_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A97766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C559E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C561220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5158E0B66 FOREIGN KEY (target_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C597766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A97766307');
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C597766307');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AE80F5DF');
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C559E53FB9');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18AF41A619E');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AF675F31B');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A158E0B66');
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C561220EA6');
        $this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5158E0B66');
        $this->addSql('DROP TABLE criterion');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE user');
    }
}
