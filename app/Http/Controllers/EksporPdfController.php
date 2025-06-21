<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pilar;
use App\Models\Bidang;
use App\Models\Indikator;
use App\Models\Realisasi;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EksporPdfController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!($user->isAdmin() || $user->isMasterAdmin())) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini.');
        }

        $bidangs = Bidang::all();
        $pilars = Pilar::all();

        return view('eksporPdf.index', compact('bidangs', 'pilars'));
    }

public function eksporKeseluruhan(Request $request)
{
    $request->validate([
        'tahun' => 'required|integer|min:2020|max:' . date('Y'),
        'bulan' => 'required|integer|min:1|max:12',
    ]);

    $tahun = $request->tahun;
    $bulan = $request->bulan;
    $tanggal = Carbon::createFromDate($tahun, $bulan, 1);

    // Ambil semua data pilar, indikator, realisasi & target
    $pilars = Pilar::with([
        'indikators' => function ($q) {
            $q->orderBy('kode');
        },
        'indikators.bidang',
        'indikators.realisasis' => function ($q) use ($tahun, $bulan) {
            $q->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan);
        },
        'indikators.targetKPI.tahunPenilaian'
    ])->orderBy('urutan')->get();

    $totalIndikator = 0;
    $tercapai = 0;
    $belumTercapai = 0;

    // Map data menjadi array agar aman untuk Blade/PDF
    $pilars = $pilars->map(function ($pilar) use ($tahun, &$totalIndikator, &$tercapai, &$belumTercapai) {
        $indikators = $pilar->indikators->map(function ($indikator) use ($tahun, &$totalIndikator, &$tercapai, &$belumTercapai) {
            $totalIndikator++;

            $realisasi = $indikator->realisasis->sortByDesc('tanggal')->first();
            $targetKPI = $indikator->targetKPI->where('tahunPenilaian.tahun', $tahun)->first();

            $target = $targetKPI?->target_tahunan ?? 100;
            $nilai = $realisasi?->nilai;

            $persentase = ($nilai !== null && $target > 0)
                ? round(($nilai / $target) * 100, 2)
                : 0;

            $status = match (true) {
                is_null($nilai) => 'Belum Ada Data',
                $persentase >= 100 => 'Tercapai',
                $persentase >= 90 => 'Hampir Tercapai',
                default => 'Belum Tercapai'
            };

            if ($nilai !== null) {
                if ($persentase >= 100) $tercapai++;
                else $belumTercapai++;
            }

            return [
                'kode' => $indikator->kode,
                'nama' => $indikator->nama,
                'bidang_nama' => $indikator->bidang->nama ?? '-',
                'realisasi_target' => $target,
                'realisasi_nilai' => $nilai,
                'realisasi_persentase' => $persentase,
                'realisasi_status' => $status,
            ];
        });

        $pilar->indikators = $indikators;
        return $pilar;
    });

    $rataRataPencapaian = $totalIndikator > 0
        ? round(($tercapai / $totalIndikator) * 100, 2)
        : 0;

    $data = [
        'title' => 'Laporan KPI Keseluruhan',
        'subtitle' => 'Periode: ' . $tanggal->translatedFormat('F Y'),
        'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y H:i'),
        'pilars' => $pilars,
        'totalIndikator' => $totalIndikator,
        'tercapai' => $tercapai,
        'belumTercapai' => $belumTercapai,
        'rataRataPencapaian' => $rataRataPencapaian,
    ];

    $pdf = PDF::loadView('eksporPdf.keseluruhan', $data);
    return $pdf->download("Laporan_KPI_Keseluruhan_{$tahun}_{$bulan}.pdf");
}


}
