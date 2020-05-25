<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Event;

use Emailing\Entity\EmailEvent;
use Emailing\Tests\Functional\AbstractWebTestCase;

class UpdateEmailEventControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testUpdate($server): void
    {
        $client = static::createClient();
        $emailEventRepository = $this->entityManager->getRepository(EmailEvent::class);
        /** @var EmailEvent $emailEvent */
        $emailEvent = $emailEventRepository->findOneBy(['code' => 'successful.command.delivery']);

        $client->request('PUT', '/api/email-events/'.$emailEvent->getId()->toString(),
            [],
            [],
            $server,
            \json_encode([
                'description' => 'Update for Postponed command delivery',
                'emailTemplate' => [
                    'id' => $emailEvent->getEmailEventTemplates()->first()->getId()->toString(),
                ],
                'emailEventVariables' => [
                    [
                        'name' => 'sender.name.delivery.TIT',
                        'description' => 'user sender delivery update',
                    ],
                ],
                'isActive' => false,
            ])
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());

        $this->assertNotNull($response);
        $this->assertEquals($response->emailEvent->description, 'Update for Postponed command delivery');
    }
}
