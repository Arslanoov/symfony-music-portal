<?php

declare(strict_types=1);

namespace App\Domain\Model\Music\Song;

use function Symfony\Component\String\s;

final class Type
{
    private const TYPES = [
        self::TYPE_SINGLE,
        self::TYPE_IN_ALBUM
    ];

    private const TYPE_SINGLE = 'Single';
    private const TYPE_IN_ALBUM = 'In album';

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function single(): self
    {
        return new self(self::TYPE_SINGLE);
    }

    public static function inAlbum(): self
    {
        return new self(self::TYPE_IN_ALBUM);
    }

    public function isSingle(): bool
    {
        return $this->getValue() === self::TYPE_SINGLE;
    }

    public function isInAlbum(): bool
    {
        return $this->getValue() === self::TYPE_IN_ALBUM;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Type $type): bool
    {
        return $this->getValue() === $type->getValue();
    }
}
