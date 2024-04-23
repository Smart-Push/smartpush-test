<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Transaction;
use App\Entity\TypePayment;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423153007 extends AbstractMigration implements ContainerAwareInterface
{
    private $entityManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
    }

    public function getDescription(): string
    {
        return 'Insert default data into transaction';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $transactions = json_decode(file_get_contents(dirname(__DIR__) . '/default_data/transactions.json'), true);
        $typePaymentRepository = $this->entityManager->getRepository(TypePayment::class);
        foreach ($transactions as $t) {
            $transaction = new Transaction();
            $transaction->setLabel($t['label']);
            $transaction->setAmount((float)$t['amount']);
            $typePayment = $typePaymentRepository->findOneBy(['id' => $t['type_payment_id']]);
            $transaction->setTypePayment($typePayment);
            $this->entityManager->persist($transaction);
        }
        $this->entityManager->flush();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
