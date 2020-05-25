<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Query\Factory;

interface ItemQueryFactoryInterface
{
    public function create(string $id);
}
