<?php

namespace App\DTO;

class DetailedTransactionDTO
{
    private int $id;
    private float $amount;
    private string $label;
    private int $typePaymentId;

    public function __construct(
        int $id,
        string $label,
        float $amount,
        int $typePaymentId,
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->amount = $amount;
        $this->typePaymentId = $typePaymentId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getTypePaymentId(): int
    {
        return $this->typePaymentId;
    }
}
