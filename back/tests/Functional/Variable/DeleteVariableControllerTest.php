<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Template;

use Doctrine\Common\Collections\Collection;
use Emailing\Entity\EmailEventVariable;
use Emailing\Tests\Functional\AbstractWebTestCase;

class DeleteVariableControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testDelete($server): void
    {
        $client = static::createClient();
        $repository = $this->entityManager->getRepository(EmailEventVariable::class);

        /** @var Collection $variables */
        $variables = $repository->findAll();

        $client->request('DELETE', '/api/email-variables/'.$variables[0]->getId()->toString(),
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
    }
}
