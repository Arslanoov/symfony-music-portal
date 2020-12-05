<?php

declare(strict_types=1);

namespace Infrastructure\Doctrine\Types\Music\Song;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Domain\Model\Music\Song\File;

class FileType extends StringType
{
    public const NAME = 'music_artist_file';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof File ? $value->getPath() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new File((string) $value) : null;
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
