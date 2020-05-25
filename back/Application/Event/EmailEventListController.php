<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Annotation\Route;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\Query\DataProvider\CollectionDataProviderInterface;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Emailing\Entity\EmailEvent;

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
