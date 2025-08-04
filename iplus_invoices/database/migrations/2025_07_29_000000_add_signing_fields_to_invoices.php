<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSigningFieldsToInvoices extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('uuid')->unique()->nullable();
            $table->boolean('is_signed')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->string('signed_ip')->nullable();
            $table->string('signed_phone')->nullable();
            $table->string('signed_name')->nullable();
            $table->string('signed_surname')->nullable();
            $table->string('phone_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'is_signed',
                'signed_at',
                'signed_ip',
                'signed_phone',
                'signed_name',
                'signed_surname',
                'phone_number'
            ]);
        });
    }
}
