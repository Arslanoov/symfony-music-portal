<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class NameTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\Name
 */
class NameTest extends TestCase
{
    public function testSuccess(): void
    {
        $name = new Name(
            $firstName = 'Vasya',
            $lastName = 'Pupkin'
        );

        $this->assertSame($firstName, $name->getFirstName());
        $this->assertSame($lastName, $name->getLastName());

        $this->assertTrue($name->isEqualTo($name));
    }

    public function testTooShortFirstName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User first name must be between 2 and 32 chars length.');

        new Name(
            $firstName = 'V',
            $lastName = 'Pupkin'
        );
    }

    public function testTooLongFirstName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User first name must be between 2 and 32 chars length.');

        new Name(
            $firstName = 'VasyaVasyaVasyaVasyaVasyaVasyaVasya',
            $lastName = 'Pupkin'
        );
    }

    public function testTooShortLastName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User last name must be between 2 and 32 chars length.');

        new Name(
            $firstName = 'Vasya',
            $lastName = 'P'
        );
    }

    public function testTooLongLastName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User last name must be between 2 and 32 chars length.');

        new Name(
            $firstName = 'Vasya',
            $lastName = 'PupkinPupkinPupkinPupkinPupkinPupkin'
        );
    }
}