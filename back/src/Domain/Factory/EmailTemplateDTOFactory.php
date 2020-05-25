<?php

declare(strict_types=1);

namespace Emailing\Domain\Factory;

use Emailing\Domain\DTO\EmailTemplateDTO;
use Emailing\Entity\EmailTemplate;
use Webmozart\Assert\Assert;

class EmailTemplateDTOFactory implements DTOFactoryInterface
{
    public function create(object $emailTemplate)
    {
        Assert::isInstanceOf($emailTemplate, EmailTemplate::class);

        $emailTemplateDTO = new EmailTemplateDTO();
        $emailTemplateDTO->id = $emailTemplate->getId()->toString();
        $emailTemplateDTO->body = $emailTemplate->getBody();
        $emailTemplateDTO->title = $emailTemplate->getTitle();
        $emailTemplateDTO->language = $emailTemplate->getLanguage();
        $emailTemplateDTO->createdDate = $emailTemplate->getCreatedDate();
        $emailTemplateDTO->updateDate = $emailTemplate->getUpdateDate();

        return $emailTemplateDTO;
    }
}
