<?php

declare(strict_types=1);

namespace Emailing\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;

/**
 * @ORM\Table(name="email_event_variable")
 *
 * @ORM\Entity(repositoryClass=EmailEventVariableRepository::class)
 * @UniqueEntity(fields={"name"}, message="This variable already exist")
 */
class EmailEventVariable
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Validator\NotNull()
     * @Validator\Regex(
     *     pattern="/^([a-z]+.?)$/",
     *     match=false,
     *     message="the title should only by a string separated by dot"
     * )
     **/
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     *
     * @Validator\NotNull()
     * )
     **/
    private $description;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="createdAt", type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="updatedAt", type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @var EmailEvent
     *
     * @ORM\ManyToOne(targetEntity="EmailEvent", inversedBy="emailEvent")
     * @ORM\JoinColumn(name="email_event_id", referencedColumnName="id", nullable=false)
     */
    private $emailEvent;

    public function __construct()
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEmailEvent(): EmailEvent
    {
        return $this->emailEvent;
    }

    public function setEmailEvent(EmailEvent $emailEvent): self
    {
        $this->emailEvent = $emailEvent;

        return $this;
    }
}
