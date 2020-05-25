<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Unit\Domain\Query\Handler;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use SymplBundle\Emailing\Domain\Query\Builder\CollectionQueryFilterBuilder;
use SymplBundle\Emailing\Domain\Query\Factory\CollectionFilterFactoryInterface;
use SymplBundle\Emailing\Domain\Query\Factory\TransformerByRepositoryClassFactory;
use SymplBundle\Emailing\Domain\Query\Handler\CollectionHandler;
use SymplBundle\Emailing\Domain\Query\Handler\CollectionHandlerInterface;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailEventRepository;

class CollectionHandlerTest extends TestCase
{
    /** @var ObjectProphecy&CollectionFilterFactoryInterface */
    private $collectionFilterFactory;
    /** @var ObjectProphecy&TransformerByRepositoryClassFactory */
    private $transformerFactory;
    private $collectionHandler;

    protected function setUp()
    {
        $this->collectionFilterFactory = $this->prophesize(CollectionFilterFactoryInterface::class);
        $this->transformerFactory = $this->prophesize(TransformerByRepositoryClassFactory::class);
        $this->collectionHandler = new CollectionHandler(
           $this->collectionFilterFactory->reveal(),
           $this->transformerFactory->reveal()
       );
    }

    protected function tearDown()
    {
        $this->collectionFilterFactory = null;
        $this->transformerFactory = null;
        $this->collectionHandler = null;
    }

    public function testSupport()
    {
        $this->assertTrue(
            $this->collectionHandler->support(CollectionHandlerInterface::class)
        );
    }

    public function testHandle()
    {
        $repository = $this->prophesize(EmailEventRepository::class);
        $collectionFilterBuilderQuery = new CollectionQueryFilterBuilder([]);
        $this->transformerFactory->getRepository(EmailEvent::class)->willReturn($repository->reveal());

        $this->markTestIncomplete("je ne sais pas comment mocker la variable repository que j'utilise dansmes actions");
    }
}
