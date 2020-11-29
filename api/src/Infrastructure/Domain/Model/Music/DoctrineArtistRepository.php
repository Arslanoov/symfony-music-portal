<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\Music;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Model\Music\Artist\Artist;
use Domain\Model\Music\Artist\ArtistRepository;

final class DoctrineArtistRepository implements ArtistRepository
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Artist $artist): void
    {
        $this->em->persist($artist);
    }
}
