<?php

namespace App\Application\Command;

class CreateTransactionCommand
{
    function __construct(
        public string $label,
        public string $amount,
        public int $typePaymentId
    ) {
    }
}