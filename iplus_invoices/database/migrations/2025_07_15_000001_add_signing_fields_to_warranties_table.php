<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('warranties', function (Blueprint $table) {
            $table->string('uuid')->unique()->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->string('signed_ip')->nullable();
            $table->string('signed_phone')->nullable();
            $table->string('signed_name')->nullable();
            $table->string('signed_surname')->nullable();
            $table->boolean('is_signed')->default(false);
        });
    }

    public function down()
    {
        Schema::table('warranties', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'signed_at', 'signed_ip', 'signed_phone', 'is_signed']);
        });
    }
};
