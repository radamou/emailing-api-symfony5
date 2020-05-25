<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Domain\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use SymplBundle\Emailing\Domain\Command\Handler\CreateEmailEventHandler;
use SymplBundle\Emailing\Domain\DTO\EmailEventDTO;
use SymplBundle\Emailing\Domain\DTO\EmailEventVariableDTO;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use SymplBundle\Emailing\Domain\Factory\EmailEventFactory;
use SymplBundle\Emailing\Domain\Factory\EmailEventTemplateFactory;
use SymplBundle\Emailing\Domain\Factory\EmailTemplateFactory;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailEventTemplate;
use SymplBundle\Emailing\Entity\EmailEventVariable;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestAdmin;

class CreateEmailEventHandlerTest extends TestCase
{
    /** @var ObjectProphecy&EntityManagerInterface */
    private $entityManager;
    /** @var ObjectProphecy&EmailEventFactory */
    private $emailEventFactory;
    /** @var EmailEventTemplateFactory */
    private $emailEventTemplateFactory;
    /** @var EmailTemplateFactory */
    private $emailTemplateFactory;
    /** @var DTOFactoryInterface */
    private $emailEventDTOFactory;

    protected function setUp()
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->emailEventFactory = $this->prophesize(EmailEventFactory::class);
        $this->emailEventTemplateFactory = $this->prophesize(EmailEventTemplateFactory::class);
        $this->emailTemplateFactory = $this->prophesize(EmailTemplateFactory::class);
        $this->emailEventDTOFactory = $this->prophesize(DTOFactoryInterface::class);
    }

    protected function tearDown()
    {
        $this->entityManager = null;
        $this->emailEventFactory = null;
        $this->emailEventTemplateFactory = null;
        $this->emailTemplateFactory = null;
        $this->emailEventDTOFactory = null;
    }

    public function testHandle(): void
    {
        $user = new TestAdmin();

        $emailEventDTO = new EmailEventDTO();
        $emailEventDTO->code = 'command.delivery.successful';
        $emailEventDTO->description = 'Successful command delivery event';

        $emailTemplateDTO = new EmailTemplateDTO();
        $emailTemplateDTO->title = 'failed delivery command email';
        $emailTemplateDTO->body = "Dear Customer, your command has been successfully shipped, \n Best Regard";
        $emailTemplateDTO->language = 'en';

        $emailEventVariableDTO = new EmailEventVariableDTO();
        $emailEventVariableDTO->name = 'sender.name.test';
        $emailEventVariableDTO->description = 'user sender';

        $emailEventDTO->emailTemplate = $emailTemplateDTO;
        $emailEventDTO->emailEventVariables = [$emailEventVariableDTO];
        $emailEventDTO->isActive = true;

        $createdEmailEvent = (new EmailEvent())
            ->setCode('command.delivery.successful')
            ->setDescription('Successful command delivery event');

        $emailTemplate = (new EmailTemplate())
            ->setLanguage('en')
            ->setTitle('failed delivery command email')
            ->setBody("Dear Customer, your command has been successfully shipped, \n Best Regard");

        $emailEventVariables = new ArrayCollection();
        $emailEventVariables->add(
            (new EmailEventVariable())
                ->setName('sender.name.test')
                ->setDescription('user sender')
        );
        $createdEmailEvent->setEmailEventVariables($emailEventVariables);

        $emailEventTemplate = (new EmailEventTemplate())
            ->setEmailEvent($createdEmailEvent)
            ->setCustomerCompany(null)
            ->setEmailTemplate($emailTemplate)
            ->setIsActive(true);

        $this->emailEventFactory->create($emailEventDTO)->willReturn($createdEmailEvent);
        $this->emailTemplateFactory->create($emailEventDTO->emailTemplate)->willReturn($emailTemplate);
        $this->emailEventTemplateFactory->create(
            $user,
            $createdEmailEvent,
            $emailTemplate,
            $emailEventDTO->isActive
        )->willReturn($emailEventTemplate);

        $this->entityManager->persist($emailTemplate)->shouldBeCalled();
        $this->entityManager->persist($createdEmailEvent)->shouldBeCalled();
        $this->entityManager->persist($emailEventTemplate)->shouldBeCalled();
        $this->entityManager->flush()->shouldBeCalled();

        $createEmailEventHandler = new  CreateEmailEventHandler(
            $this->entityManager->reveal(),
            $this->emailEventFactory->reveal(),
            $this->emailTemplateFactory->reveal(),
            $this->emailEventTemplateFactory->reveal(),
            $this->emailEventDTOFactory->reveal()
        );

        $result = $createEmailEventHandler->handle($emailEventDTO, $user);
        $this->assertEquals($createdEmailEvent->getDescription(), $result->getDescription());
        $this->assertEquals($createdEmailEvent->getCode(), $result->getCode());
    }
}
