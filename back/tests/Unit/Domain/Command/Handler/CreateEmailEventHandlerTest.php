<?php

declare(strict_types=1);

namespace Emailing\Tests\Domain\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Emailing\Domain\Command\Handler\CreateEmailEventHandler;
use Emailing\Domain\DTO\EmailEventDTO;
use Emailing\Domain\DTO\EmailEventVariableDTO;
use Emailing\Domain\DTO\EmailTemplateDTO;
use Emailing\Domain\Factory\DTOFactoryInterface;
use Emailing\Domain\Factory\EmailEventFactory;
use Emailing\Domain\Factory\EmailEventTemplateFactory;
use Emailing\Domain\Factory\EmailTemplateFactory;
use Emailing\Entity\EmailEvent;
use Emailing\Entity\EmailEventTemplate;
use Emailing\Entity\EmailEventVariable;
use Emailing\Entity\EmailTemplate;
use Emailing\Tests\Unit\Domain\FakeEntities\TestAdmin;

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
