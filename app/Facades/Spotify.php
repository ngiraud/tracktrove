<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Spotify\SingleObjects\Search search(string $q, string|array $type, array $payload = [])
 * @method static \Spotify\Resources\Albums albums()
 * @method static \Spotify\Resources\Genres genres()
 *
 * @see \Spotify\Client
 */
class Spotify extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'spotify';
    }
}
