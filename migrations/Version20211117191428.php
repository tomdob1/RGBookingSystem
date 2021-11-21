<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117191428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book_tbl AS SELECT id, employee_id, office_id, seat_no, booking_time FROM book_tbl');
        $this->addSql('DROP TABLE book_tbl');
        $this->addSql('CREATE TABLE book_tbl (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, office_id INTEGER NOT NULL, seat_no INTEGER NOT NULL, booking_time TIME NOT NULL, booking_date VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO book_tbl (id, employee_id, office_id, seat_no, booking_time) SELECT id, employee_id, office_id, seat_no, booking_time FROM __temp__book_tbl');
        $this->addSql('DROP TABLE __temp__book_tbl');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book_tbl AS SELECT id, employee_id, office_id, seat_no, booking_time FROM book_tbl');
        $this->addSql('DROP TABLE book_tbl');
        $this->addSql('CREATE TABLE book_tbl (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, office_id INTEGER NOT NULL, seat_no INTEGER NOT NULL, booking_time DATETIME NOT NULL)');
        $this->addSql('INSERT INTO book_tbl (id, employee_id, office_id, seat_no, booking_time) SELECT id, employee_id, office_id, seat_no, booking_time FROM __temp__book_tbl');
        $this->addSql('DROP TABLE __temp__book_tbl');
    }
}
