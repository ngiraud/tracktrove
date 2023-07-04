<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Library extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Library $library) {
            $library->albums()->detach();
        });

        static::saving(function (Library $library) {
            if (!$library->is_public) {
                $library->followers()->detach();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class, 'library_has_albums');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follow_library_user', 'library_id');
    }

    public function scopePublic(Builder $query): void
    {
        $query->where('is_public', true);
    }

    public function scopeFiltered(Builder $query, Request $request): void
    {
        $query
            ->when(!empty($q = $request->get('q')), function (Builder $query) use ($q) {
                return $query->where(function (Builder $query) use ($q) {
                    return $query->where('name', 'LIKE', "%{$q}%")
                                 ->orWhere('description', 'LIKE', "%{$q}%");
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
                        !empty($status = Arr::get($filters, 'status')),
                        fn(Builder $query) => match ($status) {
                            'only-followed' => $query->whereHas('followers', fn(Builder $query) => $query->where('user_id', $request->user()->id)),
                            'except-followed' => $query->whereDoesntHave('followers', fn(Builder $query) => $query->where('user_id', $request->user()->id)),
                            default => $query,
                        },
                    )
            );
    }
}
