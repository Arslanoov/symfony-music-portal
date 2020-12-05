<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Music\Song;

use Domain\Model\Music\Song\File;
use Domain\Model\Music\Song\Info;
use Domain\Model\Music\Song\Name;
use Domain\Model\Music\Song\Song;
use PHPUnit\Framework\TestCase;
use Test\Builder\ArtistBuilder;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $song = Song::single(
            (new ArtistBuilder())->build(),
            $name = new Name("Song name"),
            $file = new File("/song/path"),
            $info = new Info("2:00", 320, 2020, "mp3")
        );

        $this->assertNotEmpty($song->getId());
        $this->assertNotEmpty($song->getUploadedAtDate());
        $this->assertEquals($name, $song->getName());
        $this->assertEquals($file, $song->getFile());
        $this->assertEquals($info, $song->getInfo());
        $this->assertTrue($song->getStatistic()->isEmpty());
    }
}
