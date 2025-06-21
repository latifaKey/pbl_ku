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
        // Tabel 'users' dengan kolom tambahan untuk role
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama user
            $table->string('email')->unique(); // Email yang unik
            $table->timestamp('email_verified_at')->nullable(); // Verifikasi email
            $table->string('password'); // Password untuk login
            $table->string('role')->default('karyawan'); // Kolom untuk role, default karyawan
            $table->rememberToken(); // Untuk "remember me"
            $table->timestamps(); // Timestamp untuk created_at dan updated_at
        });

        // Tabel 'password_reset_tokens' untuk reset password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Primary key dengan email
            $table->string('token'); // Token untuk reset password
            $table->timestamp('created_at')->nullable(); // Waktu token dibuat
        });

        // Tabel 'sessions' untuk menyimpan session pengguna
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID session
            $table->foreignId('user_id')->nullable()->index(); // Relasi dengan tabel 'users'
            $table->string('ip_address', 45)->nullable(); // IP address pengguna
            $table->text('user_agent')->nullable(); // User agent (browser, OS, dll)
            $table->longText('payload'); // Payload untuk session data
            $table->integer('last_activity')->index(); // Waktu aktivitas terakhir
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel yang sudah dibuat
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
