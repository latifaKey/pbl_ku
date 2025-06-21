<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Indikator;
use App\Models\Realisasi;
use App\Models\Pilar;
use App\Models\Bidang;
use Carbon\Carbon;

echo "Script perbaikan data dimulai...\n";

// 1. Tandai beberapa indikator sebagai indikator utama
echo "Menandai indikator utama...\n";
$indikators = Indikator::orderBy('id')->take(5)->get();
foreach($indikators as $i => $indikator) {
    $indikator->is_utama = true;
    $indikator->prioritas = 5 - ($i % 5);
    $indikator->save();
    echo "- Indikator {$indikator->kode} ({$indikator->nama}) ditandai sebagai utama dengan prioritas {$indikator->prioritas}\n";
}

// 2. Pastikan semua indikator memiliki data realisasi untuk tahun dan bulan saat ini
echo "\nMemastikan data realisasi tersedia...\n";
$tahun = Carbon::now()->year;
$bulan = Carbon::now()->month;

$indikators = Indikator::where('aktif', true)->get();
$count = 0;

foreach($indikators as $indikator) {
    $realisasi = Realisasi::where('indikator_id', $indikator->id)
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('periode_tipe', 'bulanan')
        ->first();

    if (!$realisasi) {
        try {
            // Buat data realisasi dummy jika belum ada
            $realisasi = new Realisasi();
            $realisasi->indikator_id = $indikator->id;
            $realisasi->user_id = 1; // Admin user
            $realisasi->tanggal = Carbon::now()->format('Y-m-d');
            $realisasi->nilai = rand(70, 100); // Nilai random antara 70-100
            $realisasi->persentase = rand(70, 100); // Persentase random antara 70-100
            $realisasi->keterangan = "Data otomatis dibuat oleh sistem";
            $realisasi->tahun = $tahun;
            $realisasi->bulan = $bulan;
            $realisasi->periode_tipe = 'bulanan';
            $realisasi->diverifikasi = true;
            $realisasi->verifikasi_oleh = 1; // Admin user
            $realisasi->verifikasi_pada = Carbon::now();
            $realisasi->save();

            $count++;
            echo "- Realisasi untuk indikator {$indikator->kode} ({$indikator->nama}) dibuat\n";
        } catch (\Exception $e) {
            echo "Error saat membuat realisasi untuk indikator {$indikator->kode}: " . $e->getMessage() . "\n";
        }
    }
}

echo "\nTotal {$count} data realisasi baru dibuat\n";

// 3. Pastikan semua pilar memiliki urutan
echo "\nMemastikan urutan pilar...\n";
$pilars = Pilar::all();
foreach($pilars as $i => $pilar) {
    if (!$pilar->urutan) {
        $pilar->urutan = $i + 1;
        $pilar->save();
        echo "- Pilar {$pilar->kode} ({$pilar->nama}) diatur urutan ke-{$pilar->urutan}\n";
    }
}

// 4. Buat data realisasi untuk bulan-bulan sebelumnya untuk tren
echo "\nMembuat data historis untuk tren...\n";
$tahunIni = Carbon::now()->year;
$bulanIni = Carbon::now()->month;

// Untuk setiap indikator, buat data realisasi untuk bulan-bulan sebelumnya tahun ini
$indikators = Indikator::where('aktif', true)->get();
$countHistoris = 0;

foreach($indikators as $indikator) {
    for($bulan = 1; $bulan < $bulanIni; $bulan++) {
        $realisasi = Realisasi::where('indikator_id', $indikator->id)
            ->where('tahun', $tahunIni)
            ->where('bulan', $bulan)
            ->where('periode_tipe', 'bulanan')
            ->first();

        if (!$realisasi) {
            try {
                // Buat data realisasi dengan tren naik (semakin baru semakin tinggi)
                $faktorTren = ($bulan / $bulanIni) * 0.8 + 0.2; // 0.2 - 1.0
                $nilaiDasar = rand(60, 90);
                $nilai = $nilaiDasar * $faktorTren;

                $realisasi = new Realisasi();
                $realisasi->indikator_id = $indikator->id;
                $realisasi->user_id = 1; // Admin user
                $realisasi->tanggal = Carbon::create($tahunIni, $bulan, 15)->format('Y-m-d');
                $realisasi->nilai = round($nilai, 2);
                $realisasi->persentase = round($nilai, 2);
                $realisasi->keterangan = "Data historis otomatis dibuat oleh sistem";
                $realisasi->tahun = $tahunIni;
                $realisasi->bulan = $bulan;
                $realisasi->periode_tipe = 'bulanan';
                $realisasi->diverifikasi = true;
                $realisasi->verifikasi_oleh = 1; // Admin user
                $realisasi->verifikasi_pada = Carbon::create($tahunIni, $bulan, 20);
                $realisasi->save();

                $countHistoris++;
            } catch (\Exception $e) {
                echo "Error saat membuat data historis untuk indikator {$indikator->kode}, bulan {$bulan}: " . $e->getMessage() . "\n";
            }
        }
    }
}

echo "\nTotal {$countHistoris} data historis dibuat\n";

echo "\nScript perbaikan data selesai!\n";
