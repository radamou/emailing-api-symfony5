<?php

declare(strict_types=1);

namespace Emailing\Application\Variable;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Emailing\Application\AbstractController;
use Emailing\Domain\Query\DataProvider\CollectionDataProviderInterface;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use Emailing\Entity\EmailEventVariable;

class ListVariablesController extends AbstractController
{
    /**
     * @Route("/email-variables", name="sympl_api_email_variable_list", methods={"GET"})
     */
    public function __invoke(Request $request)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::CREATE_ROLE);

        /** @var ArrayCollection $emailEventVariables */
        $emailEventVariables = $this->getCollectionDataProvider()->getCollection(
            EmailEventVariable::class,
            $request->query->all()
        );

        return $this->getApiSuccessResponse($emailEventVariables->toArray());
    }

    public function getCollectionDataProvider(): CollectionDataProviderInterface
    {
        /* @var CollectionDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.collection_data_provider_chain');
    }
}
