<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('invoice_id');
            $table->integer('is_deghege')->default(0);
            $table->integer('discount_type')->default(0);
            $table->string('device_code')->nullable();
            $table->string('device_artikuli_code')->nullable();
            $table->string('device_name')->nullable();
            $table->decimal('device_price', 10, 2)->nullable();
            $table->decimal('device_discounted_price', 10, 2)->nullable();
            $table->decimal('device_total_price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
