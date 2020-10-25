<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use DateInterval;
use DateTimeImmutable;
use Domain\Model\User\ConfirmToken;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfirmTokenTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\ConfirmToken
 */
class ConfirmTokenTest extends TestCase
{
    public function testSuccess(): void
    {
        $token = new ConfirmToken($value = 'secret', $expires = new DateTimeImmutable());

        $this->assertSame($value, $token->getToken());
        $this->assertSame($expires, $token->getExpireDate());
        $this->assertTrue($token->isExpiredTo((new DateTimeImmutable())->add(new DateInterval('PT1H'))));
        $this->assertFalse($token->isExpiredTo((new DateTimeImmutable())->modify('-1 hour')));
        $this->assertFalse($token->isEmpty());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User confirm token required.');

        new ConfirmToken('', new DateTimeImmutable());
    }
}