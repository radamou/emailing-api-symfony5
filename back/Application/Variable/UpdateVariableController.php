<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application\Variable;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\Command\CommandInterface;
use SymplBundle\Emailing\Domain\Command\Handler\UpdateEventVariableHandler;
use SymplBundle\Emailing\Domain\DTO\EmailEventVariableDTO;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class UpdateVariableController extends AbstractController
{
    /**
     * @Route("/email-variables/{id}", name="sympl_api_email_event_variable", methods={"PUT"})
     *
     * @ParamConverter("emailVariableDTO", converter="fos_rest.request_body")
     */
    public function __invoke(
        string $id,
        EmailEventVariableDTO $emailVariableDTO,
        ?ConstraintViolationListInterface $validationErrors)
    {
        #$this->denyAccessUnlessGranted(CustomerCompanyAccessControl::EDIT_ROLE, $id);
        /** @var User $user */
        $user = $this->getUser();

        if ($validationErrors && \count($validationErrors) > 0) {
            throw InputException::create(InputException::EMAIL_NOT_FOUND, (array) $validationErrors);
        }

        $emailVariable = $this->getCommand()->execute(
            $emailVariableDTO,
            $user,
            UpdateEventVariableHandler::class,
            $id
        );

        return $this->getApiSuccessResponse(['emailVariable' => $emailVariable]);
    }

    private function getCommand(): CommandInterface
    {
        /* @var CommandInterface */
        return  $this->get('sympl.domain.cqrs.crud_resource_chain');
    }
}
