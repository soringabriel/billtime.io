<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ExpandTimeDetails extends Migration
{
    public function up(): void
    {
        // SQLite already stores strings as text without enforcing a length limit.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement('ALTER TABLE time MODIFY details TEXT NULL');
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        if (DB::table('time')->whereRaw('CHAR_LENGTH(details) > 255')->exists()) {
            throw new RuntimeException('Cannot shorten time details without losing existing text.');
        }

        DB::statement('ALTER TABLE time MODIFY details VARCHAR(255) NULL');
    }
}
