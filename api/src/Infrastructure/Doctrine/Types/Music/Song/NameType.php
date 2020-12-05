<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Types\Music\Song;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Model\Music\Song\Name;

class NameType extends StringType
{
    public const NAME = 'music_artist_name';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Name ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Name((string) $value) : null;
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
