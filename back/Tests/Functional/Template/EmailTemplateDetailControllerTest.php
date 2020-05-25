<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Template;

use SymplBundle\Emailing\Tests\Functional\AbstractWebTestCase;

class EmailTemplateDetailControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testDetail($server)
    {
        /** @var $client */
        $client = static::createClient();
        $client->request('GET', '/api/email-templates',
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent(), true);

        $client->request('GET', '/api/email-templates/'.$response[0]['id'],
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $responseDetail = \json_decode($clientResponse->getContent());
        $this->assertNotNull($responseDetail);
    }
}
