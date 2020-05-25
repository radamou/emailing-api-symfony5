<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Security;

use SymplBundle\Emailing\Infrastructure\Security\AccessControl;
use SymplBundle\Entity\User\Admin;
use SymplBundle\Entity\User\Professional;
use SymplBundle\Entity\User\User;

class CustomerCompanyAccessControl extends AccessControl
{
    /**
     * {@inheritdoc}
     */
    public function supports($attribute, $subject): bool
    {
        if (!\in_array($attribute, self::ALL, true)) {
            return false;
        }

        return true;
    }

    public function canView(User $user): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        if ($user instanceof Professional) {
            return true;
        }

        return false;
    }

    public function canEdit(User $user, $subject): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        if ($user instanceof Professional) {
            return  true;
            // add company id check here

            /* @var string $subject */
            //return $user->getCompany()->getId() === $subject;
        }

        return false;
    }

    public function canDelete(User $user, $subject): bool
    {
        return false;
    }
}
