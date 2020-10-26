<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Role;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $role = Role::user();

        $this->assertTrue($role->isUser());
        $this->assertFalse($role->isModerator());
        $this->assertFalse($role->isAdmin());
        $this->assertTrue($role->isEqualTo($role));

        $role = Role::moderator();

        $this->assertTrue($role->isModerator());
        $this->assertFalse($role->isUser());
        $this->assertFalse($role->isAdmin());

        $role = Role::admin();

        $this->assertTrue($role->isAdmin());
        $this->assertFalse($role->isModerator());
        $this->assertFalse($role->isUser());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User role required.');

        new Role('');
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Incorrect user role.');

        new Role('incorrect');
    }
}
