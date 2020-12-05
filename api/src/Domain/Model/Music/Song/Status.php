<?php

declare(strict_types=1);

namespace Domain\Model\Music\Song;

use Webmozart\Assert\Assert;

final class Status
{
    private const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_IN_MODERATION,
        self::STATUS_APPROVED
    ];

    private const STATUS_DRAFT = 'Draft';
    private const STATUS_IN_MODERATION = 'In moderation';
    private const STATUS_APPROVED = 'Approved';

    private string $value;

    /**
     * Status constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::oneOf($value, self::STATUSES, "Incorrect song status.");
        $this->value = $value;
    }

    public static function draft(): self
    {
        return new self(self::STATUS_DRAFT);
    }

    public static function inModeration(): self
    {
        return new self(self::STATUS_IN_MODERATION);
    }

    public static function approved(): self
    {
        return new self(self::STATUS_APPROVED);
    }

    public function isDraft(): bool
    {
        return $this->getValue() === self::STATUS_DRAFT;
    }

    public function isInModeration(): bool
    {
        return $this->getValue() === self::STATUS_IN_MODERATION;
    }

    public function isApproved(): bool
    {
        return $this->getValue() === self::STATUS_APPROVED;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Status $status): bool
    {
        return $this->getValue() === $status->getValue();
    }
}
