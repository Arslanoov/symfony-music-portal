<?php

declare(strict_types=1);

namespace Domain\Model\User\Exception;

use Domain\Model\DomainException;
use Throwable;

final class IncorrectToken extends DomainException
{
    public function __construct($message = "Incorrect token.", $code = 419, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
