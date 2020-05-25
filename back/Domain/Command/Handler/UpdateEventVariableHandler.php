<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use SymplBundle\Emailing\Domain\Command\CommandHandlerInterface;
use SymplBundle\Emailing\Domain\DTO\EmailEventVariableDTO;
use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use SymplBundle\Emailing\Domain\Factory\EmailEventVariableFactory;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Entity\EmailEventVariable;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class UpdateEventVariableHandler implements CommandHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var EmailEventVariableFactory */
    private $emailVariableFactory;
    /** @var ItemDataProviderInterface */
    private $itemDataProvider;
    /** @var DTOFactoryInterface */
    private $emailVariableDTOFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        EmailEventVariableFactory $emailEventVariableFactory,
        ItemDataProviderInterface $itemDataProvider,
        DTOFactoryInterface $emailVariableDTOFactory
    ) {
        $this->entityManager = $entityManager;
        $this->emailVariableFactory = $emailEventVariableFactory;
        $this->itemDataProvider = $itemDataProvider;
        $this->emailVariableDTOFactory = $emailVariableDTOFactory;
    }

    public function support(string $resourceClass): bool
    {
        return  self::class === $resourceClass;
    }

    public function getDTOFactory(): DTOFactoryInterface
    {
        return $this->emailVariableDTOFactory;
    }

    public function hasResourceIdentifier(): bool
    {
        return true;
    }

    public function hasReturnedObject(): bool
    {
        return true;
    }

    public function handle(object $emailVariableDTO, User $user, string $id = null)
    {
        if (!$emailVariableDTO instanceof EmailEventVariableDTO) {
            throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, ['Invalid Email Event body parameter']);
        }

        try {
            /** @var EmailEventVariable $emailVariable */
            $emailVariable = $this->itemDataProvider->getItem(EmailEventVariable::class, $id);

            if (!$emailVariable instanceof EmailEventVariable) {
                throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [\sprintf('Unable to find Email Event with the corresponding Id %s', $id)]);
            }

            $emailEvent = $this->emailVariableFactory->update($emailVariable, $emailVariableDTO);

            $this->entityManager->persist($emailEvent);
            $this->entityManager->flush();

            return $emailEvent;
        } catch (\Exception $exception) {
            throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [$exception->getMessage()]);
        }
    }
}
