<?php

namespace App\Controller;

use App\DTO\PaymentTypeDTO;
use App\Repository\TypePaymentRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentTypeController extends AbstractController
{
    public function __construct(
        private readonly TypePaymentRepository $typePaymentRepository
    ) {
    }

    /**
     * List payments type.
     */
    #[Route('/api/payment-types', name: 'api_payment_types', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns the list of PaymentType',
        content: new OA\JsonContent(ref: new Model(type: PaymentTypeDTO::class))
    )]
    #[Security(name: null)]
    public function getAllPaymentTypes(): JsonResponse
    {
        $paymentTypes = $this->typePaymentRepository->findAll();
        $paymentTypeDTOs = [];

        foreach ($paymentTypes as $paymentType) {
            $paymentTypeDTOs[] = new PaymentTypeDTO(
                $paymentType->getId(),
                $paymentType->getName()
            );
        }

        return $this->json($paymentTypeDTOs, Response::HTTP_OK);
    }
}
