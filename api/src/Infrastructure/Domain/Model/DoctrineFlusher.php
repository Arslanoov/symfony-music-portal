<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Model\Flusher;

final class DoctrineFlusher implements Flusher
{
    private EntityManagerInterface $em;

    /**
     * DoctrineFlusher constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}