<?php

declare(strict_types=1);

namespace Emailing\Tests\Functional\Template;

use Doctrine\Common\Collections\Collection;
use Emailing\Entity\EmailEvent;
use Emailing\Tests\Functional\AbstractWebTestCase;

class CreateEmailTemplateControllerTest extends AbstractWebTestCase
{
    /** @dataProvider authenticationDataProvider */
    public function testCreate($server): void
    {
        $client = static::createClient();
        $emailTemplateRepository = $this->entityManager->getRepository(EmailEvent::class);

        /** @var Collection $emailTemplateType */
        $emailEventList = $emailTemplateRepository->findAll();
        $client->request('POST', '/api/email-templates',
            [],
            [],
            $server,
            \json_encode([
                'emailEvent' => [
                    'id' => $emailEventList[0]->getId()->toString(),
                    'isActive' => true,
                ],
                'title' => 'successfully shipped command email',
                'body' => 'Dear Customer, your command has been successfully shipped, Best Regard',
                'language' => 'en',
            ])
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
        $this->assertEquals(
            $response->emailTemplate->title, 'successfully shipped command email'
        );
        $this->assertEquals(
            $response->emailTemplate->body,
            'Dear Customer, your command has been successfully shipped, Best Regard'
        );
    }
}
