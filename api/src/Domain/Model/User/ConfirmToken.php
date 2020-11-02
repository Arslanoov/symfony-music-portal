<?php

declare(strict_types=1);

namespace Domain\Model\User;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class ConfirmToken
 * @package Domain\Model\User
 * @ORM\Embeddable()
 */
final class ConfirmToken
{
    /**
     * @var string
     * @ORM\Column(type="string", name="value", nullable=true)
     */
    private string $value;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="expire_date", nullable=true)
     */
    private DateTimeImmutable $expireDate;

    /**
     * ConfirmToken constructor.
     * @param string $value
     * @param DateTimeImmutable $expireDate
     */
    public function __construct(string $value, DateTimeImmutable $expireDate)
    {
        Assert::notEmpty($value, 'User confirm token required.');
        $this->value = $value;
        $this->expireDate = $expireDate;
    }

    public function getToken(): string
    {
        return $this->value;
    }

    public function getExpireDate(): DateTimeImmutable
    {
        return $this->expireDate;
    }

    public function isExpiredTo(DateTimeImmutable $to): bool
    {
        return $this->expireDate <= $to;
    }

    public function isEqualTo(ConfirmToken $token): bool
    {
        return $token->getToken() === $this->getToken();
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }
}
