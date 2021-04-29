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

        $freelancer = Plan::create([
            'name' => 'Freelancer',
            'price' => 0,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_NONE,
            'subusers_quota' => 0,
        ]);

        $freelancer->syncPermissions([
            Permission::where('name', 'user.access.times.access')->first()->id,
            Permission::where('name', 'user.access.times.edit-all')->first()->id, 
            Permission::where('name', 'user.access.times.mark-billed')->first()->id, 
            Permission::where('name', 'user.access.times.delete-all')->first()->id, 
            Permission::where('name', 'user.access.times.access')->first()->id, 
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
        ]);

        $freelancer_pro = Plan::create([
            'name' => 'Freelancer Pro',
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
            'price' => 9.99,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 3,
        ]);

        $startup->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.invoices')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
            Permission::where('name', 'user.access.users')->first()->id,
        ]);

        $small_team = Plan::create([
            'name' => 'Small Team',
            'price' => 24.99,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 10,
        ]);

        $small_team->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.invoices')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
            Permission::where('name', 'user.access.users')->first()->id,
        ]);

        $regular = Plan::create([
            'name' => 'Startup',
            'price' => 49.99,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 50,
        ]);

        $regular->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.invoices')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
            Permission::where('name', 'user.access.users')->first()->id,
        ]);

        $unlimited = Plan::create([
            'name' => 'Unlimited',
            'price' => 9.99,
            'currency' => 'USD',
            'billing_type' => Plan::BILLING_TYPE_MONTHLY,
            'subusers_quota' => 3,
        ]);

        $unlimited->syncPermissions([
            Permission::where('name', 'user.access.times')->first()->id,
            Permission::where('name', 'user.access.invoices')->first()->id,
            Permission::where('name', 'user.access.clients')->first()->id,
            Permission::where('name', 'user.access.projects')->first()->id,
            Permission::where('name', 'user.access.users')->first()->id,
        ]);

        $this->enableForeignKeys();
    }
}
