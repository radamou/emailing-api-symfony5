<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Factory;

interface DTOFactoryInterface
{
    public function create(object $entity);
}
