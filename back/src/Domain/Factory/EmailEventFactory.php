<?php

declare(strict_types=1);

namespace Emailing\Domain\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Emailing\Domain\DTO\EmailEventDTO;
use Emailing\Domain\DTO\EmailEventVariableDTO;
use Emailing\Entity\EmailEvent;
use Emailing\Entity\EmailEventVariable;

class EmailEventFactory
{
    public function create(?object $emailEventDTO): EmailEvent
    {
        $emailEvent = new EmailEvent();

        if (!$emailEventDTO instanceof EmailEventDTO) {
            return $emailEvent;
        }
        $emailEvent
            ->setCode($emailEventDTO->code)
            ->setDescription($emailEventDTO->description);

        if ($emailEventDTO->emailEventVariable) {
            $emailEvent->addEmailEventVariable(
                (new EmailEventVariable())
                    ->setName($emailEventDTO->emailEventVariable->name)
                    ->setDescription($emailEventDTO->emailEventVariable->description)
                    ->setEmailEvent($emailEvent)
            );
        }

        if (\count($emailEventDTO->emailEventVariables) > 0) {
            $emailEventVariableCollection = new ArrayCollection();

            foreach ($emailEventDTO->emailEventVariables as $emailEventVariable) {
                $emailEventVariableCollection->add((new EmailEventVariable())
                    ->setName($emailEventVariable->name)
                    ->setDescription($emailEventVariable->description)
                    ->setEmailEvent($emailEvent));
            }
            $emailEvent->setEmailEventVariables($emailEventVariableCollection);
        }

        return $emailEvent;
    }

    public function update(EmailEvent $emailEvent, EmailEventDTO $emailEventDTO): EmailEvent
    {
        if ($emailEventDTO->code) {
            $emailEvent->setCode($emailEventDTO->code);
        }

        if ($emailEventDTO->description) {
            $emailEvent->setDescription($emailEventDTO->description);
        }

        if (0 === \count($emailEventDTO->emailEventVariables)) {
            return  $emailEvent;
        }

        foreach ($emailEventDTO->emailEventVariables as $emailEventVariable) {
            $emailEvent = $this->addEmailEventVariable($emailEvent, $emailEventVariable);
            $emailEvent = $this->updateExistingEmailEventVariables($emailEvent, $emailEventVariable);
        }

        return $emailEvent;
    }

    private function updateExistingEmailEventVariables(
        EmailEvent $emailEvent,
        EmailEventVariableDTO $emailEventVariableDTO
    ): EmailEvent {
        if (!isset($emailEventVariableDTO->id)) {
            return $emailEvent;
        }

        foreach ($emailEvent->getEmailEventVariables() as $emailEventVariable) {
            if ($emailEventVariableDTO->id === $emailEventVariable->getId()->toString()) {
                if ($emailEventVariableDTO->name) {
                    $emailEventVariable->setName($emailEventVariableDTO->name);
                }

                if ($emailEventVariableDTO->description) {
                    $emailEventVariable->setDescription($emailEventVariableDTO->description);
                }
            }
        }

        return $emailEvent;
    }

    private function addEmailEventVariable(
        EmailEvent $emailEvent,
        EmailEventVariableDTO $emailEventVariableDTO
    ): EmailEvent {
        if (isset($emailEventVariableDTO->id)) {
            return $emailEvent;
        }

        $newEmailEventVariable = (new EmailEventVariable());

        if ($emailEventVariableDTO->name) {
            $newEmailEventVariable->setName($emailEventVariableDTO->name);
        }

        if ($emailEventVariableDTO->description) {
            $newEmailEventVariable->setDescription($emailEventVariableDTO->description);
        }

        $newEmailEventVariable->setEmailEvent($emailEvent);
        $emailEvent->addEmailEventVariable($newEmailEventVariable);

        return $emailEvent;
    }
}
