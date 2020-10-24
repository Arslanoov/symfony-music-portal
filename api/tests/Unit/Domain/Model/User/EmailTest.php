<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use App\Domain\Model\User\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailTest
 * @package Test\Unit\Domain\Model\User
 * @covers \App\Domain\Model\User\Email
 */
class EmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $email = new Email($value = 'app@test.app');

        $this->assertEquals($value, $email->getValue());
        $this->assertTrue($email->isEqualTo($email));
    }

    public function testNotEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User email must be in email format.');

        new Email('not an email');
    }
}