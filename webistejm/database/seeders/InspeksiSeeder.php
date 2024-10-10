<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inspeksi;

class InspeksiSeeder extends Seeder
{
    public function run()
    {
        Inspeksi::factory()->count(50)->create();
    }
}

