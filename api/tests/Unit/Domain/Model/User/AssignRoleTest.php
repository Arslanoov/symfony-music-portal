<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\DomainException;
use Domain\Model\User\Role;
use PHPUnit\Framework\TestCase;
use Test\Builder\UserBuilder;

class AssignRoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->build();

        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isModerator());
        $this->assertFalse($user->isAdmin());

        $user->assignRole(Role::moderator());

        $this->assertTrue($user->isModerator());
        $this->assertFalse($user->isUser());
        $this->assertFalse($user->isAdmin());

        $user->assignRole(Role::admin());

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isModerator());
        $this->assertFalse($user->isUser());

        $user->fire();

        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isModerator());
        $this->assertFalse($user->isAdmin());

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Role is already assigned.');

        $user->assignRole(Role::user());
    }
}
