<?php

namespace App\Api\Filter;

use App\Entity\Transaction;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\PropertyInfo\Type;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Metadata\Exception\InvalidArgumentException;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class TransactionSearchFilter extends AbstractFilter
{
    private $parameterName;

    /**
     * TransactionSearchFilter constructor.
     *
     * @param ManagerRegistry $managerRegistry The registry to use to get the manager for the entities on which the filter should be applied
     * @param LoggerInterface|null $logger The logger to use to log the messages
     * @param array|null $properties The properties on which the filter should be applied. If null, the filter will be applied on all properties
     * @param NameConverterInterface|null $nameConverter The name converter used to normalize the property name
     * @param string $parameterName The name of the parameter in the request from which the filter will get the search terms
     */
    public function __construct(ManagerRegistry $managerRegistry, LoggerInterface $logger = null, 
        array $properties = null, NameConverterInterface $nameConverter = null, string $parameterName = 'q'
    ) {
        parent::__construct($managerRegistry, $logger, $properties, $nameConverter);
        $this->parameterName = $parameterName;
    }

    /**
     * Apply the filter to the query builder.
     *
     * @param string $property The name of the property on which the filter should be applied
     * @param mixed $value The value of the filter
     * @param QueryBuilder $queryBuilder The query builder on which the filter should be applied
     * @param QueryNameGeneratorInterface $queryNameGenerator The query name generator
     * @param string $resourceClass The class name of the resource on which the filter should be applied
     * @param Operation $operation The operation on which the filter should be applied
     * @param array $context The context in which the filter should be applied
     *
     * @throws InvalidArgumentException If the property is not a string or the value is not a string, array or null
     */
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        if (!is_a($resourceClass, Transaction::class, true) || 
            null === $value ||
            $property !== $this->parameterName
        ) {
            return;
        }

        // Get the root alias of the QueryBuilder
        $transactionAlias = $queryBuilder->getRootAliases()[0];

        // Build the parameter name used in the query
        $parameter = ':' . $this->parameterName;

        // Get the properties on which the filter should be applied
        $properties = array_keys($this->properties);

        // Build the expression used to filter the properties
        $expr = $queryBuilder->expr()->orX();
        foreach ($properties as $prop) {
            $propData = explode('.', $prop);
            if (count($propData) == 1) {
                $expr->add($queryBuilder->expr()->like("{$transactionAlias}.{$prop}", $parameter));
            } else {
                $table = $propData[0];
                $field = $propData[1];
                $queryBuilder->leftJoin("{$transactionAlias}.{$table}", $table);
                $expr->add($queryBuilder->expr()->like("{$table}.{$field}", $parameter));
            }
        }

        // Apply the filter to the query
        $queryBuilder->andWhere($expr);
        $queryBuilder->setParameter($parameter, "%" . $value . "%");
    }

    /**
     * Get the description of the filter.
     *
     * The description will be used in the OpenApi spec of the API.
     * It describes the filter, which properties it will filter and on which
     * resources it will be applied.
     *
     * @param string $resourceClass The class name of the resource on which the filter should be applied
     *
     * @return array The description of the filter
     */
    public function getDescription(string $resourceClass): array
    {
        if (!is_a($resourceClass, Transaction::class, true)) {
            return [];
        }

        if (!$this->properties) {
            return [];
        }

        $description = [];

        $description[$this->parameterName] = [
            'property' => implode(', ', array_keys($this->properties)),
            'type' => Type::BUILTIN_TYPE_STRING,
            'required' => false,
            'description' => 'Filters Transaction resources by searching on label, amount or payment type name.',
            'openapi' => [
                'allowEmptyValue' => false,
                'explode' => false,
            ],
        ];

        return $description;
    }
}
