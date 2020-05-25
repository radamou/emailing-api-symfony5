<?php

declare(strict_types=1);

namespace Emailing\Tests\Domain\Handler;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Emailing\Domain\Command\Handler\UpdateEmailEventHandler;
use Emailing\Domain\DTO\EmailEventDTO;
use Emailing\Domain\Factory\DTOFactoryInterface;
use Emailing\Domain\Factory\EmailEventDTOFactory;
use Emailing\Domain\Factory\EmailEventFactory;
use Emailing\Domain\Query\DataProvider\ItemDataProviderInterface;
use Emailing\Entity\EmailEvent;
use Emailing\Tests\Unit\Domain\FakeEntities\TestAdmin;

class UpdateEmailEventHandlerTest extends TestCase
{
    /** @var ObjectProphecy&EntityManagerInterface */
    private $entityManager;
    /** @var ObjectProphecy&EmailEventFactory */
    private $emailEventFactory;
    /** @var ObjectProphecy&ItemDataProviderInterface */
    private $emailEventItemDataProvider;
    /** @var ObjectProphecy&EmailEventDTOFactory */
    private $emailEventDTOFactory;
    private $updateEmailEventHandler;

    protected function setUp()
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->emailEventFactory = $this->prophesize(EmailEventFactory::class);
        $this->emailEventItemDataProvider = $this->prophesize(ItemDataProviderInterface::class);
        $this->emailEventDTOFactory = $this->prophesize(DTOFactoryInterface::class);

        $this->updateEmailEventHandler = new UpdateEmailEventHandler(
            $this->entityManager->reveal(),
            $this->emailEventFactory->reveal(),
            $this->emailEventItemDataProvider->reveal(),
            $this->emailEventDTOFactory->reveal()
        );
    }

    protected function tearDown()
    {
        $this->entityManager = null;
        $this->emailEventFactory = null;
        $this->emailEventItemDataProvider = null;
        $this->emailEventDTOFactory = null;
    }

    public function testHandle(): void
    {
        $user = new TestAdmin();
        $id = '775d8ecc-2186-11ea-978f-2e728ce88125';

        $emailEventDTO = new EmailEventDTO();
        $emailEventDTO->description = 'Successful command delivery event updated';

        $updatedEmailEvent = (new EmailEvent())
            ->setDescription('Successful command delivery event updated');

        $this->emailEventItemDataProvider->getItem(EmailEvent::class, $id)->willReturn($updatedEmailEvent);

        $this->emailEventFactory->update($updatedEmailEvent, $emailEventDTO)->willReturn($updatedEmailEvent);
        $this->entityManager->persist($updatedEmailEvent)->shouldBeCalled();
        $this->entityManager->flush()->shouldBeCalled();

        $result = $this->updateEmailEventHandler->handle($emailEventDTO, $user, $id);
        $this->assertEquals($updatedEmailEvent->getDescription(), $result->getDescription());
    }
}
