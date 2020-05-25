<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Command;

use SymplBundle\Entity\User\User;

interface CommandInterface
{
    public function execute(object $entity, User $user, string $resourceClass, string $objectIdentifier = null);
}
