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
        Schema::create('realisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indikator_id')->constrained('indikators')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users'); // User yang menginput (admin/master admin)
            $table->date('tanggal'); // Inputan harian
            $table->decimal('nilai', 8, 2); // Nilai realisasi KPI
            $table->decimal('persentase', 5, 2); // Persentase pencapaian
            $table->text('keterangan')->nullable(); // Catatan tambahan
            $table->boolean('diverifikasi')->default(false); // Status verifikasi
            $table->foreignId('verifikasi_oleh')->nullable()->constrained('users'); // User yang memverifikasi
            $table->timestamp('verifikasi_pada')->nullable(); // Waktu verifikasi
            $table->timestamps();

            // Mencegah duplikasi input harian per indikator
            $table->unique(['indikator_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasis');
    }
};
