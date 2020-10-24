<?php

declare(strict_types=1);

namespace Domain\Model\User;

final class Password
{
    private string $value;

    /**
     * Password constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}