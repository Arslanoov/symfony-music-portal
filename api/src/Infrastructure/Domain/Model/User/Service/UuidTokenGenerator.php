<?php

declare(strict_types=1);

namespace Infrastructure\Domain\Model\User\Service;

use DateInterval;
use DateTimeImmutable;
use Domain\Model\User\ConfirmToken;
use Domain\Model\User\Service\Tokenizer;
use Exception;
use Ramsey\Uuid\Uuid;

final class UuidTokenGenerator implements Tokenizer
{
    private string $expireTime;

    /**
     * UuidTokenGenerator constructor.
     * @param string $expireTime
     */
    public function __construct(string $expireTime)
    {
        $this->expireTime = $expireTime;
    }

    /**
     * @return ConfirmToken
     * @throws Exception
     */
    public function generate(): ConfirmToken
    {
        return new ConfirmToken(
            Uuid::uuid4()->toString(),
            (new DateTimeImmutable())->add(new DateInterval($this->expireTime))
        );
    }
}