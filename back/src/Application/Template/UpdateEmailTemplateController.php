<?php

declare(strict_types=1);

namespace Emailing\Application\Template;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Emailing\Application\AbstractController;
use Emailing\Domain\Command\CommandInterface;
use Emailing\Domain\Command\Handler\UpdateEmailTemplateHandler;
use Emailing\Domain\DTO\EmailTemplateDTO;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class UpdateEmailTemplateController extends AbstractController
{
    /**
     * @Route("/email-templates/{id}", name="sympl_api_email_template_update", methods={"PUT"})
     *
     * @ParamConverter("emailTemplateDTO", converter="fos_rest.request_body")
     */
    public function __invoke(string $id, EmailTemplateDTO $emailTemplateDTO, ?ConstraintViolationListInterface $validationErrors)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::EDIT_ROLE, $id);

        /** @var User $user */
        $user = $this->getUser();

        if ($validationErrors && \count($validationErrors) > 0) {
            throw InputException::create(InputException::EMAIL_NOT_FOUND, (array) $validationErrors);
        }

        $emailTemplate = $this->getCommand()->execute(
            $emailTemplateDTO,
            $user,
            UpdateEmailTemplateHandler::class,
            $id
        );

        return $this->getApiSuccessResponse(['emailTemplate' => $emailTemplate]);
    }

    private function getCommand(): CommandInterface
    {
        /* @var CommandInterface */
        return  $this->get('sympl.domain.cqrs.crud_resource_chain');
    }
}
