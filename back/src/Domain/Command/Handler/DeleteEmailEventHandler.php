<?php

declare(strict_types=1);

namespace Emailing\Domain\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Emailing\Domain\Command\CommandHandlerInterface;
use Emailing\Domain\Factory\DTOFactoryInterface;
use Emailing\Entity\EmailEvent;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class DeleteEmailEventHandler implements CommandHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function support(string $resourceClass): bool
    {
        return  self::class === $resourceClass;
    }

    public function hasResourceIdentifier(): bool
    {
        return true;
    }

    public function hasReturnedObject(): bool
    {
        return false;
    }

    public function getDTOFactory(): ?DTOFactoryInterface
    {
        return null;
    }

    public function handle(object $emailEvent, User $user, string $id = null)
    {
        if (!$emailEvent instanceof EmailEvent) {
            throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, [\sprintf('The argument you passed has the wrong type')]);
        }

        try {
            $this->entityManager->remove($emailEvent);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [$exception->getMessage()]);
        }
    }
}
