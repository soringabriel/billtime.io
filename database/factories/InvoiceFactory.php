<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Class InvoiceFactory.
 */
class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->asciify('****'),
            'buyer_company_name' => $this->faker->company,
            'buyer_tax_number' => $this->faker->asciify('********'),
            'buyer_vat_number' => $this->faker->asciify('********'),
            'buyer_address' => $this->faker->address,
            'seller_company_name' => $this->faker->company,
            'seller_tax_number' => $this->faker->asciify('********'),
            'seller_vat_number' => $this->faker->asciify('********'),
            'seller_address' => $this->faker->address,
            'seller_bank_name' => $this->faker->asciify('********'),
            'seller_bank_account' => $this->faker->asciify('********'),
            'services' => '[]',
            'tax' => $this->faker->numberBetween(0, 100),
            'shipping' => $this->faker->randomFloat(2, 1, 100),
            'currency' => $this->faker->currency,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'notes' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'status' => Invoice::STATUS_PENDING,
        ];
    }
}
