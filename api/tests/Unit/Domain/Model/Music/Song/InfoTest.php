<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Music\Song;

use Domain\Model\Music\Song\Info;
use PHPUnit\Framework\TestCase;

/**
 * Class InfoTest
 * @package Test\Unit\Domain\Model\Music\Song
 * @covers \Domain\Model\Music\Song\Info
 */
class InfoTest extends TestCase
{
    public function testSuccess(): void
    {
        $info = new Info(
            $stringLength = "2:30",
            $bitrate = 256,
            $year = 2018,
            $format = "flac"
        );

        $this->assertEquals(150, $info->getLength());
        $this->assertEquals($stringLength, $info->getFormattedLength());
        $this->assertEquals($bitrate, $info->getBitrate());
        $this->assertEquals($bitrate . " kbps", $info->getFormattedBitrate());
        $this->assertEquals($year, $info->getYear());
        $this->assertTrue($info->isEqual($info));
    }
}
