<?php


namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function delete(Transaction $entity): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entity);
        $entityManager->flush();
    }

    public function save(Transaction $entity): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }
}