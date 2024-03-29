<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionCreationRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255
    )]
    public string $label;

    #[Assert\NotBlank]
    public float $amount;

    #[Assert\NotBlank]
    public int $typePayment;
}
