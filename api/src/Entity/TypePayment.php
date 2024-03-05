<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Lucas LOMBARDO <lucas.lombardo.dev@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(name: 'type_payment')]
class TypePayment
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 80)]
    private string $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }
}
