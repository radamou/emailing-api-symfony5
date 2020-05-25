<?php

declare(strict_types=1);

namespace Emailing\Domain\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Emailing\Domain\DTO\EmailTemplateDTO;
use Emailing\Entity\EmailTemplate;

class EmailTemplateFactory
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(?object $emailTemplateDTO): EmailTemplate
    {
        if ($emailTemplateDTO instanceof EmailTemplateDTO && $templateId = $emailTemplateDTO->id) {
            $emailTemplateRepository = $this->entityManager->getRepository(EmailTemplate::class);
            /** @var EmailTemplate $emailTemplate */
            $emailTemplate = $emailTemplateRepository->find($templateId);

            return $emailTemplate;
        }

        $emailTemplate = new EmailTemplate();

        if ($emailTemplateDTO instanceof EmailTemplateDTO) {
            $emailTemplate
                ->setTitle($emailTemplateDTO->title)
                ->setBody($emailTemplateDTO->body)
                ->setLanguage($emailTemplateDTO->language);
        }

        return  $emailTemplate;
    }
}
