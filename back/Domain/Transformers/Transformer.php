<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Transformers;

use Doctrine\Common\Collections\ArrayCollection;
use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use Webmozart\Assert\Assert;

class Transformer implements TransformerInterface
{
    /** @var DTOFactoryInterface */
    private $DTOFactory;
    private $resourceClass;

    public function __construct(DTOFactoryInterface $DTOFactory, string $resourceClass)
    {
        $this->DTOFactory = $DTOFactory;
        $this->resourceClass = $resourceClass;
    }

    public function getItem(object $entity): object
    {
        Assert::isInstanceOf($entity, $this->resourceClass);

        return $this->DTOFactory->create($entity);
    }

    public function getCollection(array $collection): ArrayCollection
    {
        $response = new ArrayCollection();

        foreach ($collection as $entity) {
            $response[] = $this->DTOFactory->create($entity);
        }

        return $response;
    }
}
