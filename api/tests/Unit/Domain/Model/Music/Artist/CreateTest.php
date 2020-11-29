<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Music\Artist;

use Domain\Model\Music\Artist\Artist;
use Domain\Model\Music\Artist\Id;
use Domain\Model\Music\Artist\Login;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateTest
 * @package Test\Unit\Domain\Model\Music\Artist
 * @covers \Domain\Model\Music\Artist\Artist
 */
class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $artist = new Artist(
            $id = Id::asUuid4(),
            $login = new Login('Some')
        );

        $this->assertEquals($id, $artist->getId());
        $this->assertEquals($login, $artist->getLogin());
    }
}
