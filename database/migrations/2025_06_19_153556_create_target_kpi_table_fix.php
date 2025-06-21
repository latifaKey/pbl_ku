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
        if (!Schema::hasTable('target_kpi')) {
            Schema::create('target_kpi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('indikator_id')->constrained('indikators')->onDelete('cascade');
                $table->foreignId('tahun_penilaian_id')->constrained('tahun_penilaians')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // User yang input target
                $table->decimal('target_tahunan', 10, 2); // Target nilai tahunan
                $table->json('target_bulanan')->nullable(); // Target bulanan (JSON array 12 bulan)
                $table->text('keterangan')->nullable(); // Keterangan tambahan
                $table->boolean('disetujui')->default(false); // Status persetujuan
                $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->nullOnDelete(); // User yang menyetujui
                $table->timestamp('disetujui_pada')->nullable(); // Waktu persetujuan
                $table->timestamps();

                // Kombinasi unik untuk mencegah duplikasi data
                $table->unique(['indikator_id', 'tahun_penilaian_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_kpi');
    }
};
