<?php

namespace Database\Factories;

use App\Models\Livestock;
use Illuminate\Database\Eloquent\Factories\Factory;

class LivestockFactory extends Factory
{
    protected $model = Livestock::class;

    public function definition()
    {
        $total = $this->faker->numberBetween(10, 200);
        $dead = $this->faker->numberBetween(0, 5);
        $sick = $this->faker->numberBetween(0, 10);
        $alive = max(0, $total - $dead - $sick);

        return [
            'type' => $this->faker->randomElement(['cattle', 'goat', 'sheep', 'chicken']),
            'total_count' => $total,
            'alive_count' => $alive,
            'sick_count' => $sick,
            'dead_count' => $dead,
            'recorded_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
