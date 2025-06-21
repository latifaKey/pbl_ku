<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('aktivitas_logs', function (Blueprint $table) {
            $table->json('data')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('aktivitas_logs', function (Blueprint $table) {
            $table->text('data')->nullable()->change(); // jika sebelumnya text
        });
    }

};
