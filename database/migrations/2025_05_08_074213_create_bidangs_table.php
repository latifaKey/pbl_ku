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
        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');       // Nama bidang
            $table->string('kode', 20)->unique(); // Kode bidang untuk referensi
            $table->string('role_pic');   // Role PIC yang terkait dengan bidang ini
            $table->text('deskripsi')->nullable(); // Deskripsi bidang (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidangs');
    }
};
