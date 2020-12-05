<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\SendToModeration;

final class Command
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
