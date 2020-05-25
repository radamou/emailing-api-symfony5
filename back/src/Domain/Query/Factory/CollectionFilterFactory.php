<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\Factory;

use Emailing\Domain\Query\Builder\CollectionQueryFilterBuilder;

class CollectionFilterFactory implements CollectionFilterFactoryInterface
{
    public function create(array $filters = [])
    {
        return new CollectionQueryFilterBuilder($filters);
    }
}
