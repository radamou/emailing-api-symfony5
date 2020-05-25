<?php

declare(strict_types=1);

namespace Emailing\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use SymplBundle\Entity\CustomerCompany;

/**
 * @ORM\Table(
 *    name="email_event_template",
 *    indexes={@ORM\Index(name="index_email_event_template_company_id", columns={"email_event_id", "email_template_id", "customer_company_id"})},
 *    uniqueConstraints={@ORM\UniqueConstraint(name="email_event_template_company_id", columns={"email_event_id", "email_template_id", "customer_company_id"})}
 * )
 * @UniqueEntity(fields={"emailEvent", "emailTemplate","customerCompany"}, errorPath="customerCompany")
 * @ORM\Entity(repositoryClass="EmailEventTemplateRepository")
 */
class EmailEventTemplate
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(name="id", type="uuid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @var EmailEvent
     *
     * @ORM\ManyToOne(targetEntity="EmailEvent", inversedBy="emailEvent")
     * @ORM\JoinColumn(name="email_event_id", referencedColumnName="id", nullable=false)
     */
    private $emailEvent;

    /**
     * @var EmailTemplate
     *
     * @ORM\ManyToOne(targetEntity="EmailTemplate", inversedBy="emailTemplate")
     * @ORM\JoinColumn(name="email_template_id", referencedColumnName="id", nullable=false)
     */
    private $emailTemplate;

    /**
     *  @var CustomerCompany
     *
     * @ORM\ManyToOne(targetEntity="SymplBundle\Entity\CustomerCompany", inversedBy="customerCompany")
     * @ORM\JoinColumn(name="customer_company_id", referencedColumnName="id", nullable=true)
     */
    private $customerCompany;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", options={"default":false})
     */
    private $isActive;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getEmailEvent(): EmailEvent
    {
        return $this->emailEvent;
    }

    public function setEmailEvent(EmailEvent $emailEvent): self
    {
        $this->emailEvent = $emailEvent;

        return  $this;
    }

    public function getEmailTemplate(): EmailTemplate
    {
        return $this->emailTemplate;
    }

    public function setEmailTemplate(EmailTemplate $emailTemplate): self
    {
        $this->emailTemplate = $emailTemplate;

        return  $this;
    }

    public function getCustomerCompany(): ?CustomerCompany
    {
        return $this->customerCompany;
    }

    public function setCustomerCompany(?CustomerCompany $customerCompany): self
    {
        $this->customerCompany = $customerCompany;

        return  $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
