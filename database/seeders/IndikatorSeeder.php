<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Indikator;
use App\Models\Pilar;
use App\Models\Bidang;

class IndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan referensi pilar dan bidang
        $pilarA = Pilar::where('kode', 'A')->first();
        $pilarB = Pilar::where('kode', 'B')->first();
        $pilarC = Pilar::where('kode', 'C')->first();
        $pilarD = Pilar::where('kode', 'D')->first();
        $pilarE = Pilar::where('kode', 'E')->first();
        $pilarF = Pilar::where('kode', 'F')->first();

        $bidangKeu = Bidang::where('kode', 'KEU')->first();
        $bidangPop = Bidang::where('kode', 'POP')->first();
        $bidangSek = Bidang::where('kode', 'SEK')->first();
        $bidangPkr = Bidang::where('kode', 'PKR')->first();
        $bidangMrk = Bidang::where('kode', 'MRK')->first();
        $bidangPbn = Bidang::where('kode', 'PBN')->first();
        $bidangHcm = Bidang::where('kode', 'HCM')->first();
        $bidangK3l = Bidang::where('kode', 'K3L')->first();

        // Indikator untuk Pilar A (Nilai Ekonomi dan Sosial)
        $indikatorsA = [
            // Bidang Keuangan (A1-A3)
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangKeu->id,
                'kode' => 'A1',
                'nama' => 'EBITDA',
                'deskripsi' => 'Earnings Before Interest, Taxes, Depreciation, and Amortization',
                'bobot' => 20,
                'target' => 100,
                'urutan' => 1,
            ],
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangKeu->id,
                'kode' => 'A2',
                'nama' => 'Operating Ratio',
                'deskripsi' => 'Rasio Operasional',
                'bobot' => 15,
                'target' => 100,
                'urutan' => 2,
            ],
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangKeu->id,
                'kode' => 'A3',
                'nama' => 'ROIC',
                'deskripsi' => 'Return on Invested Capital',
                'bobot' => 15,
                'target' => 100,
                'urutan' => 3,
            ],

            // Bidang Perencanaan Operasi (A4-A6)
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangPop->id,
                'kode' => 'A4',
                'nama' => 'Produksi Listrik',
                'deskripsi' => 'Jumlah Produksi Listrik',
                'bobot' => 20,
                'target' => 100,
                'urutan' => 4,
            ],
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangPop->id,
                'kode' => 'A5',
                'nama' => 'EAF',
                'deskripsi' => 'Equivalent Availability Factor',
                'bobot' => 15,
                'target' => 100,
                'urutan' => 5,
            ],
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangPop->id,
                'kode' => 'A6',
                'nama' => 'Efisiensi Thermal',
                'deskripsi' => 'Efisiensi Energi Thermal',
                'bobot' => 10,
                'target' => 100,
                'urutan' => 6,
            ],

            // Bidang Sekretaris Perusahaan (A7-A8)
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangSek->id,
                'kode' => 'A7',
                'nama' => 'CSR Index',
                'deskripsi' => 'Indeks Corporate Social Responsibility',
                'bobot' => 10,
                'target' => 100,
                'urutan' => 7,
            ],
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangSek->id,
                'kode' => 'A8',
                'nama' => 'Kepuasan Pelanggan',
                'deskripsi' => 'Indeks Kepuasan Pelanggan',
                'bobot' => 10,
                'target' => 100,
                'urutan' => 8,
            ],

            // Bidang Perencanaan Korporat (A9)
            [
                'pilar_id' => $pilarA->id,
                'bidang_id' => $bidangPkr->id,
                'kode' => 'A9',
                'nama' => 'Perencanaan Strategis',
                'deskripsi' => 'Implementasi Perencanaan Strategis',
                'bobot' => 15,
                'target' => 100,
                'urutan' => 9,
            ],
        ];

        // Indikator untuk Pilar B (Inovasi Model Bisnis)
        $indikatorsB = [
            // Bidang Manajemen Risiko (B1)
            [
                'pilar_id' => $pilarB->id,
                'bidang_id' => $bidangMrk->id,
                'kode' => 'B1',
                'nama' => 'Manajemen Risiko',
                'deskripsi' => 'Indeks Implementasi Manajemen Risiko',
                'bobot' => 30,
                'target' => 100,
                'urutan' => 1,
            ],

            // Bidang Pengembangan Bisnis (B2)
            [
                'pilar_id' => $pilarB->id,
                'bidang_id' => $bidangPbn->id,
                'kode' => 'B2',
                'nama' => 'Pendapatan luar PLN',
                'deskripsi' => 'Persentase Pendapatan dari luar PLN',
                'bobot' => 40,
                'target' => 100,
                'urutan' => 2,
            ],

            // Bidang Perencanaan Korporat (B3)
            [
                'pilar_id' => $pilarB->id,
                'bidang_id' => $bidangPkr->id,
                'kode' => 'B3',
                'nama' => 'Inovasi',
                'deskripsi' => 'Jumlah Inovasi Bisnis',
                'bobot' => 30,
                'target' => 100,
                'urutan' => 3,
            ],
        ];

        // Indikator untuk Pilar C (Kepemimpinan Teknologi)
        $indikatorsC = [
            // Bidang Pengembangan Bisnis (C1)
            [
                'pilar_id' => $pilarC->id,
                'bidang_id' => $bidangPbn->id,
                'kode' => 'C1',
                'nama' => 'Digitalisasi',
                'deskripsi' => 'Implementasi Digitalisasi Bisnis',
                'bobot' => 100,
                'target' => 100,
                'urutan' => 1,
            ],
        ];

        // Indikator untuk Pilar D (Peningkatan Investasi)
        $indikatorsD = [
            // Bidang Keuangan (D1)
            [
                'pilar_id' => $pilarD->id,
                'bidang_id' => $bidangKeu->id,
                'kode' => 'D1',
                'nama' => 'Capex Realization',
                'deskripsi' => 'Realisasi Capital Expenditure',
                'bobot' => 100,
                'target' => 100,
                'urutan' => 1,
            ],
        ];

        // Indikator untuk Pilar E (Pengembangan Talenta)
        $indikatorsE = [
            //Bidang Human Capital
            [
                'pilar_id' => $pilarE->id,
                'bidang_id' => $bidangHcm->id,
                'kode' => 'E1',
                'nama' => 'Rasio Talent Milenial',
                'deskripsi' => 'Persentase tenaga kerja milenial terhadap total tenaga kerja di organisasi.',
                'bobot' => 20,
                'target' => 100,
                'urutan' => 1,
            ],
            [
                'pilar_id' => $pilarE->id,
                'bidang_id' => $bidangHcm->id,
                'kode' => 'E2',
                'nama' => 'Rasio Talent Perempuan',
                'deskripsi' => 'Persentase tenaga kerja perempuan terhadap total tenaga kerja di organisasi.',
                'bobot' => 20,
                'target' => 100,
                'urutan' => 2,
            ],
            [
                'pilar_id' => $pilarE->id,
                'bidang_id' => $bidangHcm->id,
                'kode' => 'E3',
                'nama' => 'Rasio Pemenuhan Kualifikasi Organ Pengelola Risiko SH/AP',
                'deskripsi' => 'Persentase pemenuhan kualifikasi kompetensi oleh anggota Organ Pengelola Risiko Sumber Daya Manusia (SH) dan Administrasi & Personalia (AP).',
                'bobot' => 20,
                'target' => 100,
                'urutan' => 3,
            ],
            [
                'pilar_id' => $pilarE->id,
                'bidang_id' => $bidangHcm->id,
                'kode' => 'E4',
                'nama' => 'Human Capital Readiness (HCR) & Organizational Capital Readiness (OCR) dan Produktivitas Pegawai',
                'deskripsi' => 'Indeks kesiapan sumber daya manusia (HCR) dan kesiapan modal organisasi (OCR) serta tingkat produktivitas pegawai dalam organisasi.',
                'bobot' => 20,
                'target' => 100,
                'urutan' => 4,
            ],
             // Bidang K3L (E5)
            [
                'pilar_id' => $pilarE->id,
                'bidang_id' => $bidangK3l->id,
                'kode' => 'E5',
                'nama' => 'K3 Index',
                'deskripsi' => 'Indeks Kesehatan dan Keselamatan Kerja',
                'bobot' => 20,
                'target' => 100,
                'urutan' => 5,
            ],
        ];


        // Indikator untuk Pilar F (Kepatuhan)
        $indikatorsF = [
            // Bidang Sekretaris Perusahaan (F1)
            [
                'pilar_id' => $pilarF->id,
                'bidang_id' => $bidangSek->id,
                'kode' => 'F1',
                'nama' => 'GCG Index',
                'deskripsi' => 'Indeks Good Corporate Governance',
                'bobot' => 50,
                'target' => 100,
                'urutan' => 1,
            ],

            // Bidang Perencanaan Korporat (F2)
            [
                'pilar_id' => $pilarF->id,
                'bidang_id' => $bidangPkr->id,
                'kode' => 'F2',
                'nama' => 'Kepatuhan Regulasi',
                'deskripsi' => 'Kepatuhan terhadap Regulasi',
                'bobot' => 50,
                'target' => 100,
                'urutan' => 2,
            ],
        ];

        // Menggabungkan semua indikator
        $indikators = array_merge(
            $indikatorsA,
            $indikatorsB,
            $indikatorsC,
            $indikatorsD,
            $indikatorsE,
            $indikatorsF
        );

        // Menyimpan semua indikator ke database
        foreach ($indikators as $indikator) {
            Indikator::create($indikator);
        }
    }
}
