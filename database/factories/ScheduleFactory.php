<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class ScheduleFactory.
 */
class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'period' => Schedule::MONTHLY,
            'schedule_trigger' => 1,
            'price_per_hour' => $this->faker->randomFloat(2, 1, 100),
            'discount' => $this->faker->randomFloat(2, 1, 100),
            'tax' => $this->faker->numberBetween(0, 100),
            'shipping' => $this->faker->randomFloat(2, 1, 100),
            'service_fee' => $this->faker->randomFloat(2, 1, 100),
            'notes' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
