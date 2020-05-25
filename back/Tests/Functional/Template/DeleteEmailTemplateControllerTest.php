<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Template;

use Doctrine\Common\Collections\Collection;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Functional\AbstractWebTestCase;

class DeleteEmailTemplateControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testDelete($server): void
    {
        $client = static::createClient();
        $emailTemplateRepository = $this->entityManager->getRepository(EmailTemplate::class);

        /** @var Collection $emailTemplateType */
        $emailTemplateList = $emailTemplateRepository->findAll();

        $client->request('DELETE', '/api/email-templates/'.$emailTemplateList[0]->getId()->toString(),
            [],
            [],
            $server
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
    }
}
