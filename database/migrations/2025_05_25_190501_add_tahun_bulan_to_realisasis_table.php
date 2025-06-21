<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('realisasis', function (Blueprint $table) {
            $table->integer('tahun')->after('tanggal');
            $table->unsignedTinyInteger('bulan')->after('tahun'); // 1-12
        });
    }

    public function down(): void
    {
        Schema::table('realisasis', function (Blueprint $table) {
            $table->dropColumn(['tahun', 'bulan']);
        });
    }
};
