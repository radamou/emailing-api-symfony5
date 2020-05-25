<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Functional\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailEventTemplate;
use SymplBundle\Emailing\Entity\EmailEventVariable;
use SymplBundle\Emailing\Entity\EmailTemplate;

class EmailEventFixture extends Fixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $emailEvent = new EmailEvent();
        $emailEvent->setCode('successful.command.delivery');
        $emailEvent->setDescription('successful command delivery template mail type');

        $emailTemplate = (new EmailTemplate())
            ->setTitle('failed delivery command email')
            ->setBody("Dear Customer, your command has been successfully shipped, \n Best Regard")
            ->setLanguage('en');
        $manager->persist($emailTemplate);

        $emailEventTemplate = (new EmailEventTemplate())
            ->setIsActive(true)
        ->setEmailTemplate($emailTemplate)
        ->setCustomerCompany(null)
        ->setEmailEvent($emailEvent);
        $manager->persist($emailEventTemplate);

        $emailEventTemplates = new ArrayCollection();
        $emailEventTemplates->add($emailEventTemplate);

        $emailEventVariables = new ArrayCollection();
        $emailEventVariables->add(
            (new EmailEventVariable())
            ->setName('sender.name.fixture')
            ->setDescription('email sender name')
            ->setEmailEvent($emailEvent)
        );

        $emailEvent->setEmailEventTemplates($emailEventTemplates);
        $emailEvent->setEmailEventVariables($emailEventVariables);
        $manager->persist($emailEvent);
        $manager->flush();
    }
}
