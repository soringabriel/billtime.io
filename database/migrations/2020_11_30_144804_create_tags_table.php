<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('time_has_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('time_id');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags');

            $table->foreign('time_id')
                ->references('id')
                ->on('time');

            $table->primary(['tag_id', 'time_id'], 'time_has_tags_tag_id_time_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_has_tags');
        Schema::dropIfExists('tags');
    }
}
