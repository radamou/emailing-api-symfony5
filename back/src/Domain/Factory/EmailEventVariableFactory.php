<?php

namespace Emailing\Domain\Factory;

use Emailing\Domain\DTO\EmailEventVariableDTO;
use Emailing\Entity\EmailEventVariable;

class EmailEventVariableFactory
{
    public function update(EmailEventVariable $emailEventVariable, object $emailEventVariableDTO): EmailEventVariable
    {
        if (!$emailEventVariableDTO instanceof EmailEventVariableDTO) {
            throw new \InvalidArgumentException('Invalid data');
        }

        $emailEventVariable->setName($emailEventVariableDTO->name);
        $emailEventVariable->setDescription($emailEventVariableDTO->description);

        return  $emailEventVariable;
    }
}
