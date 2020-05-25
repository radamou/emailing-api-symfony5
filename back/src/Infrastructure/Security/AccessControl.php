<?php

namespace Emailing\Infrastructure\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use SymplBundle\Entity\User\User;

abstract class AccessControl extends Voter
{
    public const CREATE_ROLE = 'create';
    public const EDIT_ROLE = 'edit';
    public const VIEW_ROLE = 'view';
    public const DELETE_ROLE = 'delete';

    protected const ALL = [
        self::CREATE_ROLE,
        self::VIEW_ROLE,
        self::EDIT_ROLE,
        self::DELETE_ROLE,
    ];

    /**
     * {@inheritdoc}
     */
    abstract protected function supports($attribute, $subject): bool;

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW_ROLE:
            case self::CREATE_ROLE:
                return $this->canView($user);
            case self::EDIT_ROLE:
            case self::DELETE_ROLE:
                return $this->canEdit($user, $subject);
        }

        throw new \LogicException('This code should not be reached!');
    }

    abstract protected function canView(User $user): bool;

    abstract protected function canEdit(User $user, $subject): bool;

    abstract protected function canDelete(User $user, $subject): bool;
}
