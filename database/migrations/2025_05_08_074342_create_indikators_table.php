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
        Schema::create('indikators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilar_id')->constrained('pilars')->onDelete('cascade');
            $table->foreignId('bidang_id')->constrained('bidangs'); // Bidang PIC yang bertanggung jawab
            $table->string('kode', 10); // Kode indikator (A1, A2, B1, dst)
            $table->string('nama');     // Nama indikator
            $table->text('deskripsi')->nullable(); // Deskripsi indikator (opsional)
            $table->decimal('bobot', 5, 2)->default(0); // Bobot dalam persentase (%)
            $table->decimal('target', 8, 2)->default(100); // Target nilai (default 100%)
            $table->integer('urutan')->default(0); // Urutan untuk menampilkan indikator
            $table->boolean('aktif')->default(true); // Status indikator aktif/tidak
            $table->timestamps();

            // Kombinasi unik antara pilar dan kode indikator
            $table->unique(['pilar_id', 'kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikators');
    }
};
