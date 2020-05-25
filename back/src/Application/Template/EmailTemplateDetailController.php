<?php

declare(strict_types=1);

namespace Emailing\Application\Template;

use Symfony\Component\Routing\Annotation\Route;
use Emailing\Application\AbstractController;
use Emailing\Domain\DTO\EmailTemplateDTO;
use Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use Emailing\Domain\Security\CustomerCompanyAccessControl;
use Emailing\Entity\EmailTemplate;

class EmailTemplateDetailController extends AbstractController
{
    /**
     * @Route("/email-templates/{id}", name="email_template_detail", methods={"GET"})
     */
    public function __invoke(string $id)
    {
        #$this->denyAccessUnlessGranted(CustomerCompanyAccessControl::VIEW_ROLE);

        /** @var EmailTemplateDTO $emailTemplate */
        $emailTemplate = $this->getItemDataProvider()->getItem(EmailTemplate::class, $id, true);

        return $this->getApiSuccessResponse([$emailTemplate]);
    }

    public function getItemDataProvider(): ItemDataProviderInterface
    {
        /* @var ItemDataProviderInterface */
        return  $this->get('sympl.cqrs.domain.query.item_data_provider_chain');
    }
}
