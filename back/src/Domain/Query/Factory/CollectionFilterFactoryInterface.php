<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\Factory;

interface CollectionFilterFactoryInterface
{
    public function create(array $filters = []);
}
