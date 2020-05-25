<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Query\Handler;

use SymplBundle\Emailing\Domain\Query\Builder\ItemQueryBuilder;
use SymplBundle\Emailing\Domain\Query\Factory\ItemQueryFactoryInterface;
use SymplBundle\Emailing\Domain\Query\Factory\TransformerByRepositoryClassFactory;
use SymplBundle\Exception\InputException;
use Webmozart\Assert\Assert;

class ItemHandler implements ItemHandlerInterface
{
    /** @var ItemQueryFactoryInterface */
    private $itemFactory;
    /** @var TransformerByRepositoryClassFactory */
    private $transformerByRepositoryClassFactory;

    public function __construct(
        ItemQueryFactoryInterface $itemFactory,
        TransformerByRepositoryClassFactory $transformerByRepositoryClassFactory
    ) {
        $this->itemFactory = $itemFactory;
        $this->transformerByRepositoryClassFactory = $transformerByRepositoryClassFactory;
    }

    public function getItemFactory(): ItemQueryFactoryInterface
    {
        return $this->itemFactory;
    }

    public function support(string $resourceClass): bool
    {
        return true;
    }

    public function handle(object $itemQuery, string $resourceClass, bool $hydrate = false)
    {
        Assert::isInstanceOf($itemQuery, ItemQueryBuilder::class);

        $repository = $this->transformerByRepositoryClassFactory->getRepository($resourceClass);
        $entity = $repository->find($itemQuery->getId());

        if (!$entity) {
            throw InputException::create(InputException::EMAIL_NOT_FOUND, [\sprintf('Unable to find Email template type with id %s', $itemQuery->getId())]);
        }

        if ($hydrate) {
            $entity = $this->transformerByRepositoryClassFactory->getTransformer($resourceClass)->getItem($entity);
        }

        return  $entity;
    }
}
