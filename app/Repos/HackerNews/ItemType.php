<?php

namespace App\Repos\HackerNews;

abstract class ItemType
{
    public const JOB = 'job';
    public const STORY = 'story';
    public const COMMENT = 'comment';
    public const POLL = 'poll';
    public const POLLOPT = 'pollopt';

    public static function all()
    {
        return [
            static::COMMENT,
            static::JOB,
            static::POLL,
            static::POLLOPT,
            static::POLLOPT,
        ];
    }
}
