<?php

namespace Database\Seeders;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inspeksi;
use App\Models\DataHasilDeteksi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create a few Inspeksi records
        Inspeksi::factory()->count(10)->create();

        // Create DataHasilDeteksi records referencing the Inspeksi records
        DataHasilDeteksi::factory()->count(50)->create();
    }
}
