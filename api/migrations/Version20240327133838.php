<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Transaction;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327133838 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $defaultTransactions = json_decode(file_get_contents(dirname(__DIR__, 1) . '/default_data/transactions.json'), true);

        foreach ($defaultTransactions as $defaultTransaction) {
            $transaction = new Transaction();
            $transaction->setLabel($defaultTransaction['label']);
            $transaction->setAmount(floatval($defaultTransaction['amount']));
            $transaction->setCategoryId(rand(1, 3));
            $transaction->setTypePayment($entityManager->getReference('App\Entity\TypePayment', $defaultTransaction['type_payment_id']));

            $entityManager->persist($transaction);
        }

        $entityManager->flush();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
