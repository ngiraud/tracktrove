<?php

namespace App\Models;

use App\Enums\AlbumType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

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

    public function scopeFiltered(Builder $query, Request $request): void
    {
        $query->when(!empty($q = $request->get('q')), function (Builder $query) use ($q) {
            return $query->where('name', 'LIKE', "%{$q}%")
                         ->orWhereHas('artist', fn(Builder $query) => $query->where('name', 'LIKE', "%{$q}%"));
        });
    }
}
