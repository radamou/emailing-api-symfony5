<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Tests\Unit\Domain\Security;

use PHPUnit\Framework\TestCase;
use SymplBundle\Emailing\Domain\Security\CustomerCompanyAccessControl;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestAdmin;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestCompany;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestUser;
use SymplBundle\Emailing\Tests\Unit\Domain\FakeEntities\TestWarehouseWorker;

class CustomerCompanyAccessControlTest extends TestCase
{
    public function testUserCanView(): void
    {
        $customerAccessControl = new CustomerCompanyAccessControl();
        $AdminUser = new TestAdmin();
        $user = new TestUser();
        $wareHouseWorker = new TestWarehouseWorker();
        $customerCompanyId = 1;

        $this->assertTrue($customerAccessControl->canView($AdminUser));
        $this->assertTrue($customerAccessControl->canView($user));
        $this->assertFalse($customerAccessControl->canView($wareHouseWorker));
    }

    public function testCanEdit(): void
    {
        $customerAccessControl = new CustomerCompanyAccessControl();
        $AdminUser = new TestAdmin();
        $user = new TestUser();
        $customerCompany = (new TestCompany())->setId(1);
        $user->setCompany($customerCompany);

        $this->assertTrue($customerAccessControl->canEdit($AdminUser, $customerCompany->getId()));
        $this->assertTrue($customerAccessControl->canEdit($user, $customerCompany->getId()));
    }
}
