<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Command;

use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class CrudResourceChain implements CommandInterface
{
    /** @var CommandHandlerInterface */
    private $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    public function addHandler(CommandHandlerInterface $handler): void
    {
        $this->handlers[] = $handler;
    }

    public function execute(
        object $entity,
        User $user,
        string $resourceClass,
        string $objectIdentifier = null
    ) {
        /** @var CommandHandlerInterface $handler */
        foreach ($this->handlers as $handler) {
            if (!$handler->support($resourceClass)) {
                continue;
            }

            if ($handler->hasResourceIdentifier() && !$objectIdentifier) {
                throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, [\sprintf('The Object corresponding to this id %s cannot be found', $objectIdentifier)]);
            }

            $entity = $handler->handle($entity, $user, $objectIdentifier);

            if ($handler->hasReturnedObject()) {
                return $handler->getDTOFactory()->create($entity);
            }
        }
    }
}
