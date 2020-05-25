<?php

declare(strict_types=1);

namespace Emailing\Application\Variable;

use Symfony\Component\Routing\Annotation\Route;
use Emailing\Application\AbstractController;
use Emailing\Domain\DTO\EmailEventVariableDTO;
use Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use Emailing\Entity\EmailEventVariable;

class EmailVariableDetailController extends AbstractController
{
    /**
     * @Route("/email-variables/{id}", name="email_variable_detail", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        $this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);

        /** @var EmailEventVariableDTO $emailEventVariable */
        $emailEventVariable = $this->getItemDataProvider()->getItem(EmailEventVariable::class, $id, true);

        return $this->getApiSuccessResponse([$emailEventVariable]);
    }

    public function getItemDataProvider(): ItemDataProviderInterface
    {
        /* @var ItemDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.item_data_provider_chain');
    }
}
