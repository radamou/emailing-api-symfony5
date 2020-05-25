<?php

declare(strict_types=1);

namespace Emailing\Domain\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Emailing\Domain\Command\CommandHandlerInterface;
use Emailing\Domain\DTO\EmailTemplateDTO;
use Emailing\Domain\Factory\DTOFactoryInterface;
use Emailing\Domain\Factory\EmailEventTemplateFactory;
use Emailing\Domain\Factory\EmailTemplateFactory;
use Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use Emailing\Entity\EmailEvent;
use Emailing\Entity\EmailTemplate;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class CreateEmailTemplateHandler implements CommandHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var EmailTemplateFactory */
    private $emailTemplateFactory;
    /** @var EmailEventTemplateFactory */
    private $emailEventTemplateFactory;
    /** @var DTOFactoryInterface */
    private $emailTemplateDTOFactory;
    /** @var ItemDataProviderInterface */
    private $itemDataProvider;

    public function __construct(
        EntityManagerInterface $entityManager,
        EmailTemplateFactory $emailTemplateFactory,
        EmailEventTemplateFactory $emailEventTemplateFactory,
        DTOFactoryInterface $emailTemplateDTOFactory,
        ItemDataProviderInterface $itemDataProvider
    ) {
        $this->entityManager = $entityManager;
        $this->emailTemplateFactory = $emailTemplateFactory;
        $this->emailTemplateDTOFactory = $emailTemplateDTOFactory;
        $this->emailEventTemplateFactory = $emailEventTemplateFactory;
        $this->itemDataProvider = $itemDataProvider;
    }

    public function support(string $resourceClass): bool
    {
        return  self::class === $resourceClass;
    }

    public function getDTOFactory(): DTOFactoryInterface
    {
        return $this->emailTemplateDTOFactory;
    }

    public function hasResourceIdentifier(): bool
    {
        return false;
    }

    public function hasReturnedObject(): bool
    {
        return true;
    }

    public function handle(object $emailTemplateDTO, User $user, string $id = null)
    {
        if (!$emailTemplateDTO instanceof EmailTemplateDTO) {
            throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, [\sprintf('Invalid Email template body parameter')]);
        }

        try {
            /** @var EmailTemplate $emailTemplate */
            $emailTemplate = $this->emailTemplateFactory->create($emailTemplateDTO);
            $emailEvent = $this->itemDataProvider->getItem(
                EmailEvent::class,
                $emailTemplateDTO->emailEvent->id
            );

            $this->entityManager->persist($emailTemplate);
            $emailEventTemplate = $this->emailEventTemplateFactory->create(
                $user,
                $emailEvent,
                $emailTemplate,
                $emailTemplateDTO->emailEvent->isActive
            );
            $this->entityManager->persist($emailEventTemplate);
            $this->entityManager->flush();

            return $emailTemplate;
        } catch (\Exception $exception) {
            throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [$exception->getMessage()]);
        }
    }
}
