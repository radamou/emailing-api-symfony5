<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Domain\Handler;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use SymplBundle\Emailing\Domain\Command\Handler\DeleteEmailTemplateHandler;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestCompany;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestUser;

class DeleteEmailTemplateHandlerTest extends TestCase
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
        $user = new TestUser();
        $company = (new TestCompany())->setId(1);
        $user->setCompany($company);

        $this->expectException(\InvalidArgumentException::class);
        $deleteEmailTemplateHandler = new DeleteEmailTemplateHandler($this->entityManager->reveal());
        $deleteEmailTemplateHandler->handle(new EmailEvent(), $user);
    }

    public function testExecute(): void
    {
        $user = new TestUser();
        $company = (new TestCompany())->setId(1);
        $user->setCompany($company);

        $deleteEmailTemplate = (new EmailTemplate())
            ->setTitle('Successful command delivery email template updated')
            ->setBody("Dear Customer, your command has been successfully shipped, \n Best Regard")
            ->setLanguage('fr');

        $this->entityManager->remove($deleteEmailTemplate)->shouldBeCalled();
        $this->entityManager->flush()->shouldBeCalled();
        $deleteEmailTemplateHandler = new DeleteEmailTemplateHandler($this->entityManager->reveal());
        $deleteEmailTemplateHandler->handle($deleteEmailTemplate, $user);
    }
}
