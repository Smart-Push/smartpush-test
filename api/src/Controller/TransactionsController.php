<?php

namespace App\Controller;

use App\DTO\DetailedTransactionDTO;
use App\DTO\TrunkedTransactionDTO;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Repository\TypePaymentRepository;
use App\Request\TransactionCreationRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionsController extends AbstractController
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly TypePaymentRepository $typePaymentRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * List transactions.
     */
    #[Route('/api/transactions', name: 'api_transactions', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns the list of Transaction',
        content: new OA\JsonContent(ref: new Model(type: TrunkedTransactionDTO::class))
    )]
    #[Security(name: null)]
    public function getAllTransactions(): JsonResponse
    {
        $transactions = $this->transactionRepository->findAll();

        $transactionDTOs = [];
        foreach ($transactions as $transaction) {
            $transactionDTOs[] = new TrunkedTransactionDTO(
                $transaction->getId(),
                $transaction->getLabel()
            );
        }

        return $this->json($transactionDTOs, Response::HTTP_OK);
    }

    /**
     * Get detailed transaction.
     */
    #[Route('/api/transactions/{id}', name: 'api_detailed_transaction', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Return detailed transaction',
        content: new OA\JsonContent(ref: new Model(type: DetailedTransactionDTO::class))
    )]
    #[Security(name: null)]
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

        return $this->json($dto, Response::HTTP_OK);
    }

    /**
     * Create a transaction.
     */
    #[Route('/api/transactions', name: 'api_create_transaction', methods: ['POST'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Transaction created',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string'),
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Transaction creation failed',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string'),
            ]
        )
    )]
    #[Security(name: null)]
    public function createTransaction(#[MapRequestPayload] TransactionCreationRequest $transactionRequest): JsonResponse
    {
        try {
            $typePayment = $this->typePaymentRepository->find($transactionRequest->typePayment);
            if (null === $typePayment) {
                throw new \Exception('Type payment not found');
            }

            $transaction = new Transaction();

            $transaction->setLabel($transactionRequest->label);
            $transaction->setAmount($transactionRequest->amount);
            $transaction->setCategoryId(rand(1, 3));
            $transaction->setTypePayment($typePayment);

            $this->transactionRepository->save($transaction);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Transaction created'], Response::HTTP_OK);
    }

    /**
     * Delete a transaction.
     */
    #[Route('/api/transactions/{id}', name: 'api_delete_transaction', methods: ['DELETE'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Deleted transaction',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string'),
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Transaction not found',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string'),
            ]
        )
    )]
    #[Security(name: null)]
    public function deleteTransaction(int $id): JsonResponse
    {
        $transaction = $this->transactionRepository->find($id);

        if (null === $transaction) {
            return $this->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        $this->transactionRepository->remove($transaction);

        return $this->json(['message' => 'Transaction deleted'], Response::HTTP_OK);
    }
}
