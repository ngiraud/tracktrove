<?php

namespace App\Enums;

use Illuminate\Support\Str;
use ValueError;

enum AlbumType: int
{
    case Album = 1;
    case Single = 2;
    case Compilation = 3;

    public static function fromSpotify(string $type): self
    {
        return static::fromName(Str::ucfirst($type));
    }

    public static function fromName(string $name): self
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status;
            }
        }

        throw new ValueError("$name is not a valid backing value for enum ".self::class);
    }
}
