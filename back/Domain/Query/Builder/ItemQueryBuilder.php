<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\Query\Builder;

class ItemQueryBuilder
{
    private $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
