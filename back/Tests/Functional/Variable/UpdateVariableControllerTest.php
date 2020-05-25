<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Template;

use Doctrine\Common\Collections\Collection;
use SymplBundle\Emailing\Entity\EmailEventVariable;
use SymplBundle\Emailing\Tests\Functional\AbstractWebTestCase;

class UpdateVariableControllerTest extends AbstractWebTestCase
{
    /** @dataProvider  authenticationDataProvider*/
    public function testUpdate($server)
    {
        $client = static::createClient();
        $repository = $this->entityManager->getRepository(EmailEventVariable::class);

        /** @var Collection $variables */
        $variables = $repository->findAll();

        $client->request('PUT', '/api/email-variables/'.$variables[0]->getId()->toString(),
            [],
            [],
            $server,
            \json_encode([
                'name' => 'variable.updated.successfully',
                'description' => 'Variable updated successfully',
            ])
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
        $this->assertEquals(
            $response->emailVariable->name, 'variable.updated.successfully'
        );
        $this->assertEquals(
            $response->emailVariable->description,
            'Variable updated successfully'
        );
    }
}
