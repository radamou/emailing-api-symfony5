<?php

namespace SymplBundle\Emailing\Domain\Factory;

use SymplBundle\Emailing\Domain\DTO\EmailEventVariableDTO;
use SymplBundle\Emailing\Entity\EmailEventVariable;
use Webmozart\Assert\Assert;

class EmailEventVariableDTOFactory implements DTOFactoryInterface
{
    public function create(object $entity): EmailEventVariableDTO
    {
        Assert::isInstanceOf($entity, EmailEventVariable::class);
        $emailEventVariableDTO = new EmailEventVariableDTO();
        $emailEventVariableDTO->id = $entity->getId()->toString();
        $emailEventVariableDTO->name = $entity->getName();
        $emailEventVariableDTO->description = $entity->getDescription();

        return  $emailEventVariableDTO;
    }
}
