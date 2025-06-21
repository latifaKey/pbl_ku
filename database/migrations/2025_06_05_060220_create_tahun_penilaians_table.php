<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_penilaians', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun')->unique();
            $table->string('deskripsi')->nullable();
            $table->enum('tipe_periode', ['tahunan', 'semesteran', 'triwulanan', 'bulanan'])->default('tahunan');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_aktif')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('diupdate_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_penilaians');
    }
};
