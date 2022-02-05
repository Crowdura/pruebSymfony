<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220205190419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT=DYNAMIC');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, categorya_id INT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, brand VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, createda_at DATETIME NOT NULL, update_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A7BB061577153098 (code), UNIQUE INDEX UNIQ_A7BB06155E237E06 (name), INDEX IDX_A7BB06155377E7F8 (categorya_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ROW_FORMAT=DYNAMIC');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06155377E7F8 FOREIGN KEY (categorya_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06155377E7F8');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE producto');
    }
}
