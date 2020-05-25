<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Factory;

use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailEventTemplate;
use SymplBundle\Emailing\Entity\EmailTemplate;
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
