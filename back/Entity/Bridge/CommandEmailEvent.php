<?php

namespace SymplBundle\Emailing\Entity\Bridge;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Entity\Command;
use SymplBundle\Entity\Email;

/**
 * @ORM\Table(name="command_email_event")
 * @ORM\Entity(repositoryClass=CommandEmailEventRepository::class)
 */
class CommandEmailEvent
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
     * @ORM\OneToOne(targetEntity=EmailEvent::class)
     */
    private $emailEvent;

    /**
     * @var Command
     *
     * @ORM\OneToOne(targetEntity=Command::class)
     */
    private $command;

    /**
     * @var Email
     *
     * @ORM\OneToOne(targetEntity=Email::class)
     */
    private $email;

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

    public function __construct()
    {
        $this->createdAt = $this->createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setCommand(Command $commandId): self
    {
        $this->command = $commandId;

        return $this;
    }

    public function getCommand(): Command
    {
        return $this->command;
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

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
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
}
