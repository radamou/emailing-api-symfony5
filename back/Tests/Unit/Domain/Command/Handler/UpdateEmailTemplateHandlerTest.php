<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Domain\Handler;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use SymplBundle\Emailing\Domain\Command\Handler\UpdateEmailTemplateHandler;
use SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO;
use SymplBundle\Emailing\Domain\Factory\DTOFactoryInterface;
use SymplBundle\Emailing\Domain\Factory\EmailTemplateFactory;
use SymplBundle\Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestCompany;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestUser;

class UpdateEmailTemplateHandlerTest extends TestCase
{
    /** @var ObjectProphecy&EntityManagerInterface */
    private $entityManager;
    /** @var ObjectProphecy&EmailTemplateFactory */
    private $emailTemplateFactory;
    /** @var ObjectProphecy&ItemDataProviderInterface */
    private $emailTemplateItemDataProvider;
    private $createEmailTemplateHandler;
    /** @var ObjectProphecy&DTOFactoryInterface */
    private $emailTemplateDTOFactory;

    protected function setUp()
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->emailTemplateFactory = $this->prophesize(EmailTemplateFactory::class);
        $this->emailTemplateItemDataProvider = $this->prophesize(ItemDataProviderInterface::class);
        $this->emailTemplateDTOFactory = $this->prophesize(DTOFactoryInterface::class);

        $this->createEmailTemplateHandler = new UpdateEmailTemplateHandler(
            $this->entityManager->reveal(),
            $this->emailTemplateFactory->reveal(),
            $this->emailTemplateItemDataProvider->reveal(),
            $this->emailTemplateDTOFactory->reveal()
        );
    }

    protected function tearDown()
    {
        $this->entityManager = null;
        $this->emailTemplateFactory = null;
        $this->emailTemplateItemDataProvider = null;
        $this->emailTemplateDTOFactory = null;
        $this->createEmailTemplateHandler = null;
    }

    public function testHandle(): void
    {
        $user = new TestUser();
        $company = (new TestCompany())->setId(1);
        $user->setCompany($company);
        $id = '775d8ecc-2186-11ea-978f-2e728ce88125';

        $emailTemplateDTO = new EmailTemplateDTO();
        $emailTemplateDTO->title = 'Successful command delivery email template updated';
        $emailTemplateDTO->body = "Dear Customer, your command has been successfully shipped, \n Best Regard";
        $emailTemplateDTO->language = 'fr';

        $createdEmailTemplate = (new EmailTemplate())
            ->setTitle('Successful command delivery email template updated')
            ->setBody("Dear Customer, your command has been successfully shipped, \n Best Regard")
            ->setLanguage('fr');

        $this->emailTemplateItemDataProvider->getItem(EmailTemplate::class, $id)->willReturn($createdEmailTemplate);
        $this->entityManager->persist($createdEmailTemplate)->shouldBeCalled();
        $this->entityManager->flush()->shouldBeCalled();
        $result = $this->createEmailTemplateHandler->handle($emailTemplateDTO, $user, $id);
        $this->assertEquals($emailTemplateDTO->title, $result->getTitle());
    }
}
