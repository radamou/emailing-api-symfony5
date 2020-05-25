<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Application\Template;

use Symfony\Component\Routing\Annotation\Route;
use SymplBundle\Emailing\Application\AbstractController;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Emailing\Entity\EmailTemplate;

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
