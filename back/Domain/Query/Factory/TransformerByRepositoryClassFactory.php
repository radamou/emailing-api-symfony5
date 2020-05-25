<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Query\Factory;

use Doctrine\ORM\EntityManagerInterface;
use SymplBundle\Emailing\Domain\Factory\EmailEventDTOFactory;
use SymplBundle\Emailing\Domain\Factory\EmailEventTemplateDTOFactory;
use SymplBundle\Emailing\Domain\Factory\EmailEventVariableDTOFactory;
use SymplBundle\Emailing\Domain\Factory\EmailTemplateDTOFactory;
use SymplBundle\Emailing\Domain\Transformers\Transformer;
use SymplBundle\Emailing\Domain\Transformers\TransformerInterface;
use SymplBundle\Emailing\Entity\EmailEvent;
use SymplBundle\Emailing\Entity\EmailEventTemplate;
use SymplBundle\Emailing\Entity\EmailEventVariable;
use SymplBundle\Emailing\Entity\EmailTemplate;

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
