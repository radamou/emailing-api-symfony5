<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application\Event;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\Command\CommandInterface;
use SymplBundle\Emailing\Domain\Command\Handler\CreateEmailEventHandler;
use SymplBundle\Emailing\Domain\DTO\EmailEventDTO;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class CreateEmailEventController extends AbstractController
{
    /**
     * @Route("/email-events", name="sympl_api_email_event_create", methods={"POST"})
     *
     * @ParamConverter("emailEventDTO", converter="fos_rest.request_body")
     */
    public function __invoke(EmailEventDTO $emailEventDTO, ?ConstraintViolationListInterface $validationErrors)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::CREATE_ROLE);

        /** @var User $user */
        $user = $this->getUser();

        if ($validationErrors && \count($validationErrors) > 0) {
            throw InputException::create(InputException::INVALID_EMAILING_BODY_PARAM, (array) $validationErrors);
        }

        /** @var EmailEventDTO $emailEvent */
        $emailEvent = $this->getCommand()->execute(
            $emailEventDTO,
            $user,
            CreateEmailEventHandler::class
        );

        return $this->getApiSuccessResponse(['emailEvent' => $emailEvent]);
    }

    private function getCommand(): CommandInterface
    {
        /* @var CommandInterface */
        return  $this->get('sympl.domain.cqrs.crud_resource_chain');
    }
}
