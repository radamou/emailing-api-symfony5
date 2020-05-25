<?php

declare(strict_types=1);

namespace Emailing\Application\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Annotation\Route;
use Emailing\Application\AbstractController;
use Emailing\Domain\Query\DataProvider\CollectionDataProviderInterface;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use Emailing\Entity\EmailEvent;

class EmailEventListController extends AbstractController
{
    /**
     * @Route("/email-events", name="sympl_api_email_event_list", methods={"GET"})
     */
    public function __invoke()
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::CREATE_ROLE);

        /** @var ArrayCollection $emailEvents */
        $emailEvents = $this->getCollectionDataProvider()->getCollection(EmailEvent::class, []);

        return $this->getApiSuccessResponse($emailEvents->toArray());
    }

    public function getCollectionDataProvider(): CollectionDataProviderInterface
    {
        /* @var CollectionDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.collection_data_provider_chain');
    }
}
