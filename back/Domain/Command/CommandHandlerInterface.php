<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Command;

use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use SymplBundle\Entity\User\User;

interface CommandHandlerInterface
{
    public function support(string $resourceClass): bool;

    public function handle(object $entity, User $user, string $objectIdentifier = null);

    public function getDTOFactory(): ?DTOFactoryInterface;

    public function hasResourceIdentifier(): bool;

    public function hasReturnedObject(): bool;
}
