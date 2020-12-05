<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\SendToModeration;

use App\Domain\Model\Music\Song\SongRepository;
use Domain\Model\Flusher;
use Domain\Model\Music\Song\Id;
use Domain\Model\Music\Song\Info;

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

        $song->sendToModeration();

        $this->flusher->flush();
    }
}
