<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\ChangeInfo;

final class Command
{
    public string $id;
    public string $length;
    public int $bitrate;
    public int $year;
    public string $format;

    public function __construct(string $id, string $length, int $bitrate, int $year, string $format)
    {
        $this->id = $id;
        $this->length = $length;
        $this->bitrate = $bitrate;
        $this->year = $year;
        $this->format = $format;
    }
}
