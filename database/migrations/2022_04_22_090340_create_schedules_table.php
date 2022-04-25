<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Schedule;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('project_id');
            $table->enum('period', Schedule::PERIODS)->default(Schedule::MONTHLY);
            $table->string('schedule_trigger')->default(1);
            $table->double('price_per_hour')->default(0);
            $table->string('price_currency')->default('USD');
            $table->double('discount')->nullable();
            $table->double('tax')->default(0);
            $table->double('shipping')->nullable();
            $table->double('service_fee')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');;
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function($table) {
            $table->dropColumn('schedule_id');
        });

        Schema::dropIfExists('schedules');
    }
}
