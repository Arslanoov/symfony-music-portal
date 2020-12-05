<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song;

use App\Domain\Model\Music\Song\Exception\SongNotFound;
use Domain\Model\Music\Song\Id;
use Domain\Model\Music\Song\Song;

interface SongRepository
{
    public function add(Song $song): void;

    /**
     * @param Id $id
     * @throws SongNotFound
     * @return Song
     */
    public function getById(Id $id): Song;
}
