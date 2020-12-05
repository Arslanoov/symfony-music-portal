<?php

declare(strict_types=1);

namespace Domain\Model\Music\Song;

use Webmozart\Assert\Assert;

final class File
{
    private string $path;

    /**
     * File constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        Assert::notEmpty($path, "Song path required.");
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
