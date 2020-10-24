<?php

declare(strict_types=1);

namespace Domain\Model\User\Service;

interface PasswordHasher
{
    public function hash(string $password, array $options = []): string;
}