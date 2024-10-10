<?php
namespace Database\Factories;

use App\Models\DataHasilDeteksi;
use App\Models\Inspeksi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class DataHasilDeteksiFactory extends Factory
{
    protected $model = DataHasilDeteksi::class;

    public function definition()
    {
        return [
            'image_url' => $this->faker->imageUrl(),
            'latlong' => $this->faker->latitude . ',' . $this->faker->longitude,
            'is_valid' => $this->faker->randomElement(['requested', 'accepted', 'declined']),
            'area' => $this->faker->randomElement(['Jagorawi', 'JORR', 'Cikampek']),
            'validated_by' => $this->faker->name,
            'id_inspeksi' => Inspeksi::factory(), // Use Inspeksi factory
            'repair_progress' => $this->faker->numberBetween(0, 100),
            'fifty_pct_image_url' => $this->faker->imageUrl(),
            'onehud_pct_image_url' => $this->faker->imageUrl(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

