<?php

declare(strict_types=1);

namespace Emailing\Domain\Factory;

interface DTOFactoryInterface
{
    public function create(object $entity);
}
