<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class PlanFactory.
 */
class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomNumber(),
            'currency' => $this->faker->currencyCode,
            'billing_type' => $this->faker->randomElement(Plan::BILLING_TYPES),
            'subusers_quota' => -1,
            'trial_days' => 14,
        ];
    }
}
