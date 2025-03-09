<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250308223520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'build basket table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE baskets (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, size VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE baskets');
    }
}
