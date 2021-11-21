<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115203043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE office_tbl (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, office_seats INTEGER NOT NULL)');
        $this->addSql('DROP TABLE office_table');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE office_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, office_seats INTEGER NOT NULL)');
        $this->addSql('DROP TABLE office_tbl');
    }
}
