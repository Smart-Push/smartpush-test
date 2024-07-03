<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\TypePayment;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423152832 extends AbstractMigration implements ContainerAwareInterface
{
    private $entityManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
    }

    public function getDescription(): string
    {
        return 'Insert default data into type_payment';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $typePayments = json_decode(file_get_contents(dirname(__DIR__) . '/default_data/type_payment.json'), true);
        foreach ($typePayments as $tp) {
            $typePayment = new TypePayment();
            $typePayment->setName($tp['name']);
            $this->entityManager->persist($typePayment);
        }
        $this->entityManager->flush();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
