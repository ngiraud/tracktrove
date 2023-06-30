<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Nico',
            'email' => 'contact@ngiraud.me',
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
