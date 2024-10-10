<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Inspeksi;
use Carbon\Carbon;

class InspeksiFactory extends Factory
{
    protected $model = Inspeksi::class;

    public function definition()
    {
        return [
            'jumlah_pothole' => $this->faker->numberBetween(10, 100),
            'tanggal_inspeksi' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'video_url' => $this->faker->url,
            'area' => $this->faker->randomElement(['Jagorawi', 'JORR', 'Cikampek']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

