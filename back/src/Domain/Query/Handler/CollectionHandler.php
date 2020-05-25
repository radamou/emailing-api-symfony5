<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\Handler;

use Emailing\Domain\Query\Builder\CollectionQueryFilterBuilder;
use Emailing\Domain\Query\Factory\CollectionFilterFactoryInterface;
use Emailing\Domain\Query\Factory\TransformerByRepositoryClassFactory;
use Webmozart\Assert\Assert;

class CollectionHandler implements CollectionHandlerInterface
{
    private const BEGIN = 0;
    private const END = 15;
    private const DEFAULT_ORDER = ['id' => 'DESC'];

    /** @var CollectionFilterFactoryInterface */
    private $collectionFilterFactory;
    /** @var TransformerByRepositoryClassFactory */
    private $transformerByRepositoryClassFactory;

    public function __construct(
        CollectionFilterFactoryInterface $collectionFilterFactory,
        TransformerByRepositoryClassFactory $transformerByRepositoryClassFactory
    ) {
        $this->collectionFilterFactory = $collectionFilterFactory;
        $this->transformerByRepositoryClassFactory = $transformerByRepositoryClassFactory;
    }

    public function getCollectionFilterFactory(): CollectionFilterFactoryInterface
    {
        return $this->collectionFilterFactory;
    }

    public function support(string $resourceClass): bool
    {
        return true;
    }

    public function handle(object $collectionFilterQueryBuilder, string $resource)
    {
        Assert::isInstanceOf($collectionFilterQueryBuilder, CollectionQueryFilterBuilder::class);
        $filters = $collectionFilterQueryBuilder->getFilters();
        $standardFilters = $collectionFilterQueryBuilder->getStandardFilters();
        $repository = $this->transformerByRepositoryClassFactory->getRepository($resource);

        /* @var CollectionQueryFilterBuilder $collectionFilterQueryBuilder */
        $collection = $repository->findBy(
            \count($filters) > 0 ? $filters : [],
            isset($standardFilters['_sort']) ? [$standardFilters['_sort'] => $standardFilters['_order']] : self::DEFAULT_ORDER,
        isset($standardFilters['_end']) ? $standardFilters['_end'] : self::END,
            isset($standardFilters['_start']) ? $standardFilters['_start'] : self::BEGIN
        );

        return $this->transformerByRepositoryClassFactory->getTransformer($resource)->getCollection($collection);
    }
}
