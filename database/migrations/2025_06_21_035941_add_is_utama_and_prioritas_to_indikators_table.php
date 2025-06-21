<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            $table->boolean('is_utama')->default(false)->after('aktif');
            $table->integer('prioritas')->default(0)->after('is_utama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indikators', function (Blueprint $table) {
            $table->dropColumn('is_utama');
            $table->dropColumn('prioritas');
        });
    }
};
