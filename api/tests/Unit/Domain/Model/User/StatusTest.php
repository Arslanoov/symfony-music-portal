<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class StatusTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\Status
 */
class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $status = Status::draft();

        $this->assertTrue($status->isDraft());
        $this->assertFalse($status->isActive());

        $status = Status::active();

        $this->assertTrue($status->isActive());
        $this->assertFalse($status->isDraft());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User status required.');

        new Status('');
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Incorrect user status.');

        new Status('incorrect');
    }
}