<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities;

use SymplBundle\Entity\CustomerCompany;

class TestCompany extends CustomerCompany
{
    protected $id;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
