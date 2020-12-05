<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\UploadSingle;

use App\Domain\Model\Music\Song\SongRepository;
use Domain\Model\Flusher;
use Domain\Model\Music\Song\File;
use Domain\Model\Music\Song\Info;
use Domain\Model\Music\Song\Name;
use Domain\Model\Music\Song\Song;

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
        $song = Song::single(
            $command->artist,
            new Name($command->name),
            new File($command->path),
            new Info($command->length, $command->bitrate, $command->year, $command->format)
        );

        $this->songs->add($song);

        $this->flusher->flush();
    }
}
