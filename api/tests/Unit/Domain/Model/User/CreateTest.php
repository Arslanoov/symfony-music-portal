<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use DateTimeImmutable;
use Domain\Model\User\Age;
use Domain\Model\User\Email;
use Domain\Model\User\Id;
use Domain\Model\User\Login;
use Domain\Model\User\Name;
use Domain\Model\User\Password;
use Domain\Model\User\User;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\User
 */
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
            $email = new Email($value = 'test@app.test'),
            $age = new Age(20),
            $password = new Password('secret')
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($id->getValue(), $user->getId()->getValue());
        $this->assertNotEmpty($user->getCreatedAtDate());
        $this->assertInstanceOf(DateTimeImmutable::class, $user->getCreatedAtDate());
        $this->assertSame($email->getValue(), $user->getEmail()->getValue());
        $this->assertSame($name, $user->getName());
        $this->assertSame($firstName, $user->getName()->getFirstName());
        $this->assertSame($lastName, $user->getName()->getLastName());
        $this->assertSame($login, $user->getLogin());
        $this->assertSame($age, $user->getAge());
        $this->assertSame($password, $user->getPassword());
    }
}