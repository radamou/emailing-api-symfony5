<?php

declare(strict_types=1);

namespace Emailing\Domain\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Emailing\Domain\Command\CommandHandlerInterface;
use Emailing\Domain\Factory\DTOFactoryInterface;
use Emailing\Entity\EmailTemplate;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class DeleteEmailTemplateHandler implements CommandHandlerInterface
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

    public function handle(object $emailTemplate, User $user, string $id = null)
    {
        if (!$emailTemplate instanceof EmailTemplate) {
            throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, [\sprintf('The data is malformed')]);
        }

        try {
            $this->entityManager->remove($emailTemplate);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [$exception->getMessage()]);
        }
    }
}
