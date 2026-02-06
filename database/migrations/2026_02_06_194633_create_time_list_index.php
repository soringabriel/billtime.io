<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTimeListIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement("
            CREATE INDEX idx_time_end_start_desc
            ON time (end_time DESC, start_time DESC)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::statement("
            DROP INDEX idx_time_end_start_desc ON time
        ");
    }
}
