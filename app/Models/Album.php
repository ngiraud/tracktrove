<?php

namespace App\Models;

use App\Collections\TracksCollection;
use App\Enums\AlbumType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Spotify\SingleObjects\Track;

class Album extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => AlbumType::class,
        'external_urls' => AsCollection::class,
        'released_at' => 'datetime',
        'tracks' => AsCollection::class.':'.TracksCollection::class,
    ];

    public static function createFromSpotify(\Spotify\SingleObjects\Album $spotifyAlbum): self
    {
        if (is_null($artist = Artist::where('spotify_id', $spotifyAlbum->artists[0]->id)->first())) {
            $artist = Artist::create([
                'spotify_id' => $spotifyAlbum->artists[0]->id,
                'name' => $spotifyAlbum->artists[0]->name,
                'external_urls' => $spotifyAlbum->artists[0]->externalUrls,
            ]);

            if (!empty($spotifyAlbum->artists[0]->genres)) {
                $artist->genres()->attach(Genre::whereIn('slug', $spotifyAlbum->artists[0]->genres)->pluck('id'));
            }
        }

        $album = self::create([
            'spotify_id' => $spotifyAlbum->id,
            'artist_id' => $artist->id,
            'name' => $spotifyAlbum->name,
            'released_at' => match ($spotifyAlbum->releaseDatePrecision) {
                'year' => Carbon::createFromFormat('Y', $spotifyAlbum->releaseDate),
                'month' => Carbon::createFromFormat('Y-m', $spotifyAlbum->releaseDate),
                default => Carbon::parse($spotifyAlbum->releaseDate),
            },
            'type' => AlbumType::fromSpotify($spotifyAlbum->type),
            'tracks' => collect($spotifyAlbum->tracks->results())->map(function (Track $track) {
                return Arr::only($track->toArray(), ['id', 'name', 'disc_number', 'track_number', 'duration_ms']);
            }),
            'external_urls' => $spotifyAlbum->externalUrls,
            'cover' => Arr::get($spotifyAlbum->images, 0)?->url,
        ]);

        if (!empty($spotifyAlbum->genres)) {
            $album->genres()->attach(Genre::whereIn('slug', $spotifyAlbum->genres)->pluck('id'));
        }

        return $album;
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function libraries(): BelongsToMany
    {
        return $this->belongsToMany(Library::class, 'library_has_albums');
    }

    public function genres(): MorphToMany
    {
        return $this->morphToMany(Genre::class, 'model', 'model_has_genres');
    }

    public function scopeFiltered(Builder $query, Request $request): void
    {
        $query
            ->when(!empty($q = $request->get('q')), function (Builder $query) use ($q) {
                return $query->where(function (Builder $query) use ($q) {
                    return $query->where('name', 'LIKE', "%{$q}%")
                                 ->orWhereHas('artist', fn(Builder $query) => $query->where('name', 'LIKE', "%{$q}%"));
                });
            })
            ->when(
                !empty($sort = $request->get('sort')) && !empty($direction = $request->get('direction')),
                fn(Builder $query) => $query->orderBy($sort, $direction),
                fn(Builder $query) => $query->orderBy('name', 'asc')
            )
            ->when(
                !empty($filters = $request->get('filters')),
                fn(Builder $query) => $query
                    ->when(
                        !empty($artist = Arr::get($filters, 'artist')),
                        fn(Builder $query) => $query->where('artist_id', $artist)
                    )
                    ->when(
                        !empty($type = Arr::get($filters, 'type')),
                        fn(Builder $query) => $query->where('type', $type)
                    )
            );
    }
}
