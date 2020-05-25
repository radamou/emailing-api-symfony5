<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use SymplBundle\Emailing\Domain\Command\CommandHandlerInterface;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use SymplBundle\Emailing\Domain\Factory\EmailTemplateFactory;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class UpdateEmailTemplateHandler implements CommandHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var EmailTemplateFactory */
    private $emailTemplateFactory;
    /** @var ItemDataProviderInterface */
    private $itemDataProvider;
    /** @var DTOFactoryInterface */
    private $emailTemplateDTOFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        EmailTemplateFactory $emailTemplateFactory,
        ItemDataProviderInterface $itemDataProvider,
        DTOFactoryInterface $emailTemplateDTOFactory
    ) {
        $this->entityManager = $entityManager;
        $this->emailTemplateFactory = $emailTemplateFactory;
        $this->itemDataProvider = $itemDataProvider;
        $this->emailTemplateDTOFactory = $emailTemplateDTOFactory;
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
        return true;
    }

    public function hasReturnedObject(): bool
    {
        return true;
    }

    public function handle(object $emailTemplateDTO, User $user, string $id = null)
    {
        if (!$emailTemplateDTO instanceof EmailTemplateDTO) {
            throw InputException::create(InputException::EMAILING_ARGUMENT_ERROR, ['Invalid Email template body parameter']);
        }

        try {
            /** @var EmailTemplate $emailTemplate */
            $emailTemplate = $this->itemDataProvider->getItem(EmailTemplate::class, $id);

            if (!$emailTemplate instanceof EmailTemplate) {
                throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [\sprintf('Unable to find Email template with the corresponding Id %s', $id)]);
            }

            $emailTemplate->setTitle($emailTemplateDTO->title);
            $emailTemplate->setBody($emailTemplateDTO->body);
            $emailTemplate->setLanguage($emailTemplateDTO->language);

            $this->entityManager->persist($emailTemplate);
            $this->entityManager->flush();

            return $emailTemplate;
        } catch (\Exception $exception) {
            throw InputException::create(InputException::EMAILING_DOCTRINE_ERROR, [$exception->getMessage()]);
        }
    }
}
