<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Types\User;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use Domain\Model\User\Age;

class AgeType extends IntegerType
{
    public const NAME = 'user_user_age';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Age ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Age((int) $value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
