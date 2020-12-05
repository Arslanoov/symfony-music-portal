<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Music\Song;

use Domain\Model\Music\Song\File;
use Domain\Model\Music\Song\Info;
use Domain\Model\Music\Song\Name;
use Domain\Model\Music\Song\Song;
use PHPUnit\Framework\TestCase;
use Test\Builder\ArtistBuilder;

class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $song = Song::single(
            (new ArtistBuilder())->build(),
            new Name("Name"),
            new File("/"),
            new Info("1:00", 256, 2010, "mp3")
        );

        $this->assertTrue($song->isDraft());
        $this->assertFalse($song->isInModeration());
        $this->assertFalse($song->isApproved());

        $song->sendToModeration();

        $this->assertTrue($song->isInModeration());
        $this->assertFalse($song->isDraft());
        $this->assertFalse($song->isApproved());

        $song->approve();

        $this->assertTrue($song->isApproved());
        $this->assertFalse($song->isDraft());
        $this->assertFalse($song->isInModeration());
    }
}
