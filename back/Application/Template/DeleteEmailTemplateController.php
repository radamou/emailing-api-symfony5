<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application\Template;

use Symfony\Component\Routing\Annotation\Route;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\Command\CommandInterface;
use SymplBundle\Emailing\Domain\Command\Handler\DeleteEmailTemplateHandler;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Entity\User\User;

class DeleteEmailTemplateController extends AbstractController
{
    /**
     * @Route("/email-templates/{id}", name="sympl_api_email_template_delete", methods={"DELETE"})
     */
    public function __invoke(string $id)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::DELETE_ROLE, $id);

        /** @var User $user */
        $user = $this->getUser();
        $emailTemplate = $this->getItemDataProvider()->getItem(EmailTemplate::class, $id);

        $this->getCommand()->execute(
            $emailTemplate,
            $user,
            DeleteEmailTemplateHandler::class,
            $id
        );

        return $this->getApiSuccessResponse(['success' => true]);
    }

    public function getItemDataProvider(): ItemDataProviderInterface
    {
        /* @var ItemDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.item_data_provider_chain');
    }

    private function getCommand(): CommandInterface
    {
        /* @var CommandInterface */
        return  $this->get('sympl.domain.cqrs.crud_resource_chain');
    }
}
