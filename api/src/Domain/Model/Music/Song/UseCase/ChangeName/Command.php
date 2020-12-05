<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\UseCase\ChangeName;

final class Command
{
    public string $id;
    public string $newName;

    public function __construct(string $id, string $newName)
    {
        $this->id = $id;
        $this->newName = $newName;
    }
}
