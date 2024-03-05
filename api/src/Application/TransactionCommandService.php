<?php

namespace App\Application;

use App\Application\Command\CreateTransactionCommand;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Repository\TypePaymentRepository;

class TransactionCommandService
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly TypePaymentRepository $typePaymentRepository
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function createTransaction(CreateTransactionCommand $command): void
    {
        $typePayment = $this->typePaymentRepository->find($command->typePaymentId);
        if (null === $typePayment) {
            throw new \Exception('Type payment not found');
        }

        $transaction = new Transaction(
            $command->label,
            $command->amount,
            $typePayment,
            1
        );

        $this->transactionRepository->save($transaction);
    }
}