<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\Music;

use App\Domain\Model\Music\Song\Exception\SongNotFound;
use App\Domain\Model\Music\Song\SongRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\Model\Music\Song\Id;
use Domain\Model\Music\Song\Song;

final class DoctrineSongRepository implements SongRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        /** @var EntityRepository $repository */
        $repository = $this->em->getRepository(Song::class);
        $this->repository = $repository;
    }

    public function add(Song $song): void
    {
        $this->em->persist($song);
    }

    public function getById(Id $id): Song
    {
       if (!$song = $this->findById($id)) {
           throw new SongNotFound();
       }

       return $song;
    }

    public function findById(Id $id): ?Song
    {
        /** @var Song|null $song */
        $song = $this->repository->find($id->getValue());
        return $song;
    }
}
