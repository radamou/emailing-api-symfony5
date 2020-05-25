<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\DataProvider;

interface CollectionDataProviderInterface
{
    public function getCollection(string $resourceClass, array $filters = []);
}
