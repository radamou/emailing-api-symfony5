<?php

declare(strict_types=1);

namespace Emailing\Domain\Factory;

use Emailing\Domain\DTO\CustomerCompanyDTO;
use Emailing\Domain\DTO\EmailEventDTO;
use Emailing\Domain\DTO\EmailEventTemplateDTO;
use Emailing\Domain\DTO\EmailTemplateDTO;
use Emailing\Entity\EmailEventTemplate;
use Webmozart\Assert\Assert;

class EmailEventTemplateDTOFactory implements DTOFactoryInterface
{
    public function create(object $emailEventTemplate)
    {
        Assert::isInstanceOf($emailEventTemplate, EmailEventTemplate::class);

        /** @var EmailEventTemplate $emailEventTemplate */
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

        if ($emailEventTemplate->getCustomerCompany()) {
            $associatedCustomCompany = new CustomerCompanyDTO();
            $associatedCustomCompany->id = $emailEventTemplate->getCustomerCompany()->getId();
            $associatedCustomCompany->name = $emailEventTemplate->getCustomerCompany()->getName();
            $emailEventTemplateDTO->customerCompany = $associatedCustomCompany;
        }

        return $emailEventTemplateDTO;
    }
}
