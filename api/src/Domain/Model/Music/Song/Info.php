<?php

declare(strict_types=1);

namespace Domain\Model\Music\Song;

use Doctrine\ORM\Mapping as ORM;
use Domain\Model\Music\Song\Exception\IncorrectSongLength;
use Webmozart\Assert\Assert;

/**
 * Class Info
 * @package Domain\Model\Music\Song
 * @ORM\Embeddable()
 */
final class Info
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $length;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $bitrate;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $year;
    /**
     * @var string
     * @ORM\Column(type="string", length=6)
     */
    private string $format;

    public function __construct(string $length, int $bitrate, int $year, string $format)
    {
        if (count($pieces = explode(":", $length)) !== 2) {
            throw new IncorrectSongLength();
        }
        $length = ((int) $pieces[0] * 60) + ((int) $pieces[1]);
        Assert::range($length, 15, 600, "Incorrect song length.");
        $this->length = $length;
        Assert::range($bitrate, 96, 5000, "Incorrect song bitrate.");
        $this->bitrate = $bitrate;
        Assert::range($year, 1900, 2100, "Incorrect song year.");
        $this->year = $year;
        Assert::notEmpty($format, "Song format required.");
        Assert::lengthBetween($format, 2, 6, "Song format must be between 2 and 6 chars length.");
        $this->format = $format;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getFormattedLength(): string
    {
        return (floor($this->length / 60) . ":" . ($this->length % 60));
    }

    public function getBitrate(): int
    {
        return $this->bitrate;
    }

    public function getFormattedBitrate(): string
    {
        return $this->bitrate . " kbps";
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function isEqual(Info $info): bool
    {
        return
            $this->getLength() === $info->getLength() &&
            $this->getBitrate() === $info->getBitrate() &&
            $this->getYear() === $info->getYear() &&
            $this->getFormat() === $info->getFormat()
        ;
    }
}
