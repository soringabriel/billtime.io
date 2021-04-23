<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class NewPermissionsSeeder.
 */
class NewPermissionsSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $times = Permission::create([
            'type' => User::TYPE_USER,
            'name' => 'user.access.times',
            'description' => 'Times Permissions',
        ]);

        $times->children()->saveMany([
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.times.show-all',
                'description' => 'Can View All Subusers Times',
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.times.edit-all',
                'description' => 'Can Edit All Subusers Times',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.times.delete-all',
                'description' => 'Can Delete All Subusers Times',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.times.automatic-time',
                'description' => 'Can Use Automatic Time',
                'sort' => 4,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.times.export',
                'description' => 'Can Export Times',
                'sort' => 5,
            ]),
        ]);

        $invoices = Permission::create([
            'type' => User::TYPE_USER,
            'name' => 'user.access.invoices',
            'description' => 'Invoices Permissions',
        ]);

        $invoices->children()->saveMany([
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.invoices.show',
                'description' => 'Can View Invoices',
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.invoices.create',
                'description' => 'Can Create Invoices',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.invoices.edit',
                'description' => 'Can Edit Invoices',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.invoices.delete',
                'description' => 'Can Delete Invoices',
                'sort' => 4,
            ]),
        ]);

        $clients = Permission::create([
            'type' => User::TYPE_USER,
            'name' => 'user.access.clients',
            'description' => 'Clients Permissions',
        ]);

        $clients->children()->saveMany([
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.clients.show',
                'description' => 'Can View Clients',
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.clients.create',
                'description' => 'Can Create Clients',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.clients.edit',
                'description' => 'Can Edit Clients',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.clients.delete',
                'description' => 'Can Delete Clients',
                'sort' => 4,
            ]),
        ]);

        $projects = Permission::create([
            'type' => User::TYPE_USER,
            'name' => 'user.access.projects',
            'description' => 'Projects Permissions',
        ]);

        $projects->children()->saveMany([
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.projects.show',
                'description' => 'Can View Projects',
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.projects.create',
                'description' => 'Can Create Projects',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.projects.edit',
                'description' => 'Can Edit Projects',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.projects.delete',
                'description' => 'Can Delete Projects',
                'sort' => 4,
            ]),
        ]);

        $subusers = Permission::create([
            'type' => User::TYPE_USER,
            'name' => 'user.access.users',
            'description' => 'Users Permissions',
        ]);

        $subusers->children()->saveMany([
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.users.show',
                'description' => 'Can View Users',
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.users.create',
                'description' => 'Can Create Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.users.edit',
                'description' => 'Can Edit Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => User::TYPE_USER,
                'name' => 'user.access.users.delete',
                'description' => 'Can Delete Users',
                'sort' => 4,
            ]),
        ]);

        $this->enableForeignKeys();
    }
}
