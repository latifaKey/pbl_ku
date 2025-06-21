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
        // Cek apakah kolom role sudah ada di tabel users
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('karyawan'); // Menambahkan kolom role dengan default 'karyawan'
            });
        }
    }

    public function down()
    {
        // Hanya menghapus kolom jika ada
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role'); // Menghapus kolom role jika migrasi di rollback
            });
        }
    }

};
