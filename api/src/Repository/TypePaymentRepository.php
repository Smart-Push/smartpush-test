<?php


namespace App\Repository;

use App\Entity\TypePayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TypePaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePayment::class);
    }

    public function save(TypePayment $entity): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }
}