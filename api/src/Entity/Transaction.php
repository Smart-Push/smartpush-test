<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Lucas LOMBARDO <lucas.lombardo.dev@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(name: 'transaction')]
class Transaction
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $label;

    #[ORM\Column(type: 'float')]
    private float $amount;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\TypePayment', inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'type_payment_id', referencedColumnName: 'id', nullable: true)]
    private ?TypePayment $typePayment;

    #[ORM\Column(type: 'integer')]
    private int $categoryId;

    public function __construct(
        string $label,
        float $amount,
        TypePayment $typePayment,
        int $categoryId
    ) {
        $this->label = $label;
        $this->amount = $amount;
        $this->typePayment = $typePayment;
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return TypePayment
     */
    public function getTypePayment(): TypePayment
    {
        return $this->typePayment;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
