<?php

declare(strict_types=1);

namespace Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class Age
 * @package Domain\Model\User
 * @ORM\Embeddable()
 */
final class Age
{
    private int $value;

    /**
     * Age constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::greaterThan($value, 11, 'User must be older than 11 years old');
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    public function isEqualTo(Age $age): bool
    {
        return $age->getValue() === $this->getValue();
    }

    public function isMoreThan(Age $age): bool
    {
        return $this->getValue() >= $age->getValue();
    }

    public function isLessThan(Age $age): bool
    {
        return $this->getValue() <= $age->getValue();
    }
}
