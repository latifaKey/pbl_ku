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
        Schema::table('realisasis', function (Blueprint $table) {
            $table->integer('approval_level')->default(0)->after('diverifikasi');
            $table->boolean('disetujui_pic')->default(false)->after('approval_level');
            $table->unsignedBigInteger('disetujui_pic_oleh')->nullable()->after('disetujui_pic');
            $table->timestamp('disetujui_pic_pada')->nullable()->after('disetujui_pic_oleh');
            $table->boolean('disetujui_manager')->default(false)->after('disetujui_pic_pada');
            $table->unsignedBigInteger('disetujui_manager_oleh')->nullable()->after('disetujui_manager');
            $table->timestamp('disetujui_manager_pada')->nullable()->after('disetujui_manager_oleh');

            // Foreign keys
            $table->foreign('disetujui_pic_oleh')->references('id')->on('users')->onDelete('set null');
            $table->foreign('disetujui_manager_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('realisasis', function (Blueprint $table) {
            $table->dropForeign(['disetujui_pic_oleh']);
            $table->dropForeign(['disetujui_manager_oleh']);

            $table->dropColumn([
                'approval_level',
                'disetujui_pic',
                'disetujui_pic_oleh',
                'disetujui_pic_pada',
                'disetujui_manager',
                'disetujui_manager_oleh',
                'disetujui_manager_pada'
            ]);
        });
    }
};
