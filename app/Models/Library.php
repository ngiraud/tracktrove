<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Library extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (Library $library) {
            $library->albums()->delete();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
