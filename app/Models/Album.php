<?php

namespace App\Models;

use App\Enums\AlbumType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Album extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => AlbumType::class,
        'external_urls' => AsCollection::class,
        'released_at' => 'datetime',
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
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
