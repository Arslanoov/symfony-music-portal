<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\UploadSingle;

use Domain\Model\Music\Artist\Artist;

final class Command
{
    public Artist $artist;
    public string $name;
    public string $path;
    public string $length;
    public int $bitrate;
    public int $year;
    public string $format;

    public function __construct(
        Artist $artist,
        string $name,
        string $path,
        string $length,
        int $bitrate,
        int $year,
        string $format
    ) {
        $this->artist = $artist;
        $this->name = $name;
        $this->path = $path;
        $this->length = $length;
        $this->bitrate = $bitrate;
        $this->year = $year;
        $this->format = $format;
    }
}
