<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Login;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class LoginTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\Login
 */
class LoginTest extends TestCase
{
    public function testSuccess(): void
    {
        $login = new Login($value = 'Some_login');

        $this->assertSame($value, $login->getValue());
        $this->assertTrue($login->isEqualTo($login));
    }

    public function testTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User login must be between 4 and 16 chars length.');

        new Login('sh');
    }

    public function testTooLong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User login must be between 4 and 16 chars length.');

        new Login('long_long_long_long_');
    }
}