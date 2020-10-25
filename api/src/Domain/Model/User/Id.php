<?php

declare(strict_types=1);

namespace Domain\Model\User;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final class Id
{
    private string $value;

    /**
     * Id constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::uuid($value, 'User id should be uuid.');
        $this->value = $value;
    }

    public static function asUuid4(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(Id $id): bool
    {
        return $id->getValue() === $this->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}