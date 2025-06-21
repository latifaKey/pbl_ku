<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pilar;

class PilarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pilars = [
            [
                'kode' => 'A',
                'nama' => 'Nilai Ekonomi dan Sosial',
                'deskripsi' => 'Fokus pada aspek ekonomi dan sosial organisasi',
                'urutan' => 1,
            ],
            [
                'kode' => 'B',
                'nama' => 'Inovasi Model Bisnis',
                'deskripsi' => 'Fokus pada pengembangan dan inovasi bisnis',
                'urutan' => 2,
            ],
            [
                'kode' => 'C',
                'nama' => 'Kepemimpinan Teknologi',
                'deskripsi' => 'Fokus pada aspek teknologi dan digitalisasi',
                'urutan' => 3,
            ],
            [
                'kode' => 'D',
                'nama' => 'Peningkatan Investasi',
                'deskripsi' => 'Fokus pada aspek investasi dan realisasi capex',
                'urutan' => 4,
            ],
            [
                'kode' => 'E',
                'nama' => 'Pengembangan Talenta',
                'deskripsi' => 'Fokus pada aspek human capital dan talent management',
                'urutan' => 5,
            ],
            [
                'kode' => 'F',
                'nama' => 'Kepatuhan',
                'deskripsi' => 'Fokus pada aspek kepatuhan, hukum, dan tata kelola',
                'urutan' => 6,
            ],
        ];

        foreach ($pilars as $pilar) {
            Pilar::create($pilar);
        }
    }
}
