<?php

namespace Emailing\Tests\Functional\Variable;

use Emailing\Tests\Functional\AbstractWebTestCase;

class ListVariablesControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testList($server)
    {
        $client = static::createClient();
        $client->request('GET', '/api/email-variables',
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
    }
}
