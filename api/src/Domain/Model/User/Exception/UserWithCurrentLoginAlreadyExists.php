<?php

declare(strict_types=1);

namespace Domain\Model\User\Exception;

use Domain\Model\DomainException;
use Throwable;

final class UserWithCurrentLoginAlreadyExists extends DomainException
{
    public function __construct($message = "User with current login already exists.", $code = 419, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}