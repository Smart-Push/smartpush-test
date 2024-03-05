<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304101039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE type_payment (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(80) NOT NULL,
                PRIMARY KEY(id)
            )
        ');

        $this->addSql('
            CREATE TABLE transaction (
                id INT AUTO_INCREMENT NOT NULL,
                label VARCHAR(255) NOT NULL,
                amount FLOAT NOT NULL,
                type_payment_id INT DEFAULT NULL,
                category_id INT DEFAULT NULL,
                PRIMARY KEY(id),
                CONSTRAINT FK_type_payment FOREIGN KEY (type_payment_id) REFERENCES type_payment(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE type_payment');
    }
}
