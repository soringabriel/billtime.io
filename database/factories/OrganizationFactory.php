<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class OrganizationFactory.
 */
class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->company,
            'tax_number' => $this->faker->asciify('********'),,
            'vat_number' => $this->faker->asciify('********'),,
            'address' => $this->faker->address,
            'bank_name' => $this->faker->asciify('********'),
            'bank_account' => $this->faker->asciify('********'),
        ];
    }
}
