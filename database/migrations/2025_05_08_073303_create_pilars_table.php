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
        Schema::create('pilars', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique(); // Kode pilar (A, B, C, dst)
            $table->string('nama');              // Nama pilar
            $table->text('deskripsi')->nullable(); // Deskripsi pilar (opsional)
            $table->integer('urutan')->default(0); // Urutan untuk menampilkan pilar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilars');
    }
};
