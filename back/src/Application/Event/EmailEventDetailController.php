<?php

declare(strict_types=1);

namespace Emailing\Application\Event;

use Symfony\Component\Routing\Annotation\Route;
use Emailing\Application\AbstractController;
use Emailing\Domain\DTO\EmailEventDTO;
use Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use Emailing\Entity\EmailEvent;

class EmailEventDetailController extends AbstractController
{
    /**
     * @Route("/email-events/{id}", name="email_event_detail", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);

        /** @var EmailEventDTO $emailEvent */
        $emailEvent = $this->getItemDataProvider()->getItem(EmailEvent::class, $id, true);

        return $this->getApiSuccessResponse([$emailEvent]);
    }

    public function getItemDataProvider(): ItemDataProviderInterface
    {
        /* @var ItemDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.item_data_provider_chain');
    }
}
