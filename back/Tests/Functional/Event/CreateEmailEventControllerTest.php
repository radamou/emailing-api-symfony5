<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Event;

use Doctrine\Common\Collections\Collection;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Functional\AbstractWebTestCase;

class CreateEmailEventControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testCreate($server): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/email-events',
            [],
            [],
            $server,
            \json_encode([
                'code' => 'command.delivery.postpone',
                'description' => 'Postponed command delivery',
                'emailTemplate' => [
                    'title' => 'failed delivery command email',
                    'body' => "Dear Customer, your command has been successfully shipped, \n Best Regard",
                    'language' => 'en',
                ],
                'emailEventVariables' => [
                    [
                        'name' => 'sender.name.test',
                        'description' => 'user sender',
                    ],
                ],
                'isActive' => true,
            ])
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
        $this->assertEquals($response->emailEvent->code, 'command.delivery.postpone');
        $this->assertEquals($response->emailEvent->description, 'Postponed command delivery');
    }

    /** @dataProvider authenticationDataProvider */
    public function testWithExitingDefaultTemplate($server): void
    {
        $client = static::createClient();
        $emailTemplateRepository = $this->entityManager->getRepository(EmailTemplate::class);

        /** @var Collection $emailTemplateType */
        $emailTemplateList = $emailTemplateRepository->findAll();

        $client->request('POST', '/api/email-events',
            [],
            [],
            $server,
            \json_encode([
                'code' => 'command.delivery.professional',
                'description' => 'Postponed command delivery professional',
                'emailTemplate' => [
                    'id' => $emailTemplateList[0]->getId()->toString(),
                ],
                'emailEventVariables' => [
                    [
                        'name' => 'sender.name.professional',
                        'description' => 'user sender professional',
                    ],
                ],
                'isActive' => true,
            ])
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
        $this->assertEquals($response->emailEvent->code, 'command.delivery.professional');
        $this->assertEquals($response->emailEvent->description, 'Postponed command delivery professional');
    }
}
