<?php

declare(strict_types=1);

namespace Domain\Model\User;

use Webmozart\Assert\Assert;

final class Role
{
    private const ROLE_USER = 'User';
    private const ROLE_MODERATOR = 'Moderator';
    private const ROLE_ADMIN = 'Admin';

    private const ROLES_LIST = [
        self::ROLE_USER,
        self::ROLE_MODERATOR,
        self::ROLE_ADMIN
    ];

    private string $value;

    /**
     * Role constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'User role required.');
        Assert::oneOf($value, self::ROLES_LIST, 'Incorrect user role.');
        $this->value = $value;
    }

    public static function user(): self
    {
        return new self(self::ROLE_USER);
    }

    public static function moderator(): self
    {
        return new self(self::ROLE_MODERATOR);
    }

    public static function admin(): self
    {
        return new self(self::ROLE_ADMIN);
    }

    public function isUser(): bool
    {
        return $this->getValue() === self::ROLE_USER;
    }

    public function isModerator(): bool
    {
        return $this->getValue() === self::ROLE_MODERATOR;
    }

    public function isAdmin(): bool
    {
        return $this->getValue() === self::ROLE_ADMIN;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(Role $role): bool
    {
        return $this->getValue() === $role->getValue();
    }
}
