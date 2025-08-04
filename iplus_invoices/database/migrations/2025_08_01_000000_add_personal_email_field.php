<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonalEmailField extends Migration
{
    public function up()
    {
        Schema::table('warranties', function (Blueprint $table) {
            $table->string('personal_email')->nullable();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('personal_email')->nullable();
        });
    }

    public function down()
    {
        Schema::table('warranties', function (Blueprint $table) {
            $table->dropColumn('personal_email');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('personal_email');
        });
    }
}
