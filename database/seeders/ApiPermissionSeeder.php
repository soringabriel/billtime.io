<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class ApiPermissionSeeder extends Seeder
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

        $subusers_permissions = Permission::where('name', 'user.access.users')->first();

        $subusers_permissions->children()->saveMany([
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.users.api',
                'description' => 'Has Acces To API',
            ]),
        ]);

        $this->enableForeignKeys();
    }
}
