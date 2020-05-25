<?php

declare(strict_types=1);

namespace Emailing\Domain\Factory;

use Emailing\Entity\EmailEvent;
use Emailing\Entity\EmailEventTemplate;
use Emailing\Entity\EmailTemplate;
use SymplBundle\Entity\User\Professional;
use SymplBundle\Entity\User\User;

class EmailEventTemplateFactory
{
    public function create(
        User $user,
        EmailEvent $emailEvent,
        EmailTemplate $emailTemplate,
        bool $isActive
    ): EmailEventTemplate {
        $customerCompany = $user instanceof Professional ? $user->getCompany() : null;

        return (new EmailEventTemplate())
            ->setCustomerCompany($customerCompany)
            ->setEmailEvent($emailEvent)
            ->setEmailTemplate($emailTemplate)
            ->setIsActive($isActive);
    }
}
