<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Unit\Domain\Query\Handler;

use JMS\Serializer\Handler\StdClassHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use SymplBundle\Emailing\Domain\Query\Factory\ItemQueryFactoryInterface;
use SymplBundle\Emailing\Domain\Query\Factory\TransformerByRepositoryClassFactory;
use SymplBundle\Emailing\Domain\Query\Handler\ItemHandler;

class ItemHandlerTest extends TestCase
{
    /** @var ObjectProphecy&ItemQueryFactoryInterface */
    private $itemFactory;
    /** @var ObjectProphecy&TransformerByRepositoryClassFactory */
    private $transformerByRepositoryClassFactory;

    protected function setUp()
    {
        $this->transformerByRepositoryClassFactory = $this->prophesize(TransformerByRepositoryClassFactory::class);
        $this->itemFactory = $this->prophesize(ItemQueryFactoryInterface::class);
    }

    protected function tearDown()
    {
        $this->itemFactory = null;
        $this->transformerByRepositoryClassFactory = null;
    }

    public function testBadInputObject(): void
    {
        $getEmailEventItemHandler = new ItemHandler(
            $this->itemFactory->reveal(),
            $this->transformerByRepositoryClassFactory->reveal()
        );

        $this->expectException(\Exception::class);
        $getEmailEventItemHandler->handle(new StdClassHandler(), StdClassHandler::class);
    }

    public function testHandle(): void
    {
        $this->markTestIncomplete(
            'The repository is instantiated from the entity manager, the find method can
            be used from a doubler (prophesize repository)
            '
        );
    }
}
