<?php

namespace App\Controller;

use App\Application\TransactionCommandService;
use App\DTO\DetailedTransactionDTO;
use App\DTO\PaymentTypeDTO;
use App\DTO\TransactionDTO;
use App\Entity\Transaction;
use App\Entity\TypePayment;
use App\Repository\TransactionRepository;
use App\Repository\TypePaymentRepository;
use App\Request\TransactionRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionsController extends AbstractController
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly TypePaymentRepository $typePaymentRepository,
        private readonly SerializerInterface $serializer,
        private readonly TransactionCommandService $transactionCommandService
    ) {
    }

    #[Route('/payment-types', name: 'app_payment_types')]
    public function getAllPaymentTypes(): JsonResponse
    {
        $paymentTypes = $this->typePaymentRepository->findAll();

        $paymentTypeDTOs = [];
        foreach ($paymentTypes as $paymentType) {
            /** @var TypePayment $paymentType */
            $paymentTypeDTOs[] = new PaymentTypeDTO(
                $paymentType->getId(),
                $paymentType->getName()
            );
        }

        return $this->json($this->serializer->serialize($paymentTypeDTOs, 'json'), Response::HTTP_OK);
    }

    #[Route('/transactions', name: 'app_transactions')]
    public function getAllTransactions(): JsonResponse
    {
        $transactions = $this->transactionRepository->findAll();

        $transactionDTOs = [];
        foreach ($transactions as $transaction) {
            /** @var Transaction $transaction */
            $transactionDTOs[] = new TransactionDTO(
                $transaction->getId(),
                $transaction->getLabel()
            );
        }

        // We can also create normalizer for the payment type so we can send the entity to the normalizer and get the result
        return $this->json($this->serializer->serialize($transactionDTOs, 'json'), Response::HTTP_OK);
    }

    #[Route('/transactions/{id}', name: 'app_transaction')]
    public function getTransaction(int $id): JsonResponse
    {
        $transaction = $this->transactionRepository->find($id);

        if (null === $transaction) {
            return $this->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        $dto = new DetailedTransactionDTO(
            $transaction->getId(),
            $transaction->getLabel(),
            $transaction->getAmount(),
            $transaction->getTypePayment()->getId()
        );

        // We can also create normalizer for the payment type so we can send the entity to the normalizer and get the result
        return $this->json($this->serializer->serialize($dto, 'json'), Response::HTTP_OK);
    }

    #[Route('/transactions', name: 'app_create_transaction', methods: ['POST'])]
    public function createTransaction(Request $request): JsonResponse
    {
        $simplifiedRequest = $this->serializer->deserialize(
            $request->getContent(),
            TransactionRequest::class,
            'json'
        );

        try {
            $this->transactionCommandService->createTransaction($simplifiedRequest);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Transaction created'], Response::HTTP_OK);
    }

    #[Route('/transactions/{id}', name: 'app_delete_transaction', methods: ['DELETE'])]
    public function deleteTransaction(int $id): JsonResponse
    {
        $transaction = $this->transactionRepository->find($id);

        if (null === $transaction) {
            return $this->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        $this->transactionRepository->delete($transaction);

        return $this->json(['message' => 'Transaction deleted'], Response::HTTP_OK);
    }
}
