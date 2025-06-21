<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangs = [
            [
                'nama' => 'Bidang Keuangan',
                'kode' => 'KEU',
                'role_pic' => 'pic_keuangan',
                'deskripsi' => 'Bertanggung jawab untuk KPI A1-A3, D1',
            ],
            [
                'nama' => 'Bidang Perencanaan Operasi Pemeliharaan',
                'kode' => 'POP',
                'role_pic' => 'pic_perencanaan_operasi',
                'deskripsi' => 'Bertanggung jawab untuk KPI A4-A6',
            ],
            [
                'nama' => 'Bidang Sekretaris Perusahaan',
                'kode' => 'SEK',
                'role_pic' => 'pic_sekretaris_perusahaan',
                'deskripsi' => 'Bertanggung jawab untuk KPI A7-A8, F1',
            ],
            [
                'nama' => 'Bidang Perencanaan Korporat',
                'kode' => 'PKR',
                'role_pic' => 'pic_perencanaan_korporat',
                'deskripsi' => 'Bertanggung jawab untuk KPI A9, B3, F2',
            ],
            [
                'nama' => 'Bidang Manajemen Risiko',
                'kode' => 'MRK',
                'role_pic' => 'pic_manajemen_risiko',
                'deskripsi' => 'Bertanggung jawab untuk KPI B1',
            ],
            [
                'nama' => 'Bidang Pengembangan Bisnis',
                'kode' => 'PBN',
                'role_pic' => 'pic_pengembangan_bisnis',
                'deskripsi' => 'Bertanggung jawab untuk KPI B2, C1',
            ],
            [
                'nama' => 'Bidang Human Capital',
                'kode' => 'HCM',
                'role_pic' => 'pic_human_capital',
                'deskripsi' => 'Bertanggung jawab untuk KPI E1-E4',
            ],
            [
                'nama' => 'Bidang K3L',
                'kode' => 'K3L',
                'role_pic' => 'pic_k3l',
                'deskripsi' => 'Bertanggung jawab untuk KPI E5',
            ],
        ];

        foreach ($bidangs as $bidang) {
            Bidang::create($bidang);
        }
    }
}
