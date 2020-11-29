<?php

declare(strict_types=1);

namespace Domain\Model\Music\Artist;

use Webmozart\Assert\Assert;

final class Login
{
    private string $value;

    /**
     * Login constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 4, 16, 'Artist login must be between 4 and 16 chars length.');
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(Login $login): bool
    {
        return $login->getValue() === $this->getValue();
    }
}
