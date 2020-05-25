<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Event;

use Emailing\Entity\EmailEvent;
use Emailing\Tests\Functional\AbstractWebTestCase;

class EmailEventDetailControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testDetail($server)
    {
        $client = static::createClient();
        $emailEventRepository = $this->entityManager->getRepository(EmailEvent::class);
        /** @var EmailEvent $emailEvent */
        $emailEvent = $emailEventRepository->findOneBy(['code' => 'successful.command.delivery']);

        $client->request('GET', '/api/email-events/'.$emailEvent->getId()->toString(),
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
        $this->assertEquals($response[0]->code, 'successful.command.delivery');
        $this->assertEquals($response[0]->description, 'successful command delivery template mail type');
    }
}
