<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Emailing\Domain\Factory\EmailEventDTOFactory;
use Emailing\Domain\Factory\EmailEventTemplateDTOFactory;
use Emailing\Domain\Factory\EmailEventVariableDTOFactory;
use Emailing\Domain\Factory\EmailTemplateDTOFactory;
use Emailing\Domain\Transformers\Transformer;
use Emailing\Domain\Transformers\TransformerInterface;
use Emailing\Entity\EmailEvent;
use Emailing\Entity\EmailEventTemplate;
use Emailing\Entity\EmailEventVariable;
use Emailing\Entity\EmailTemplate;

class TransformerByRepositoryClassFactory
{
    private const TRANSFORMER_FACTORY_MAPPING = [
        EmailEventTemplate::class => EmailEventTemplateDTOFactory::class,
        EmailEvent::class => EmailEventDTOFactory::class,
        EmailTemplate::class => EmailTemplateDTOFactory::class,
        EmailEventVariable::class => EmailEventVariableDTOFactory::class,
    ];

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRepository(string $resource)
    {
        return $this->entityManager->getRepository($resource);
    }

    public function getTransformer(string $resource): TransformerInterface
    {
        if (!isset(self::TRANSFORMER_FACTORY_MAPPING[$resource])) {
            throw new \InvalidArgumentException('resource does not have any corresponding transformer');
        }

        $factory = self::TRANSFORMER_FACTORY_MAPPING[$resource];

        return new  Transformer(new $factory(), $resource);
    }
}
