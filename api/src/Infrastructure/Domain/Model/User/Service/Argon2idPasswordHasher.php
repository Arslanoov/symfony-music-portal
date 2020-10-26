<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\User\Service;

use Domain\Model\User\Service\PasswordHasher;
use RuntimeException;

final class Argon2idPasswordHasher implements PasswordHasher
{
    public function hash(string $password, array $options = []): string
    {
        /** @var string|false|null $hash */
        $hash = password_hash($password, PASSWORD_ARGON2ID, $options);
        if (false === $hash || null === $hash) {
            throw new RuntimeException('Can\'t generate hash.');
        }

        return $hash;
    }
}
