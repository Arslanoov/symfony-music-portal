<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song\Exception;

use Domain\Model\DomainException;
use Throwable;

final class SongNotFound extends DomainException
{
    public function __construct(string $message = "Song not found.", int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
