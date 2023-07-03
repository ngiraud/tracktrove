<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        $nico = User::where('email', 'contact@ngiraud.me')->first();
        $john = User::where('email', 'john@example.com')->first();

        $nico->library()->firstOrCreate(['name' => "Nico's library"]);
        $john->library()->firstOrCreate(['name' => "John's library"]);

        foreach (range(1, 10) as $range) {
            Album::factory()->count(random_int(10, 20))
                 ->hasAttached($genres->random(random_int(1, 4)))
                 ->hasAttached($nico->refresh()->library)
                 ->create();
        }

        foreach (range(1, 10) as $range) {
            Album::factory()->count(random_int(10, 20))
                 ->hasAttached($genres->random(random_int(1, 4)))
                 ->hasAttached($john->refresh()->library)
                 ->create();
        }
    }
}
