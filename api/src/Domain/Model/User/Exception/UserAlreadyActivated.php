<?php

declare(strict_types=1);

namespace Domain\Model\User\Exception;

use Domain\Model\DomainException;
use Throwable;

final class UserAlreadyActivated extends DomainException
{
    public function __construct($message = "User is already activated.", $code = 419, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
