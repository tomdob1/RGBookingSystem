<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115173245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_tbl (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, office_id INTEGER NOT NULL, seat_number INTEGER NOT NULL, booking_time DATETIME NOT NULL, booking_length INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE employee_tbl (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, payroll_no INTEGER NOT NULL, email VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE TABLE office_table (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, office_seats INTEGER NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking_tbl');
        $this->addSql('DROP TABLE employee_tbl');
        $this->addSql('DROP TABLE office_table');
    }
}
