<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class ClientFactory.
 */
class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'company_name' => $this->faker->company,
            'tax_number' => $this->faker->asciify('********'),
            'vat_number' =>  $this->faker->asciify('********'),
            'address' =>  $this->faker->address,
        ];
    }
}
