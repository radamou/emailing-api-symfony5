<?php

declare(strict_types=1);

namespace Emailing\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;

/**
 * @ORM\Table(name="email_event")
 * @ORM\Entity(repositoryClass="EmailEventRepository")
 *
 * @UniqueEntity(fields={"code"}, message="This email event already exist")
 */
class EmailEvent
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
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     * @Validator\NotNull()
     * @Validator\Regex(
     *     pattern="/^([a-z]+.?)$/",
     *     match=false,
     *     message="the code should only be a string separated by dot"
     * )
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Validator\NotNull()
     */
    private $description;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="createdAt", type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity=EmailEventVariable::class,
     *     mappedBy="emailEvent",
     *     indexBy="name",
     *     fetch="EXTRA_LAZY",
     *     cascade={"persist", "remove"}
     * )
     */
    private $emailEventVariables;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity=EmailEventTemplate::class,
     *     mappedBy="emailEvent",
     *     indexBy="emailEvent",
     *     fetch="EXTRA_LAZY",
     *     cascade={"remove"}
     * )
     */
    private $emailEventTemplates;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="updatedAt", type="datetime_immutable")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->emailEventVariables = new ArrayCollection();
        $this->emailEventTemplates = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getEmailEventVariables(): Collection
    {
        return $this->emailEventVariables;
    }

    public function setEmailEventVariables(Collection $emailEventVariables): self
    {
        $this->emailEventVariables = $emailEventVariables;

        return $this;
    }

    public function addEmailEventVariable(EmailEventVariable $emailEventVariable): self
    {
        $this->emailEventVariables->add($emailEventVariable);

        return  $this;
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
