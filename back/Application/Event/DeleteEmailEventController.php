<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application\Event;

use Symfony\Component\Routing\Annotation\Route;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\Command\CommandInterface;
use SymplBundle\Emailing\Domain\Command\Handler\DeleteEmailEventHandler;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Entity\User\User;

class DeleteEmailEventController extends AbstractController
{
    /**
     * @Route("/email-events/{id}", name="sympl_api_email_event_delete", methods={"DELETE"})
     */
    public function __invoke(string $id)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::DELETE_ROLE, $id);

        /** @var User $user */
        $user = $this->getUser();
        $emailEvent = $this->getItemDataProvider()->getItem(EmailEvent::class, $id);

        $this->getCommand()->execute(
            $emailEvent,
            $user,
            DeleteEmailEventHandler::class,
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
