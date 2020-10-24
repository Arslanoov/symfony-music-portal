<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Password;
use PHPUnit\Framework\TestCase;

/**
 * Class PasswordTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\Password
 */
class PasswordTest extends TestCase
{
    public function testSuccess(): void
    {
        $password = new Password($value = 'value');

        $this->assertEquals($value, $password->getValue());
    }
}