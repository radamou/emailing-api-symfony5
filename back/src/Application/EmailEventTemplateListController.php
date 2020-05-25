<?php

declare(strict_types=1);

namespace Emailing\Application;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Emailing\Domain\DTO\EmailEventTemplateDTO;
use Emailing\Domain\Query\DataProvider\CollectionDataProviderInterface;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use Emailing\Entity\EmailEventTemplate;

class EmailEventTemplateListController extends AbstractController
{
    /**
     * @Route("/email-event-templates", name="sympl_api_email_event_template_list", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        #$this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);

        /** @var EmailEventTemplateDTO $templateEmail */
        $emailEventTemplates = $this->getCollectionDataProvider()->getCollection(
            EmailEventTemplate::class, $request->query->all()
    );

        /* @var ArrayCollection $emailEventTemplates */
        return $this->getApiSuccessResponse($emailEventTemplates->toArray());
    }

    public function getCollectionDataProvider(): CollectionDataProviderInterface
    {
        /* @var CollectionDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.collection_data_provider_chain');
    }
}
