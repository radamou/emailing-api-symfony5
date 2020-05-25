<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Event;

use Emailing\Entity\EmailEvent;
use Emailing\Tests\Functional\AbstractWebTestCase;

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
