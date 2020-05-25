<?php

namespace SymplBundle\Emailing\Application\Template;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Domain\Query\DataProvider\CollectionDataProviderInterface;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Emailing\Entity\EmailTemplate;

class EmailTemplateListController extends AbstractController
{
    /**
     * @Route("/email-templates", name="sympl_api_email_template_list", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);

        /** @var EmailTemplateDTO $emailTemplate */
        $emailEventTemplates = $this->getCollectionDataProvider()->getCollection(
            EmailTemplate::class,
            $request->query->all()
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
