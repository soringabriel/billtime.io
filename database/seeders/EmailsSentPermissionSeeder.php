<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class EmailsSentPermissionSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $invoices_permissions = Permission::where('name', 'user.access.invoices')->first();

        $invoices_permissions->children()->saveMany([
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.invoices.emails',
                'description' => 'Has Acces To Sending Invoice Emails',
            ]),
        ]);

        $this->enableForeignKeys();
    }
}
