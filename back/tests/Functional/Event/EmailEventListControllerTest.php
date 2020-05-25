<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Event;

use Emailing\Tests\Functional\AbstractWebTestCase;

class EmailEventListControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testList($server)
    {
        $client = static::createClient();
        $client->request('GET', '/api/email-events',
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
