<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use SymplBundle\Emailing\Entity\EmailTemplate;

class EmailTemplateFixture extends Fixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $emailTemplate = (new EmailTemplate())
            ->setLanguage('en')
            ->setBody('This is the body that need to be updated')
            ->setTitle('email template fixture');

        $manager->persist($emailTemplate);
        $manager->flush();
    }
}
