<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Email;
use Domain\Model\User\Id;
use Domain\Model\User\Login;
use Domain\Model\User\Name;
use Domain\Model\User\User;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = User::signUpByEmail(
            $id = Id::asUuid4(),
            $name = new Name(
                $firstName = 'Vasya',
                $lastName = 'Pupkin'
            ),
            $login = new Login('User login'),
            $email = new Email($value = 'test@app.test')
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($id->getValue(), $user->getId()->getValue());
        $this->assertSame($email->getValue(), $user->getEmail()->getValue());
        $this->assertSame($name, $user->getName());
        $this->assertSame($firstName, $user->getName()->getFirstName());
        $this->assertSame($lastName, $user->getName()->getLastName());
        $this->assertSame($login, $user->getLogin());
    }
}