<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('buyer_name');
            $table->string('buyer_company_name')->nullable();
            $table->string('buyer_tax_number')->nullable();
            $table->string('buyer_vat_number')->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('seller_name');
            $table->string('seller_company_name')->nullable();
            $table->string('seller_tax_number')->nullable();
            $table->string('seller_vat_number')->nullable();
            $table->string('seller_address')->nullable();
            $table->json('services');
            $table->double('tax');
            $table->string('currency');
            $table->double('price');
            $table->timestamp('date');
            $table->timestamp('due_date')->nullable();
            $table->string('notes')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('invoice_has_times', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('time_id');

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('cascade');

            $table->foreign('time_id')
                ->references('id')
                ->on('time')
                ->onDelete('cascade');

            $table->primary(['invoice_id', 'time_id'], 'invoice_has_times_invoice_id_time_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_has_times');
        Schema::dropIfExists('invoices');
    }
}
