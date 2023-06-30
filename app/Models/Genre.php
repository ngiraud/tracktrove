<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function albums(): MorphToMany
    {
        return $this->morphedByMany(Album::class, 'model');
    }

    public function artists(): MorphToMany
    {
        return $this->morphedByMany(Artist::class, 'model');
    }
}
