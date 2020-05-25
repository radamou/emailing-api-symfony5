<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional;

class EmailEventTemplateListControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testList($server)
    {
        $client = static::createClient();
        $client->request('GET', '/api/email-event-templates',
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
        $this->assertEquals($response[0]->emailTemplate->title, 'failed delivery command email');
        $this->assertContains('Dear Customer, your command has been successfully shipped', $response[0]->emailTemplate->body);
    }
}
