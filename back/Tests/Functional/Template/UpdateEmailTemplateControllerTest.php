<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Template;

use Doctrine\Common\Collections\Collection;
use SymplBundle\Emailing\Entity\EmailTemplate;
use SymplBundle\Emailing\Tests\Functional\AbstractWebTestCase;

class UpdateEmailTemplateControllerTest extends AbstractWebTestCase
{
    /** @dataProvider  authenticationDataProvider*/
    public function testUpdate($server)
    {
        $client = static::createClient();
        $emailTemplateRepository = $this->entityManager->getRepository(EmailTemplate::class);

        /** @var Collection $emailTemplateType */
        $emailTemplateList = $emailTemplateRepository->findAll();

        $client->request('PUT', '/api/email-templates/'.$emailTemplateList[0]->getId()->toString(),
            [],
            [],
            $server,
            \json_encode([
                'title' => 'successfully updated',
                'body' => 'Dear Customer, your email template has been successfully updated, Best Regard',
                'language' => 'fr',
            ])
        );

        $clientResponse = $client->getResponse();
        $response = \json_decode($clientResponse->getContent());
        $this->assertNotNull($response);
        $this->assertEquals(
            $response->emailTemplate->title, 'successfully updated'
        );
        $this->assertEquals(
            $response->emailTemplate->body,
            'Dear Customer, your email template has been successfully updated, Best Regard'
        );
    }
}
