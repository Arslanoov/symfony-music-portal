<?php

declare(strict_types=1);

namespace Domain\Model\User;

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
        Assert::lengthBetween($value, 4, 16, 'User login must be between 4 and 16 chars length.');
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(Login $login): bool
    {
        return $login->getValue() === $this->getValue();
    }
}
