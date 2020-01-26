<?php
declare(strict_types=1);

namespace App\Lib;


class PostingType
{
    public const RECEIVED = 1;
    public const SPENT = 2;

    public static function typeAsText(int $type): string
    {
        return self::RECEIVED === $type ? 'Приход' : 'Расход';
    }
}
