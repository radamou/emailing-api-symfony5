<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application;

use Symfony\Component\Routing\Annotation\Route;
use SymplBundle\Emailing\Domain\DTO\EmailEventTemplateDTO;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Emailing\Entity\EmailEventTemplate;

class EmailEventTemplateDetailController extends AbstractController
{
    /**
     * @Route("/email-event-templates/{id}", name="email_event_template", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);

        /** @var EmailEventTemplateDTO $emailEventTemplate */
        $emailEventTemplate = $this->getItemDataProvider()->getItem(EmailEventTemplate::class, $id, true);

        return $this->getApiSuccessResponse([$emailEventTemplate]);
    }

    public function getItemDataProvider(): ItemDataProviderInterface
    {
        /* @var ItemDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.item_data_provider_chain');
    }
}
