<?php

declare(strict_types=1);

namespace Domain\Model\Music\Song\Exception;

use Domain\Model\DomainException;
use Throwable;

final class IncorrectSongLength extends DomainException
{
    public function __construct(string $message = "Incorrect song length.", int $code = 419, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
