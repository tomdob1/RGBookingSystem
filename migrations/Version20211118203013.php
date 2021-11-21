<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118203013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book_tbl AS SELECT id, employee_id, office_id, seat_no, booking_time, booking_date FROM book_tbl');
        $this->addSql('DROP TABLE book_tbl');
        $this->addSql('CREATE TABLE book_tbl (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, office_id INTEGER NOT NULL, seat_no INTEGER NOT NULL, booking_time VARCHAR(255) NOT NULL, booking_date VARCHAR(100) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO book_tbl (id, employee_id, office_id, seat_no, booking_time, booking_date) SELECT id, employee_id, office_id, seat_no, booking_time, booking_date FROM __temp__book_tbl');
        $this->addSql('DROP TABLE __temp__book_tbl');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book_tbl AS SELECT id, employee_id, office_id, seat_no, booking_time, booking_date FROM book_tbl');
        $this->addSql('DROP TABLE book_tbl');
        $this->addSql('CREATE TABLE book_tbl (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, office_id INTEGER NOT NULL, seat_no INTEGER NOT NULL, booking_time TIME NOT NULL, booking_date VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO book_tbl (id, employee_id, office_id, seat_no, booking_time, booking_date) SELECT id, employee_id, office_id, seat_no, booking_time, booking_date FROM __temp__book_tbl');
        $this->addSql('DROP TABLE __temp__book_tbl');
    }
}
