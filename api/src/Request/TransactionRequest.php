<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionRequest
{
    #[Assert\NotBlank]
    public string $label;

    #[Assert\NotBlank]
    public string $amount;

    #[Assert\NotBlank]
    public string $typePayment;
}
