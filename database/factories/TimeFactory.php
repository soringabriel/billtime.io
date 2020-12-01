<?php

namespace Database\Factories;

use App\Models\Time;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class TimeFactory.
 */
class TimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Time::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_time' => Carbon::instance($this->faker->dateTime())->toDateTimeString(),
            'end_time' => Carbon::instance($this->faker->dateTime())->toDateTimeString(),
            'task' => $this->faker->url,
            'details' =>  $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
