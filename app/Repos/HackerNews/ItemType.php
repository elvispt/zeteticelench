<?php

namespace App\Repos\HackerNews;

use ReflectionClass;

abstract class ItemType
{
    public const JOB = 'job';
    public const STORY = 'story';
    public const COMMENT = 'comment';
    public const POLL = 'poll';
    public const POLLOPT = 'pollopt';

    public static function all()
    {
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
