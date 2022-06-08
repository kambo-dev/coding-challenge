<?php


namespace App\Enums;


use ReflectionClass;

abstract class Enum
{
    public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    public static function toString(string $glue = ','): string
    {
        return implode($glue, self::toArray());
    }
}
