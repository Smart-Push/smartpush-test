<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TransactionRepository;
use App\Api\Filter\TransactionSearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['transaction:collection:read']],
        ),
        new Get(),
        new Post(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['transaction:collection:read', 'transaction:item:read']],
    denormalizationContext: ['groups' => ['transaction:write']],
)]
#[ApiFilter(TransactionSearchFilter::class, 
    properties: ['label', 'amount', 'typePayment.name'],
)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['transaction:collection:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['transaction:collection:read', 'transaction:write'])]
    private ?string $label = null;

    #[ORM\Column]
    #[Groups(['transaction:item:read', 'transaction:write'])]
    private ?float $amount = null;

    #[ORM\ManyToOne]
    #[Groups(['transaction:item:read', 'transaction:write'])]
    private ?TypePayment $typePayment = null;

    #[ORM\Column(nullable: true)]
    private ?int $categoryId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    #[Groups(['transaction:item:read'])]
    #[SerializedName('typePayment')]
    public function getTypePaymentId(): ?int
    {
        return $this->typePayment ? $this->typePayment->getId() : null;
    }

    public function getTypePayment(): ?TypePayment
    {
        return $this->typePayment;
    }

    public function setTypePayment(?TypePayment $typePayment): static
    {
        $this->typePayment = $typePayment;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): static
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}
