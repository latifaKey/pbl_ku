<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pilar;
use App\Models\Indikator;
use App\Models\Realisasi;
use App\Models\Bidang;
use App\Models\AktivitasLog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'asisten_manager':
                return $this->master($request);
            case 'karyawan':
                return $this->user($request);
            case 'pic_keuangan':
            case 'pic_manajemen_risiko':
            case 'pic_sekretaris_perusahaan':
            case 'pic_perencanaan_operasi':
            case 'pic_pengembangan_bisnis':
            case 'pic_human_capital':
            case 'pic_k3l':
            case 'pic_perencanaan_korporat':
            case 'pic_hukum':
                return $this->admin($request);
            default:
                return redirect()->route('login')->with('error', 'Role tidak dikenali.');
        }
    }

    public function master(Request $request)
    {
        if (Auth::user()->role !== 'asisten_manager') {
            return redirect()->route('dashboard');
        }

        $tahun = (int) $request->input('tahun', date('Y'));
        $bulan = (int) $request->input('bulan', date('m'));

        $pilars = Pilar::with(['indikators' => function($query) {
            $query->where('aktif', true);
        }])->orderBy('urutan')->get();

        $data = ['nko' => 0, 'pilar' => []];
        $totalNilaiPilar = 0;
        $jumlahPilar = $pilars->count();

        foreach ($pilars as $pilar) {
            $pilarData = ['nama' => $pilar->nama, 'nilai' => 0, 'indikator' => []];
            $totalNilaiIndikator = 0;
            $jumlahIndikator = count($pilar->indikators);

            foreach ($pilar->indikators as $indikator) {
                $realisasi = Realisasi::where('indikator_id', $indikator->id)
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->first();

                $nilai = $realisasi ? $realisasi->persentase : 0;

                $totalNilaiIndikator += $nilai;

                $pilarData['indikator'][] = [
                    'nama' => $indikator->nama,
                    'nilai' => $nilai
                ];
            }

            $pilarData['nilai'] = $jumlahIndikator > 0
                ? round($totalNilaiIndikator / $jumlahIndikator, 2)
                : 0;

            $totalNilaiPilar += $pilarData['nilai'];
            $data['pilar'][] = $pilarData;
        }

        $data['nko'] = $jumlahPilar > 0 ? round($totalNilaiPilar / $jumlahPilar, 2) : 0;

        $latestActivities = AktivitasLog::with('user')->latest()->take(10)->get();

        $needVerification = Realisasi::with(['indikator.bidang', 'user'])
            ->where('diverifikasi', false)
            ->latest()
            ->take(5)
            ->get();

        $kpiStats = $this->getKpiStats($tahun, $bulan);

        $poorPerformers = Realisasi::with('indikator.bidang')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('persentase', '<', 70)
            ->orderBy('persentase')
            ->take(5)
            ->get();

        $prevMonth = $bulan === 1 ? 12 : $bulan - 1;
        $prevYear = $bulan === 1 ? $tahun - 1 : $tahun;

        $comparisonData = $this->getPilarComparisonData($pilars, $tahun, $bulan, $prevYear, $prevMonth);

        return view('dashboard.master', compact(
            'data', 'tahun', 'bulan', 'latestActivities', 'needVerification',
            'kpiStats', 'poorPerformers', 'comparisonData'
        ));
    }

    public function admin(Request $request)
    {
        $user = Auth::user();
        $tahun = (int) $request->input('tahun', date('Y'));
        $bulan = (int) $request->input('bulan', date('m'));

        $bidang = Bidang::where('role_pic', $user->role)->first();

        if (!$bidang) {
            return redirect()->route('dashboard')->with('error', 'Bidang tidak ditemukan untuk PIC ini.');
        }

        $indikators = Indikator::where('bidang_id', $bidang->id)
            ->where('aktif', true)
            ->orderBy('kode')
            ->get();

        foreach ($indikators as $indikator) {
            $realisasi = Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();

            $indikator->nilai_persentase = $realisasi ? $realisasi->persentase : 0;
            $indikator->nilai_absolut = $realisasi ? $realisasi->nilai : 0;
            $indikator->diverifikasi = $realisasi ? $realisasi->diverifikasi : false;
        }

        $totalNilai = $indikators->sum('nilai_persentase');
        $rataRata = $indikators->count() > 0 ? round($totalNilai / $indikators->count(), 2) : 0;

        $historiData = $this->getHistoriData($bidang->id, $tahun);

$latestActivities = AktivitasLog::with('user')
    ->where('loggable_type', 'App\Models\Realisasi')
    ->latest()
    ->take(10)
    ->get()
    ->filter(function ($log) use ($bidang) {
        return $log->loggable &&
            method_exists($log->loggable, 'indikator') &&
            $log->loggable->indikator &&
            $log->loggable->indikator->bidang_id == $bidang->id;
    });

        $missingInputs = Indikator::where('bidang_id', $bidang->id)
            ->where('aktif', true)
            ->whereDoesntHave('realisasis', function ($query) use ($tahun, $bulan) {
                $query->where('tahun', $tahun)->where('bulan', $bulan);
            })
            ->get();

        $bidangComparison = $this->getBidangComparison($bidang->id, $tahun, $bulan);

        return view('dashboard.admin', compact(
            'bidang', 'indikators', 'rataRata', 'historiData',
            'tahun', 'bulan', 'latestActivities', 'missingInputs', 'bidangComparison'
        ));
    }

    public function user(Request $request)
    {
        $tahun = (int) $request->input('tahun', date('Y'));
        $bulan = (int) $request->input('bulan', date('m'));

        $nilaiNKO = 75;
        $totalIndikatorTercapai = 120;
        $totalIndikator = 150;
        $persenTercapai = $totalIndikator > 0 ? round(($totalIndikatorTercapai / $totalIndikator) * 100, 2) : 0;

        $analisisData = [
            'tertinggi' => [
                ['kode' => 'I001', 'nama' => 'Indikator A', 'bidang' => 'Bidang 1', 'nilai' => 98],
                ['kode' => 'I002', 'nama' => 'Indikator B', 'bidang' => 'Bidang 2', 'nilai' => 95],
            ],
            'terendah' => [
                ['kode' => 'I101', 'nama' => 'Indikator X', 'bidang' => 'Bidang 3', 'nilai' => 40],
                ['kode' => 'I102', 'nama' => 'Indikator Y', 'bidang' => 'Bidang 4', 'nilai' => 42],
            ],
            'perkembangan' => [
                ['bulan' => 'Januari', 'nko' => 70, 'tercapai' => 100, 'total' => 150, 'persentase' => 67],
                ['bulan' => 'Februari', 'nko' => 75, 'tercapai' => 110, 'total' => 150, 'persentase' => 73],
                ['bulan' => 'Maret', 'nko' => 80, 'tercapai' => 120, 'total' => 150, 'persentase' => 80],
            ],
        ];

        return view('dashboard.user', compact(
            'nilaiNKO', 'totalIndikatorTercapai', 'totalIndikator',
            'persenTercapai', 'tahun', 'bulan', 'analisisData'
        ));
    }

    private function getKpiStats(int $tahun, int $bulan): array
    {
        $totalIndikator = Indikator::where('aktif', true)->count();
        $totalTercapai = Realisasi::where('tahun', $tahun)->where('bulan', $bulan)->where('persentase', '>=', 100)->count();
        $totalBelumTercapai = Realisasi::where('tahun', $tahun)->where('bulan', $bulan)->where('persentase', '<', 100)->count();
        $totalInput = Realisasi::where('tahun', $tahun)->where('bulan', $bulan)->count();
        $totalBelumDiinput = $totalIndikator - $totalInput;

        return compact('totalIndikator', 'totalTercapai', 'totalBelumTercapai', 'totalBelumDiinput');
    }

    private function getPilarComparisonData($pilars, $tahun, $bulan, $prevYear, $prevMonth): array
    {
        return $pilars->map(function ($pilar) use ($tahun, $bulan, $prevYear, $prevMonth) {
            $currentValue = $pilar->getNilai($tahun, $bulan);
            $prevValue = $pilar->getNilai($prevYear, $prevMonth);

            return [
                'name' => $pilar->nama,
                'current' => $currentValue,
                'previous' => $prevValue,
                'change' => $currentValue - $prevValue,
            ];
        })->toArray();
    }

    private function getHistoriData(int $bidangId, int $tahun): array
    {
        $histori = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $indikators = Indikator::where('bidang_id', $bidangId)->where('aktif', true)->get();

            $totalNilai = 0;
            $count = 0;

            foreach ($indikators as $indikator) {
                $realisasi = Realisasi::where('indikator_id', $indikator->id)
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->first();

                if ($realisasi) {
                    $totalNilai += $realisasi->persentase;
                    $count++;
                }
            }

            $histori[] = $count > 0 ? round($totalNilai / $count, 2) : 0;
        }

        return $histori;
    }

    private function getBidangComparison(int $bidangId, int $tahun, int $bulan): array
    {
        $indikators = Indikator::where('bidang_id', $bidangId)->where('aktif', true)->get();
        $comparison = [];

        foreach ($indikators as $indikator) {
            $current = Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();

            $previous = Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $bulan == 1 ? $tahun - 1 : $tahun)
                ->where('bulan', $bulan == 1 ? 12 : $bulan - 1)
                ->first();

            $comparison[] = [
                'nama' => $indikator->nama,
                'current' => $current ? $current->persentase : 0,
                'previous' => $previous ? $previous->persentase : 0,
            ];
        }

        return $comparison;
    }
}
