<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use SymplBundle\Emailing\Domain\Command\CommandHandlerInterface;
use SymplBundle\Emailing\Domain\DTO\EmailEventDTO;
use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use SymplBundle\Emailing\Domain\Factory\EmailEventFactory;
use SymplBundle\Emailing\Domain\Factory\EmailEventTemplateFactory;
use SymplBundle\Emailing\Domain\Factory\EmailTemplateFactory;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class CreateEmailEventHandler implements CommandHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var EmailEventFactory */
    private $emailEventFactory;
    /** @var EmailEventTemplateFactory */
    private $emailEventTemplateFactory;
    /** @var EmailTemplateFactory */
    private $emailTemplateFactory;
    /** @var DTOFactoryInterface */
    private $emailEventDTOFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        EmailEventFactory $emailEventFactory,
        EmailTemplateFactory $emailTemplateFactory,
        EmailEventTemplateFactory $emailEventTemplateFactory,
        DTOFactoryInterface $emailEventDTOFactory
    ) {
        $this->entityManager = $entityManager;
        $this->emailEventFactory = $emailEventFactory;
        $this->emailTemplateFactory = $emailTemplateFactory;
        $this->emailEventTemplateFactory = $emailEventTemplateFactory;
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
        return false;
    }

    public function hasReturnedObject(): bool
    {
        return true;
    }

    public function handle(object $emailEventDTO, User $user, string $objectIdentifier = null)
    {
        if (!$emailEventDTO instanceof EmailEventDTO) {
            throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, [\sprintf('The argument you passed has the wrong type')]);
        }
        try {
            /** @var EmailEvent $emailEvent */
            $emailEvent = $this->emailEventFactory->create($emailEventDTO);
            $emailTemplate = $this->emailTemplateFactory->create($emailEventDTO->emailTemplate);

            $emailTemplateEvent = $this->emailEventTemplateFactory->create(
                $user,
                $emailEvent,
                $emailTemplate,
                $emailEventDTO->isActive
            );

            if (!$emailEventDTO->emailTemplate->id) {
                $this->entityManager->persist($emailTemplate);
            }

            $this->entityManager->persist($emailEvent);
            $this->entityManager->persist($emailTemplateEvent);
            $this->entityManager->flush();

            return $emailEvent;
        } catch (\Exception $exception) {
            throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [$exception->getFile(), $exception->getMessage()]);
        }
    }
}
