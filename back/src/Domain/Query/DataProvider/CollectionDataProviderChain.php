<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\DataProvider;

use Emailing\Domain\Query\Factory\CollectionFilterFactoryInterface;
use Emailing\Domain\Query\Handler\CollectionHandlerInterface;

class CollectionDataProviderChain implements CollectionDataProviderInterface
{
    /** @var CollectionHandlerInterface[] */
    private $collectionHandlers;

    public function __construct()
    {
        $this->collectionHandlers = [];
    }

    public function addHandler(CollectionHandlerInterface $handler): void
    {
        $this->collectionHandlers[] = $handler;
    }

    public function getCollection(string $resourceClass, array $filters = [])
    {
        /** @var CollectionHandlerInterface $handler */
        foreach ($this->collectionHandlers as $handler) {
            if (!$handler->support($resourceClass)) {
                continue;
            }

            /** @var CollectionFilterFactoryInterface $collectionQueryFactory */
            $collectionQueryFactory = $handler->getCollectionFilterFactory();

            return $handler->handle($collectionQueryFactory->create($filters), $resourceClass);
        }

        throw new \InvalidArgumentException('ResourceNotFound');
    }
}
