<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Transformers;

use Doctrine\Common\Collections\ArrayCollection;

interface TransformerInterface
{
    public function getItem(object $entity): object;

    public function getCollection(array $collection): ArrayCollection;
}
