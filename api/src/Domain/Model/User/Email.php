<?php

declare(strict_types=1);

namespace Domain\Model\User;

use Webmozart\Assert\Assert;

final class Email
{
    private string $value;

    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::email($value, 'User email must be in email format.');
        Assert::lengthBetween($value, 4, 32, 'User email must be between 4 and 32 chars length');
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(Email $email): bool
    {
        return $this->getValue() === $email->getValue();
    }
}
