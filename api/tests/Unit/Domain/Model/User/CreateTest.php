<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use App\Domain\Model\User\Id;
use App\Domain\Model\User\User;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $id = Id::asUuid4()
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($id->getValue(), $user->getId()->getValue());
    }
}