<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Music\Song;

use Domain\Model\Music\Song\File;
use Domain\Model\Music\Song\Info;
use Domain\Model\Music\Song\Name;
use Domain\Model\Music\Song\Song;
use PHPUnit\Framework\TestCase;
use Test\Builder\ArtistBuilder;

class ChangeTest extends TestCase
{
    public function testChangeName(): void
    {
        $song = Song::single(
            (new ArtistBuilder())->build(),
            $name = new Name("Old name"),
            new File("/"),
            new Info("1:00", 256, 2010, "mp3")
        );

        $song->changeName($newName = new Name("New name"));

        $this->assertEquals($newName, $song->getName());
    }

    public function testChangeInfo(): void
    {
        $song = Song::single(
            (new ArtistBuilder())->build(),
            new Name("Nname"),
            new File("/"),
            $oldInfo = new Info("1:00", 256, 2010, "mp3")
        );

        $song->changeInfo($newInfo = new Info("2:00", 128, 2012, "alac"));

        $this->assertEquals($newInfo, $song->getInfo());
    }
}
