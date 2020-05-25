<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Template;

use Emailing\Tests\Functional\AbstractWebTestCase;

class VariablesDetailControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testDetail($server)
    {
        /** @var $client */
        $client = static::createClient();
        $client->request('GET', '/api/email-variables',
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent(), true);

        $client->request('GET', '/api/email-variables/'.$response[0]['id'],
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $responseDetail = \json_decode($clientResponse->getContent());
        $this->assertNotNull($responseDetail);
    }
}
