<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SymplBundle\Tests\Controller\API\Token;

class AbstractWebTestCase extends WebTestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $loader = new Loader();
        $loader->loadFromDirectory(__DIR__.'/Fixtures');
        $purger = new ORMPurger($this->entityManager, ExcludedTablesList::EXCLUDED_TABLES);
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function authenticationDataProvider(): \Generator
    {
        yield 'data authenticator' => [
            'server' => [
                'HTTP_AUTHORIZATION' => 'Bearer '.Token::SAS_DAT_JWT,
                'HTTP_X_VERSION' => 24,
                'CONTENT_TYPE' => 'application/json',
            ],
        ];
    }
}
