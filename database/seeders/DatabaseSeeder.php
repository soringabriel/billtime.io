<?php

namespace Database\Seeders;

use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'activity_log',
            'failed_jobs',
        ]);

        $this->call(AuthSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(NewPermissionsSeeder::class);
        $this->call(PlansSeeder::class);
        $this->call(ApiPermissionSeeder::class);
        $this->call(EmailsSentPermissionSeeder::class);
        $this->call(SchedulePermissionSeeder::class);

        Model::reguard();
    }
}
