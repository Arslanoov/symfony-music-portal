<?php

declare(strict_types=1);

namespace Domain\Model\Music\Artist;

interface ArtistRepository
{
    public function add(Artist $artist): void;
}
