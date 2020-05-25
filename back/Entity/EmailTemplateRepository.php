<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Entity;

use Doctrine\ORM\EntityRepository;

class EmailTemplateRepository extends EntityRepository
{
    private const EMAIL_EVENT_SEARCH = 'emailEvent';

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        if (!isset($criteria[self::EMAIL_EVENT_SEARCH])) {
            return parent::findBy($criteria, $orderBy, $limit, $offset);
        }

        $ids = $this->getEmailTemplatesIdsByEventId($criteria[self::EMAIL_EVENT_SEARCH]);

        $templateQuery = $this->createQueryBuilder('t')
            ->where('t.id in (:data)')
            ->setParameter('data', $ids);

        return $templateQuery->getQuery()->getResult();
    }

    private function getEmailTemplatesIdsByEventId(string $eventEmail): array
    {
        $templateIds = [];
        $dql = '
                SELECT evt
                FROM SymplBundle\Emailing\Entity\EmailEventTemplate evt 
                WHERE evt.emailEvent = :emailEvent';

        $eventEmailTemplates = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('emailEvent', $eventEmail)
            ->getResult();

        /** @var EmailEventTemplate $emailTemplateEvent */
        foreach ($eventEmailTemplates as $emailTemplateEvent) {
            $templateIds[] = $emailTemplateEvent->getEmailTemplate()->getId()->toString();
        }

        return $templateIds;
    }
}
