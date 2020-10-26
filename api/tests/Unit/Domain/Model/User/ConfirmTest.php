<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Age;
use Domain\Model\User\ConfirmToken;
use Domain\Model\User\Email;
use Domain\Model\User\Id;
use Domain\Model\User\Login;
use Domain\Model\User\Name;
use Domain\Model\User\Password;
use Domain\Model\User\User;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = User::signUpByEmail(
            Id::asUuid4(),
            new Name(
                $firstName = 'Vasya',
                $lastName = 'Pupkin'
            ),
            new Login('User login'),
            new Email($value = 'test@app.test'),
            new Age(20),
            new Password('secret'),
            $token = new ConfirmToken('secret', (new \DateTimeImmutable())->add(new \DateInterval('PT1H')))
        );

        $this->assertTrue($user->hasSignUpConfirmToken());
        $this->assertTrue($user->isDraft());
        $this->assertFalse($user->isActive());

        $user->confirmSignUp($token);

        $this->assertFalse($user->hasSignUpConfirmToken());
        $this->assertTrue($user->isActive());
        $this->assertFalse($user->isDraft());
        $this->assertNull($user->getSignUpConfirmToken());
    }
}
