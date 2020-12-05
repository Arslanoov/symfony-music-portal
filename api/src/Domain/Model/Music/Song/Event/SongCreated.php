<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\Event;

final class SongCreated
{
    public string $id;
    public string $artistId;
    public string $name;

    public function __construct(string $id, string $artistId, string $name)
    {
        $this->id = $id;
        $this->artistId = $artistId;
        $this->name = $name;
    }
}
