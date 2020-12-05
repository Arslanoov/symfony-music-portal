<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\ChangeName;

use App\Domain\Model\Music\Song\SongRepository;
use Domain\Model\Flusher;
use Domain\Model\Music\Song\Id;
use Domain\Model\Music\Song\Name;

final class Handler
{
    private SongRepository $songs;
    private Flusher $flusher;

    public function __construct(SongRepository $songs, Flusher $flusher)
    {
        $this->songs = $songs;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $song = $this->songs->getById(new Id($command->id));

        $song->changeName(new Name($command->newName));

        $this->flusher->flush();
    }
}
