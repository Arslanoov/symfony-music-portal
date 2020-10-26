<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\User\Service;

use Domain\Model\User\Service\PasswordHasher;

final class Argon2idPasswordHasher implements PasswordHasher
{
    public function hash(string $password, array $options = []): string
    {
        return password_hash($password, PASSWORD_ARGON2ID, $options);
    }
}
