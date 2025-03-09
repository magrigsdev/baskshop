<?php

namespace App\Tests\Users\Entity;

use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    public function testUserEntity(): void
    {
        $user = new Users();
        $user->setRoles('admin');
        $this->assertSame('admin', $user->getRoles(), 'Role of user');
    }
}
