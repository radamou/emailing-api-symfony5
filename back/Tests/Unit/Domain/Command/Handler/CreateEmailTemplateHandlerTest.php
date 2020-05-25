<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Domain\Handler;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Ramsey\Uuid\Uuid;
use SymplBundle\Emailing\Domain\Command\Handler\CreateEmailTemplateHandler;
use SymplBundle\Emailing\Domain\DTO\EmailEventDTO;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use SymplBundle\Emailing\Domain\Factory\EmailEventTemplateFactory;
use SymplBundle\Emailing\Domain\Factory\EmailTemplateFactory;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailEventTemplate;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestCompany;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestUser;

class CreateEmailTemplateHandlerTest extends TestCase
{
    /** @var ObjectProphecy&EntityManagerInterface */
    private $entityManager;
    /** @var ObjectProphecy&EmailTemplateFactory */
    private $emailTemplateFactory;
    /** @var ObjectProphecy&EmailEventTemplateFactory */
    private $emailEventTemplateFactory;
    /** @var ObjectProphecy&DTOFactoryInterface */
    private $emailTemplateDTOFactory;
    /** @var ObjectProphecy&ItemDataProviderInterface */
    private $itemDataProvider;
    private $createEmailTemplateHandler;

    protected function setUp()
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->emailTemplateFactory = $this->prophesize(EmailTemplateFactory::class);
        $this->emailEventTemplateFactory = $this->prophesize(EmailEventTemplateFactory::class);
        $this->emailTemplateDTOFactory = $this->prophesize(DTOFactoryInterface::class);
        $this->itemDataProvider = $this->prophesize(ItemDataProviderInterface::class);

        $this->createEmailTemplateHandler = new CreateEmailTemplateHandler(
            $this->entityManager->reveal(),
            $this->emailTemplateFactory->reveal(),
            $this->emailEventTemplateFactory->reveal(),
            $this->emailTemplateDTOFactory->reveal(),
            $this->itemDataProvider->reveal()
        );
    }

    protected function tearDown()
    {
        $this->entityManager = null;
        $this->emailTemplateFactory = null;
        $this->emailEventTemplateFactory = null;
        $this->emailTemplateDTOFactory = null;
        $this->itemDataProvider = null;
    }

    public function testHandle(): void
    {
        $id = Uuid::uuid4();
        $user = new TestUser();
        $company = (new TestCompany())->setId(1);
        $user->setCompany($company);

        $emailTemplateDTO = new EmailTemplateDTO();
        $emailTemplateDTO->title = 'Successful command delivery email template';
        $emailTemplateDTO->body = "Dear Customer, your command has been successfully shipped, \n Best Regard";
        $emailTemplateDTO->language = 'fr';

        $emailTemplateDTO->emailEvent = new EmailEventDTO();
        $emailTemplateDTO->emailEvent->id = $id->toString();
        $emailTemplateDTO->emailEvent->isActive = true;

        $createdEmailTemplate = (new EmailTemplate())
            ->setTitle('Successful command delivery email template')
            ->setBody("Dear Customer, your command has been successfully shipped, \n Best Regard")
            ->setLanguage('fr');

        $createdEmailEvent = (new EmailEvent())
            ->setCode('command.delivery.successful')
            ->setDescription('Successful command delivery event');

        $emailEventTemplate = (new EmailEventTemplate())
            ->setEmailEvent($createdEmailEvent)
            ->setCustomerCompany($company)
            ->setEmailTemplate($createdEmailTemplate)
            ->setIsActive(true);

        $this->emailTemplateFactory->create($emailTemplateDTO)->willReturn($createdEmailTemplate);
        $this->itemDataProvider->getItem(EmailEvent::class, $id->toString())->willReturn($createdEmailEvent);

        $this->entityManager->persist($createdEmailTemplate)->shouldBeCalled();
        $this->emailEventTemplateFactory->create(
            $user,
            $createdEmailEvent,
            $createdEmailTemplate,
            true
        )->willReturn($emailEventTemplate);
        $this->entityManager->persist($emailEventTemplate)->shouldBeCalled();
        $this->entityManager->flush()->shouldBeCalled();
        $result = $this->createEmailTemplateHandler->handle($emailTemplateDTO, $user);

        $this->assertEquals($createdEmailTemplate->getTitle(), $result->getTitle());
    }
}
