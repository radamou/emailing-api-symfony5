<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Validator;

/**
 * @ORM\Table(name="email_template")
 * @ORM\Entity(repositoryClass="EmailTemplateRepository")
 */
class EmailTemplate
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
     * @var string
     * @Validator\NotNull()
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Validator\NotNull()
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /** @var string
     *
     * @ORM\Column(name="language", type="string", length=255)
     *
     * @Validator\Choice(TemplateLanguage::LANGUAGES)
     */
    private $language;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="created_date", type="date_immutable", length=255)
     */
    private $createdDate;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="update_date", type="datetime_immutable", length=255)
     */
    private $updateDate;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity=EmailEventTemplate::class,
     *     mappedBy="emailTemplate",
     *     indexBy="emailTemplate",
     *     fetch="EXTRA_LAZY",
     *     cascade={"remove"}
     * )
     */
    private $emailEventTemplates;

    public function __construct()
    {
        $this->createdDate = $this->createdDate ?? new \DateTimeImmutable();
        $this->updateDate = new \DateTimeImmutable();
        $this->emailEventTemplates = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setCreatedDate(\DateTimeImmutable $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getCreatedDate(): \DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function setUpdateDate(\DateTimeImmutable $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getUpdateDate(): \DateTimeImmutable
    {
        return $this->updateDate;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getEmailEventTemplates(): Collection
    {
        return $this->emailEventTemplates;
    }

    public function setEmailEventTemplates(Collection $emailEventTemplates): self
    {
        $this->emailEventTemplates = $emailEventTemplates;

        return $this;
    }
}
