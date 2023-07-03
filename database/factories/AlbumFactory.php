<?php

namespace Database\Factories;

use App\Enums\AlbumType;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('fr')->sentence,
            'released_at' => fake()->date,
            'type' => fake()->randomElement(AlbumType::cases()),
            'artist_id' => Artist::factory(),
        ];
    }
}
