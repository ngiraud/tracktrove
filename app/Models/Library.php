<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Library extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (Library $library) {
            $library->albums()->detach();
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
}
