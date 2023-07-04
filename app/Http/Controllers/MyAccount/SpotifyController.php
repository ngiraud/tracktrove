<?php

namespace App\Http\Controllers\MyAccount;

use App\Facades\Spotify;
use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    public function search(Request $request): RedirectResponse
    {
        $request->validateWithBag('spotifySearch', [
            'name' => ['required', 'min:3'],
        ]);

        $search = Spotify::search($request->input('name'), 'album');

        $request->session()->put('spotify.albums', $search->albums()->results());

        return redirect()->back();
    }

    public function store(Request $request, string $id): RedirectResponse
    {
        if (is_null($album = Album::where('spotify_id', $id)->first())) {
            $album = Album::createFromSpotify(Spotify::albums()->find($id));
        }

        $request->user()->library->albums()->attach($album->id);

        return redirect()->route('myaccount.albums.edit', $album);
    }
}
