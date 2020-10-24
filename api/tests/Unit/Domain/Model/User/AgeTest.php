<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Age;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class AgeTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\Age
 */
class AgeTest extends TestCase
{
    public function testSuccess(): void
    {
        $age = new Age($value = 17);

        $this->assertSame($value, $age->getValue());
        $this->assertTrue($age->isEqualTo($age));

        $oldAge = new Age(60);

        $this->assertTrue($oldAge->isMoreThan($age));

        $youngAge = new Age(15);

        $this->assertTrue($youngAge->isLessThan($age));
    }

    public function testTooYoung(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User must be older than 11 years');

        new Age(3);
    }
}