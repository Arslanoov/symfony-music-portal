<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\User\Service;

use Domain\Model\User\Service\PasswordValidator;

final class CorePasswordValidator implements PasswordValidator
{
    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
