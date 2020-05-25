<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Query\Factory;

use SymplBundle\Emailing\Domain\Query\Builder\ItemQueryBuilder;

class ItemQueryFactory implements ItemQueryFactoryInterface
{
    public function create(string $id): ItemQueryBuilder
    {
        return (new ItemQueryBuilder())->setId($id);
    }
}
