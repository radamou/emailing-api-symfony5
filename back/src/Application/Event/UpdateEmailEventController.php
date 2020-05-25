<?php

declare(strict_types=1);

namespace Emailing\Application\Event;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Emailing\Application\AbstractController;
use Emailing\Domain\Command\CommandInterface;
use Emailing\Domain\Command\Handler\UpdateEmailEventHandler;
use Emailing\Domain\DTO\EmailEventDTO;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class UpdateEmailEventController extends AbstractController
{
    /**
     * @Route("/email-events/{id}", name="sympl_api_email_event_update", methods={"PUT"})
     *
     * @ParamConverter("emailEventDTO", converter="fos_rest.request_body")
     */
    public function __invoke(
        string $id,
        EmailEventDTO $emailEventDTO,
        ?ConstraintViolationListInterface $validationErrors)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::EDIT_ROLE, $id);
        /** @var User $user */
        $user = $this->getUser();

        if ($validationErrors && \count($validationErrors) > 0) {
            throw InputException::create(InputException::EMAIL_NOT_FOUND, (array) $validationErrors);
        }

        $emailEvent = $this->getCommand()->execute(
            $emailEventDTO,
            $user,
            UpdateEmailEventHandler::class,
            $id
        );

        return $this->getApiSuccessResponse(['emailEvent' => $emailEvent]);
    }

    private function getCommand(): CommandInterface
    {
        /* @var CommandInterface */
        return  $this->get('sympl.domain.cqrs.crud_resource_chain');
    }
}
