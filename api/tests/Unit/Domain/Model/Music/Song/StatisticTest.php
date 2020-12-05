<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Music\Song;

use App\Domain\Model\Music\Song\Type;
use DateTimeImmutable;
use Domain\Model\Music\Song\File;
use Domain\Model\Music\Song\Id;
use Domain\Model\Music\Song\Info;
use Domain\Model\Music\Song\Name;
use Domain\Model\Music\Song\Song;
use Domain\Model\Music\Song\Statistic;
use Domain\Model\Music\Song\Status;
use PHPUnit\Framework\TestCase;
use Test\Builder\ArtistBuilder;

class StatisticTest extends TestCase
{
    public function testClearMonth(): void
    {
        $song = new Song(
            Id::asUuid4(),
            (new ArtistBuilder())->build(),
            new DateTimeImmutable(),
            new Name("Name"),
            new File("/"),
            new Info("1:00", 256, 2010, "mp3"),
            new Statistic(5, 7, 8, 2),
            Status::approved(),
            Type::single()
        );

        $this->assertFalse($song->getStatistic()->isMonthEmpty());

        $song->clearMonthStatistic();

        $this->assertTrue($song->getStatistic()->isMonthEmpty());
    }

    public function testListen(): void
    {
        $song = Song::single(
            (new ArtistBuilder())->build(),
            new Name("Name"),
            new File("/"),
            new Info("1:00", 256, 2010, "mp3")
        );

        $this->assertTrue($song->getStatistic()->isEmpty());

        $song->listen();

        $this->assertFalse($song->getStatistic()->isEmpty());
        $this->assertEquals(1, $song->getStatistic()->getListensCount());
        $this->assertEquals(1, $song->getStatistic()->getMonthListensCount());
    }

    public function testDownload(): void
    {
        $song = Song::single(
            (new ArtistBuilder())->build(),
            new Name("Name"),
            new File("/"),
            new Info("1:00", 256, 2010, "mp3")
        );

        $this->assertTrue($song->getStatistic()->isEmpty());

        $song->download();

        $this->assertFalse($song->getStatistic()->isEmpty());
        $this->assertEquals(1, $song->getStatistic()->getDownloadsCount());
        $this->assertEquals(1, $song->getStatistic()->getMonthDownloadsCount());
    }
}
