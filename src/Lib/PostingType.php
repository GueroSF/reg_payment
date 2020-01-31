<?php
declare(strict_types=1);

namespace App\Lib;


class PostingType
{
    public const RECEIVED = 1;
    public const SPENT = 2;

    private const AS_TEXT = [
        self::RECEIVED => 'Приход',
        self::SPENT    => 'Расход',
    ];

    public static function typeAsText(int $type): string
    {
        return self::AS_TEXT[$type];
    }

    public static function getAllTypes(): array
    {
        return self::AS_TEXT;
    }
}
