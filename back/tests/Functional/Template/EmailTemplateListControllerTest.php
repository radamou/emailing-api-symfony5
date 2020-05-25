<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Template;

use Emailing\Tests\Functional\AbstractWebTestCase;

class EmailTemplateListControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testList($server)
    {
        $client = static::createClient();
        $client->request('GET', '/api/email-templates',
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
    }
}
