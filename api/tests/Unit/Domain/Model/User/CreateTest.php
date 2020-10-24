<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use App\Domain\Model\User\Email;
use App\Domain\Model\User\Id;
use App\Domain\Model\User\User;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = User::signUpByEmail(
            $id = Id::asUuid4(),
            $email = new Email($value = 'test@app.test')
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($id->getValue(), $user->getId()->getValue());
        $this->assertEquals($email->getValue(), $user->getEmail()->getValue());
    }
}