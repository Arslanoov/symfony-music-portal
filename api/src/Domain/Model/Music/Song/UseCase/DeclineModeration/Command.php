<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\DeclineModeration;

final class Command
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
