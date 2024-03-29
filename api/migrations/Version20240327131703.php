<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\TypePayment;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327131703 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $defaultTypePayments = json_decode(file_get_contents(dirname(__DIR__, 1) . '/default_data/type_payment.json'), true);

        foreach ($defaultTypePayments as $defaultTypePayment) {
            $typePayment = new TypePayment();
            $typePayment->setName($defaultTypePayment['name']);

            $entityManager->persist($typePayment);
        }


        $entityManager->flush();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
