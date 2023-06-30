<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'external_urls' => AsCollection::class,
    ];

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
