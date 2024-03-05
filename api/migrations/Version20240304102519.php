<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304102519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $typePayments = json_decode(file_get_contents(__DIR__ . '/../default_data/type_payment.json'), true);

        foreach ($typePayments as $typePayment) {
            $name = $typePayment['name'];

            $this->addSql("
                INSERT INTO type_payment (name)
                VALUES ($name)
            ");
        }

        $transactions = json_decode(file_get_contents(__DIR__ . '/../default_data/transaction.json'), true);

        foreach ($transactions as $transaction) {
            $label = $transaction['label'];
            $amount = $transaction['amount'];
            $typePaymentId = $transaction['type_payment_id'];

            $this->addSql("
                INSERT INTO transaction (label, amount, type_payment_id, category_id) 
                VALUES ($label, $amount, $typePaymentId, 1)
            ");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
