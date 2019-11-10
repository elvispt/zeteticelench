<?php

namespace App\Repos\Tags;

class TagType
{
    public const NOTE = 'NOTE';
    public const EXPENSE = 'EXPENSE';

    public static function all(): array
    {
        return [
            self::NOTE,
            self::EXPENSE,
        ];
    }
}
