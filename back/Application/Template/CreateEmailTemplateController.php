<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application\Template;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\Command\CommandInterface;
use SymplBundle\Emailing\Domain\Command\Handler\CreateEmailTemplateHandler;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Entity\User\User;
use SymplBundle\Exception\InputException;

class CreateEmailTemplateController extends AbstractController
{
    /**
     * @Route("/email-templates", name="sympl_api_email_template_create", methods={"POST"})
     *
     * @ParamConverter("emailTemplateDTO", converter="fos_rest.request_body")
     */
    public function __invoke(EmailTemplateDTO $emailTemplateDTO, ?ConstraintViolationListInterface $validationErrors)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::CREATE_ROLE);

        /** @var User $user */
        $user = $this->getUser();

        if ($validationErrors && \count($validationErrors) > 0) {
            throw InputException::create(InputException::INVALID_EMAILING_BODY_PARAM, (array) $validationErrors);
        }

        /** @var EmailTemplateDTO $templateEmail */
        $emailTemplate = $this->getCommand()->execute(
            $emailTemplateDTO,
            $user,
            CreateEmailTemplateHandler::class
        );

        return $this->getApiSuccessResponse(['emailTemplate' => $emailTemplate]);
    }

    private function getCommand(): CommandInterface
    {
        /* @var CommandInterface */
        return  $this->get('sympl.domain.cqrs.crud_resource_chain');
    }
}
