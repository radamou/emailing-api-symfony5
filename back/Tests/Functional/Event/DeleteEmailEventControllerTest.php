<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Event;

use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Tests\Functional\AbstractWebTestCase;

class DeleteEmailEventControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testDelete($server): void
    {
        $client = static::createClient();
        $emailEventRepository = $this->entityManager->getRepository(EmailEvent::class);
        /** @var EmailEvent $emailEvent */
        $emailEvent = $emailEventRepository->findOneBy(['code' => 'successful.command.delivery']);

        $client->request('DELETE', '/api/email-events/'.$emailEvent->getId()->toString(),
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());

        $this->assertNotNull($response);
    }
}
