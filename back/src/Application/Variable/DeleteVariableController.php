<?php

declare(strict_types=1);

namespace Emailing\Application\Variable;

use Symfony\Component\Routing\Annotation\Route;
use Emailing\Application\AbstractController;
use Emailing\Domain\Command\CommandInterface;
use Emailing\Domain\Command\Handler\DeleteVariableHandler;
use Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use Emailing\Entity\EmailEventVariable;
use SymplBundle\Entity\User\User;

class DeleteVariableController extends AbstractController
{
    /**
     * @Route("/email-variables/{id}", name="sympl_api_email_variables_delete", methods={"DELETE"})
     */
    public function __invoke(string $id)
    {
        #$this->denyAccessUnlessGranted(CustomerCompanyAccessControl::DELETE_ROLE, $id);

        /** @var User $user */
        $user = $this->getUser();
        $emailVariable = $this->getItemDataProvider()->getItem(EmailEventVariable::class, $id);

        $this->getCommand()->execute(
            $emailVariable,
            $user,
            DeleteVariableHandler::class,
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
