<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\User;

use Domain\Model\User\Id;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class IdTest
 * @package Test\Unit\Domain\Model\User
 * @covers \Domain\Model\User\Id
 */
class IdTest extends TestCase
{
    public function testCreateSuccess(): void
    {
        $id = new Id(Uuid::uuid4()->toString());

        $this->assertInstanceOf(Id::class, $id);
        $this->assertNotEmpty($id->getValue());

        $this->assertTrue($id->isEqualTo($id));
        $this->assertSame($id->getValue(), (string) $id);
    }

    public function testAsUuid4Success(): void
    {
        $id = Id::asUuid4();

        $this->assertInstanceOf(Id::class, $id);
        $this->assertNotEmpty($id->getValue());

        $this->assertTrue($id->isEqualTo($id));
    }

    public function testNotUuid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User id should be uuid.');

        new Id('not uuid');
    }
}