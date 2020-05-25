<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities;

use SymplBundle\Entity\User\Professional;

class TestUser extends Professional
{
    /** @var TestCompany */
    protected $company;

    public function getCompany(): TestCompany
    {
        return $this->company;
    }

    public function setCompany(\SymplBundle\Entity\CustomerCompany $company = null): self
    {
        $this->company = $company;

        return $this;
    }
}
