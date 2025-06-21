<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pilar;
use App\Models\Bidang;
use App\Models\Realisasi;
use App\Models\Indikator;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EksporPdfController extends Controller
{
    /**
     * Halaman awal ekspor PDF
     */
    public function index()
    {
        $user = Auth::user();

        // Hanya admin dan master admin yang boleh mengakses
        if (!($user->isAdmin() || $user->isMasterAdmin())) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini.');
        }

        $bidangs = Bidang::all();
        $pilars = Pilar::all();

        return view('eksporPdf.index', compact('bidangs', 'pilars'));
    }

    /**
     * Ekspor laporan KPI keseluruhan
     */
public function eksporKeseluruhan(Request $request)
{
    $user = Auth::user();

    if (!$user->isMasterAdmin()) {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini.');
    }

    // Validasi input tanggal dari tahun & bulan
    $request->validate([
        'tahun' => 'required|integer|min:2020|max:' . date('Y'),
        'bulan' => 'required|integer|min:1|max:12',
    ]);

    $tanggal = Carbon::createFromDate($request->tahun, $request->bulan, 1)->toDateString();
    $tahun = $request->tahun;
    $bulan = $request->bulan;

    $pilars = Pilar::with([
        'indikators' => function ($q) {
            $q->orderBy('kode');
        },
        'indikators.bidang',
        'indikators.realisasis' => function ($q) use ($tanggal) {
            $q->whereDate('tanggal', $tanggal);
        },
        'indikators.targetKPI.tahunPenilaian'
    ])->orderBy('urutan')->get();

    $totalIndikator = 0;
    $tercapai = 0;
    $belumTercapai = 0;

    foreach ($pilars as $pilar) {
        foreach ($pilar->indikators as $indikator) {
            $totalIndikator++;

            $realisasi = $indikator->realisasis->first();
            $targetKPI = $indikator->targetKPI->where('tahunPenilaian.tahun', $tahun)->first();

            $target = $targetKPI?->target_tahunan ?? 0;
            $nilai = $realisasi?->nilai;

            $persentase = ($nilai !== null && $target > 0)
                ? ($nilai / $target) * 100
                : 0;

            // Inject ke objek untuk dipakai di Blade
            $indikator->realisasi_nilai = $nilai;
            $indikator->realisasi_target = $target;
            $indikator->realisasi_persentase = round($persentase, 2);
            $indikator->realisasi_status = match (true) {
                is_null($nilai) => 'Belum Ada Data',
                $persentase >= 100 => 'Tercapai',
                $persentase >= 90 => 'Hampir Tercapai',
                default => 'Belum Tercapai'
            };

            // Hitung ringkasan
            if ($nilai !== null) {
                if ($persentase >= 100) {
                    $tercapai++;
                } else {
                    $belumTercapai++;
                }
            }
        }
    }

    $rataRataPencapaian = $totalIndikator > 
        ? round((($tercapai + $belumTercapai) > 0 ? (($tercapai / ($tercapai + $belumTercapai)) * 100) : 0), 2)
        : 0;

    $data = [
        'title' => 'Laporan KPI Keseluruhan',
        'subtitle' => 'Periode: ' . Carbon::parse($tanggal)->translatedFormat('F Y'),
        'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y H:i'),
        'pilars' => $pilars,
        'tanggal' => $tanggal,
        'totalIndikator' => $totalIndikator,
        'tercapai' => $tercapai,
        'belumTercapai' => $belumTercapai,
        'rataRataPencapaian' => $rataRataPencapaian,
    ];

    $pdf = PDF::loadView('eksporPdf.keseluruhan', $data);
    return $pdf->download("Laporan_KPI_Keseluruhan_{$request->tahun}_{$request->bulan}.pdf");
}



}
