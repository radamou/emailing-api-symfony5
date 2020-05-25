<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use SymplBundle\Emailing\Domain\DTO\EmailEventDTO;
use SymplBundle\Emailing\Domain\DTO\EmailEventTemplateDTO;
use SymplBundle\Emailing\Domain\DTO\EmailEventVariableDTO;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailEventTemplate;
use SymplBundle\Emailing\Entity\EmailEventVariable;
use Webmozart\Assert\Assert;

class EmailEventDTOFactory implements DTOFactoryInterface
{
    public function create(object $emailEvent)
    {
        Assert::isInstanceOf($emailEvent, EmailEvent::class);

        /** @var EmailEvent $emailEvent */
        $emailEventDTO = new EmailEventDTO();
        $emailEventDTO->id = $emailEvent->getId();
        $emailEventDTO->code = $emailEvent->getCode();
        $emailEventDTO->description = $emailEvent->getDescription();
        $emailEventDTO->updatedAt = $emailEvent->getUpdatedAt();
        $emailEventDTO->createdAt = $emailEvent->getCreatedAt();

        $emailEventVariablesDTO = new ArrayCollection();

        /** @var EmailEventVariable $emailEventVariable */
        foreach ($emailEvent->getEmailEventVariables() as $emailEventVariable) {
            $emailEventVariableDTO = new EmailEventVariableDTO();
            $emailEventVariableDTO->id = $emailEventVariable->getId()->toString();
            $emailEventVariableDTO->name = $emailEventVariable->getName();
            $emailEventVariableDTO->description = $emailEventVariable->getDescription();

            $emailEventVariablesDTO->add($emailEventVariableDTO);
        }
        $emailEventDTO->emailEventVariables = $emailEventVariablesDTO;

        $emailEventTemplatesDTO = new ArrayCollection();

        /** @var EmailEventTemplate $emailEventTemplate */
        foreach ($emailEvent->getEmailEventTemplates() as $emailEventTemplate) {
            $emailEventTemplateDTO = new EmailEventTemplateDTO();
            $emailEventTemplateDTO->id = $emailEventTemplate->getId()->toString();
            $emailEventTemplateDTO->isActive = $emailEventTemplate->isActive();

            $associatedEventDTO = new EmailEventDTO();
            $associatedEventDTO->id = $emailEventTemplate->getEmailEvent()->getId()->toString();
            $associatedEventDTO->code = $emailEventTemplate->getEmailEvent()->getCode();
            $associatedEventDTO->description = $emailEventTemplate->getEmailEvent()->getDescription();
            $emailEventTemplateDTO->emailEventDTO = $associatedEventDTO;

            $associatedEmailTemplateDTO = new EmailTemplateDTO();
            $associatedEmailTemplateDTO->id = $emailEventTemplate->getEmailTemplate()->getId()->toString();
            $associatedEmailTemplateDTO->title = $emailEventTemplate->getEmailTemplate()->getTitle();
            $associatedEmailTemplateDTO->body = $emailEventTemplate->getEmailTemplate()->getBody();
            $emailEventTemplateDTO->emailTemplate = $associatedEmailTemplateDTO;

            $emailEventTemplatesDTO->add($emailEventTemplateDTO);
        }

        $emailEventDTO->emailEventTemplates = $emailEventTemplatesDTO;

        return $emailEventDTO;
    }
}
