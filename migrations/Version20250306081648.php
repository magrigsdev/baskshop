<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306081648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, first_name, last_name, email, password, address, city, postal_code, country, roles FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, address, city, postal_code, country, role) SELECT id, first_name, last_name, email, password, address, city, postal_code, country, roles FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, first_name, last_name, email, password, address, city, postal_code, country, role FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, roles VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, address, city, postal_code, country, roles) SELECT id, first_name, last_name, email, password, address, city, postal_code, country, role FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }
}
