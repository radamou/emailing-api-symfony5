<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Domain\Handler;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use SymplBundle\Emailing\Domain\Command\Handler\DeleteEmailEventHandler;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestAdmin;

class DeleteEmailEventHandlerTest extends TestCase
{
    /** @var ObjectProphecy&EntityManagerInterface */
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
    }

    protected function tearDown()
    {
        $this->entityManager = null;
    }

    public function testExecuteWillThrowInvalidArgumentException(): void
    {
        $user = new TestAdmin();
        $this->expectException(\InvalidArgumentException::class);
        $deleteEmailEventHandler = new DeleteEmailEventHandler($this->entityManager->reveal());
        $deleteEmailEventHandler->handle(new EmailTemplate(), $user);
    }

    public function testExecute(): void
    {
        $user = new TestAdmin();
        $updatedEmailEvent = (new EmailEvent())
            ->setCode('command.delivery.successful')
            ->setDescription('Successful command delivery event updated');

        $this->entityManager->remove($updatedEmailEvent)->shouldBeCalled();
        $this->entityManager->flush()->shouldBeCalled();
        $deleteEmailEventHandler = new DeleteEmailEventHandler($this->entityManager->reveal());
        $deleteEmailEventHandler->handle($updatedEmailEvent, $user);
    }
}
