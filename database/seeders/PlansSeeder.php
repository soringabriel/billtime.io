<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Permission;
use App\Models\Plan;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PlansSeeder.
 */
class PlansSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $free = Plan::create([
            'name' => 'Free',
            'price' => 0,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_NONE,
            'subusers_quota' => 0,
        ]);

        $free->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
        ]);

        $freelancer = Plan::create([
            'name' => 'Freelancer',
            'price' => 3.99,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 0,
        ]);

        $freelancer_pro->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.invoices')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
        ]);

        $startup = Plan::create([
            'name' => 'Startup',
            'price' => 19.99,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 20,
        ]);

        $startup->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.invoices')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
            Permission::where('name', 'user.access.users')->first()->id,
        ]);

        $company = Plan::create([
            'name' => 'Company',
            'price' => 49.99,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => -1,
        ]);

        $company->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.invoices')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
            Permission::where('name', 'user.access.users')->first()->id,
        ]);

        $this->enableForeignKeys();
    }
}
