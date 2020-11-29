<?php

declare(strict_types=1);

namespace Domain\Model\Music\Artist\UseCase\Create;

use Domain\Model\Music\Artist\Artist;
use Domain\Model\Music\Artist\ArtistRepository;
use Domain\Model\Music\Artist\Id;
use Domain\Model\Music\Artist\Login;
use Domain\Model\Flusher;

final class Handler
{
    private ArtistRepository $artists;
    private Flusher $flusher;

    public function __construct(ArtistRepository $artists, Flusher $flusher)
    {
        $this->artists = $artists;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $artist = new Artist(
            new Id($command->id),
            new Login($command->login)
        );

        $this->artists->add($artist);

        $this->flusher->flush();
    }
}
