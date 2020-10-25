<?php

declare(strict_types=1);

namespace Domain\Model\User;

use Webmozart\Assert\Assert;

final class Status
{
    public const STATUS_DRAFT = 'Draft';
    public const STATUS_ACTIVE = 'Active';

    public const STATUS_LIST = [
        self::STATUS_DRAFT,
        self::STATUS_ACTIVE
    ];

    private string $value;

    /**
     * Status constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'User status required.');
        Assert::oneOf($value, self::STATUS_LIST, 'Incorrect user status.');
        $this->value = $value;
    }

    public static function active(): self
    {
        return new self(self::STATUS_ACTIVE);
    }

    public static function draft(): self
    {
        return new self(self::STATUS_DRAFT);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isActive(): bool
    {
        return $this->value === self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->value === self::STATUS_DRAFT;
    }
}