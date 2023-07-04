<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Spotify\Client;

class BindSpotifyServiceToAuthenticatedUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event): void
    {
        app()->singleton('spotify', function () use ($event) {
            if (is_null($token = $event->user?->spotify_token)) {
                $token = 'invalid-token';
            }

            return new Client($token);
        });
    }
}
