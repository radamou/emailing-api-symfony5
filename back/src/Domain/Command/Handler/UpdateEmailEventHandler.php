<?php

declare(strict_types=1);

namespace Emailing\Domain\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Emailing\Domain\Command\CommandHandlerInterface;
use Emailing\Domain\DTO\EmailEventDTO;
use Emailing\Domain\Factory\DTOFactoryInterface;
use Emailing\Domain\Factory\EmailEventFactory;
use Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use Emailing\Entity\EmailEvent;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class UpdateEmailEventHandler implements CommandHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var EmailEventFactory */
    private $emailEventFactory;
    /** @var ItemDataProviderInterface */
    private $itemDataProvider;
    /** @var DTOFactoryInterface */
    private $emailEventDTOFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        EmailEventFactory $emailEventFactory,
        ItemDataProviderInterface $itemDataProvider,
        DTOFactoryInterface $emailEventDTOFactory
    ) {
        $this->entityManager = $entityManager;
        $this->emailEventFactory = $emailEventFactory;
        $this->itemDataProvider = $itemDataProvider;
        $this->emailEventDTOFactory = $emailEventDTOFactory;
    }

    public function support(string $resourceClass): bool
    {
        return  self::class === $resourceClass;
    }

    public function getDTOFactory(): DTOFactoryInterface
    {
        return $this->emailEventDTOFactory;
    }

    public function hasResourceIdentifier(): bool
    {
        return true;
    }

    public function hasReturnedObject(): bool
    {
        return true;
    }

    public function handle(object $emailEventDTO, User $user, string $id = null)
    {
        if (!$emailEventDTO instanceof EmailEventDTO) {
            throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, ['Invalid Email Event body parameter']);
        }

        try {
            /** @var EmailEvent $emailEvent */
            $emailEvent = $this->itemDataProvider->getItem(EmailEvent::class, $id);

            if (!$emailEvent instanceof EmailEvent) {
                throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [\sprintf('Unable to find Email Event with the corresponding Id %s', $id)]);
            }

            $emailEvent = $this->emailEventFactory->update($emailEvent, $emailEventDTO);

            $this->entityManager->persist($emailEvent);
            $this->entityManager->flush();

            return $emailEvent;
        } catch (\Exception $exception) {
            throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [$exception->getMessage()]);
        }
    }
}
