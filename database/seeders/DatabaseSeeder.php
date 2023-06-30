<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Album;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $genres = collect([
            'Rock',
            'Hard rock',
            'Metal',
            'Rap',
            'Hip-Hop',
        ])->map(fn(string $genre) => Genre::factory()->create(['name' => $genre]));

        $nico = User::factory()->create([
            'name' => 'Nico',
            'email' => 'contact@ngiraud.me',
        ]);

        $john = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $library = $nico->library()->create(['name' => "Nico's library"]);
        $john->library()->create(['name' => "John's library"]);

        foreach (range(1, 10) as $range) {
            Album::factory()->count(random_int(10, 20))->hasAttached($genres->random(random_int(1, 4)))->create(['library_id' => $library->id]);
        }
    }
}
