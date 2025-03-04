<?php

namespace App\Tests\Users\Entity;

use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    public function testUserEntity(): void
    {
        $user = new Users();
        $user->setRoles('customer');
        $this->assertSame('customer', $user->getRoles(), 'Role of user');
    }
}
