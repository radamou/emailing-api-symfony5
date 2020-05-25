<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Query\DataProvider;

interface ItemDataProviderInterface
{
    public function getItem(string $resourceClass, string $identifier, bool $hydrate = false);
}
