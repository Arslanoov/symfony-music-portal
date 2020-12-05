<?php

declare(strict_types=1);

namespace Domain\Model\Music\Song;

use Webmozart\Assert\Assert;

final class Name
{
    private string $value;

    /**
     * Name constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value, "Song name required.");
        Assert::lengthBetween($value, 2, 32, "Song name must be between 2 and 32 chars length.");
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Name $name): bool
    {
        return $this->getValue() === $name->getValue();
    }
}
