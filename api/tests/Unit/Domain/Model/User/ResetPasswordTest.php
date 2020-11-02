<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use DateInterval;
use DateTimeImmutable;
use Domain\Model\User\ConfirmToken;
use Domain\Model\User\Exception\IncorrectToken;
use Domain\Model\User\Exception\TokenExpired;
use Domain\Model\User\Password;
use PHPUnit\Framework\TestCase;
use Test\Builder\UserBuilder;

class ResetPasswordTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->build();

        $confirmToken = new ConfirmToken(
            'secret',
            (new DateTimeImmutable())->add(new DateInterval('PT1H'))
        );

        $this->assertFalse($user->hasRequestedPasswordReset());

        $user->requestPasswordReset($confirmToken);

        $this->assertTrue($user->hasRequestedPasswordReset());

        $newPassword = new Password('new-password');

        $this->assertFalse($user->getPassword()->isEqual($newPassword));
        $this->assertNotNull($user->getResetPasswordConfirmToken());

        $user->confirmPasswordReset(new ConfirmToken(
            'secret',
            new DateTimeImmutable()
        ), $newPassword);

        $this->assertTrue($user->getPassword()->isEqual($newPassword));
        $this->assertNull($user->getResetPasswordConfirmToken());
    }

    public function testIncorrect(): void
    {
        $user = (new UserBuilder())->build();

        $user->requestPasswordReset(new ConfirmToken(
            'secret',
            (new DateTimeImmutable())->add(new DateInterval('PT1H'))
        ));

        $newPassword = new Password('new-password');

        $incorrectToken = new ConfirmToken(
            'incorrect',
            new DateTimeImmutable()
        );

        $this->expectException(IncorrectToken::class);
        $this->expectExceptionMessage('Incorrect token.');

        $user->confirmPasswordReset($incorrectToken, $newPassword);
    }

    public function testExpired(): void
    {
        $user = (new UserBuilder())->build();

        $user->requestPasswordReset(new ConfirmToken(
            'secret',
            new DateTimeImmutable()
        ));

        $newPassword = new Password('new-password');

        $expiredToken = new ConfirmToken(
            'secret',
            (new DateTimeImmutable())->add(new DateInterval('PT1H'))
        );

        $this->expectException(TokenExpired::class);
        $this->expectExceptionMessage('Token is expired.');

        $user->confirmPasswordReset($expiredToken, $newPassword);
    }
}