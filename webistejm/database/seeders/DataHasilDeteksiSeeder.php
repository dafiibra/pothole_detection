<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataHasilDeteksi;

class DataHasilDeteksiSeeder extends Seeder
{
    public function run()
    {
        DataHasilDeteksi::factory()->count(200)->create();
    }
}
