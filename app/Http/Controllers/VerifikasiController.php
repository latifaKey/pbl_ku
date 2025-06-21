<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Realisasi;
use App\Models\Bidang;
use App\Models\AktivitasLog;
use App\Models\TahunPenilaian;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VerifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // Solo permitir acceso a usuarios con rol asisten_manager (master admin)
            if (Auth::user()->role !== 'asisten_manager') {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        $bulan = $request->bulan ?? date('m');
        $bidangId = $request->bidang_id;

        $query = Realisasi::with(['indikator.bidang', 'indikator.pilar', 'user'])
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('diverifikasi', false)
            ->orderBy('created_at', 'desc');

        if ($bidangId) {
            $query->whereHas('indikator', function ($q) use ($bidangId) {
                $q->where('bidang_id', $bidangId);
            });
        }

        $realisasis = $query->paginate(20);
        $bidangs = Bidang::orderBy('nama')->get();

        $tahunPenilaian = TahunPenilaian::where('tahun', $tahun)
            ->where('is_aktif', true)
            ->first();

        $isPeriodeLocked = $tahunPenilaian ? $tahunPenilaian->is_locked : false;

        return view('verifikasi.index', compact('realisasis', 'bidangs', 'tahun', 'bulan', 'bidangId', 'isPeriodeLocked'));
    }

    public function show($id)
    {
        $realisasi = Realisasi::with(['indikator.bidang', 'indikator.pilar', 'user'])->findOrFail($id);

        $tahunPenilaian = TahunPenilaian::where('tahun', $realisasi->tahun)
            ->where('is_aktif', true)
            ->first();

        $isPeriodeLocked = $tahunPenilaian ? $tahunPenilaian->is_locked : false;

        return view('verifikasi.show', compact('realisasi', 'isPeriodeLocked'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $realisasi = Realisasi::with('indikator')->findOrFail($id);

        if ($realisasi->diverifikasi) {
            return redirect()->route('verifikasi.index')->with('info', 'Realisasi ini sudah diverifikasi sebelumnya.');
        }

        $tahunPenilaian = TahunPenilaian::where('tahun', $realisasi->tahun)
            ->where('is_aktif', true)
            ->first();

        if ($tahunPenilaian && $tahunPenilaian->is_locked) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Periode penilaian tahun ' . $realisasi->tahun . ' telah dikunci. Verifikasi tidak dapat dilakukan.');
        }

        $realisasi->update([
            'diverifikasi' => true,
            'verifikasi_oleh' => $user->id,
            'verifikasi_pada' => Carbon::now(),
        ]);

        // Perbaikan: Deskripsi sebagai string, data sebagai array
        $deskripsi = "Verifikasi nilai KPI untuk indikator: " . $realisasi->indikator->kode . " - " . $realisasi->indikator->nama;
        $data = [
            'indikator_id' => $realisasi->indikator_id,
            'nilai' => $realisasi->nilai,
            'tahun' => $realisasi->tahun,
            'bulan' => $realisasi->bulan,
        ];

        AktivitasLog::log(
            $user,
            'verify',
            'Memverifikasi nilai KPI ' . $realisasi->indikator->kode . ' - ' . $realisasi->indikator->nama,
            $deskripsi,
            null,
            $data,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('verifikasi.index')->with('success', 'Realisasi berhasil diverifikasi.');
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $realisasi = Realisasi::with('indikator')->findOrFail($id);

        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $tahunPenilaian = TahunPenilaian::where('tahun', $realisasi->tahun)
            ->where('is_aktif', true)
            ->first();

        if ($tahunPenilaian && $tahunPenilaian->is_locked) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Periode penilaian tahun ' . $realisasi->tahun . ' telah dikunci. Penolakan tidak dapat dilakukan.');
        }

        $indikatorId = $realisasi->indikator_id;
        $indikatorKode = $realisasi->indikator->kode;
        $indikatorNama = $realisasi->indikator->nama;
        $userId = $realisasi->user_id;
        $nilai = $realisasi->nilai;
        $tahun = $realisasi->tahun;
        $bulan = $realisasi->bulan;

        $realisasi->delete();

        // Perbaikan: Deskripsi sebagai string, data sebagai array
        $deskripsi = "Penolakan nilai KPI untuk indikator: " . $indikatorKode . " - " . $indikatorNama . " dengan alasan: " . $request->alasan_penolakan;
        $data = [
            'indikator_id' => $indikatorId,
            'nilai' => $nilai,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'alasan' => $request->alasan_penolakan,
        ];

        AktivitasLog::log(
            $user,
            'delete',
            'Menolak nilai KPI ' . $indikatorKode . ' - ' . $indikatorNama,
            $deskripsi,
            null,
            $data,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('verifikasi.index')->with('success', 'Realisasi berhasil ditolak.');
    }

    public function verifikasiMassal(Request $request)
    {
        // Debug info
        Log::info('verifikasiMassal dipanggil');
        Log::info('Request data:', $request->all());

        $ids = $request->input('nilai_ids', []);
        $user = Auth::user();
        $ip = $request->ip();
        $agent = $request->userAgent();

        // Validasi: tidak ada yang dipilih
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada realisasi yang dipilih.');
        }

        // Ambil data realisasi yang dipilih
        $realisasiList = Realisasi::with(['indikator', 'user'])
            ->whereIn('id', $ids)
            ->get();

        // Jika tidak ditemukan
        if ($realisasiList->isEmpty()) {
            return redirect()->back()->with('error', 'Data realisasi tidak ditemukan.');
        }

        $updatedCount = 0;
        $logData = [];

        foreach ($realisasiList as $realisasi) {
            // Lewati jika sudah diverifikasi
            if ($realisasi->diverifikasi) {
                continue;
            }

            // Cek apakah periode dikunci
            $tahunPenilaian = TahunPenilaian::where('tahun', $realisasi->tahun)
                ->where('is_aktif', true)
                ->first();

            if ($tahunPenilaian && $tahunPenilaian->is_locked) {
                continue;
            }

            // Update verifikasi
            $realisasi->update([
                'diverifikasi' => true,
                'verifikasi_oleh' => $user->id,
                'verifikasi_pada' => now(),
            ]);

            $updatedCount++;

            $logData[] = [
                'id' => $realisasi->id,
                'indikator' => $realisasi->indikator->kode ?? '-',
                'nilai' => $realisasi->nilai,
                'tanggal' => $realisasi->tanggal,
                'user' => $realisasi->user->name ?? '-',
            ];
        }

        // Logging jika ada yang diverifikasi
        if ($updatedCount > 0) {
            try {
                // Perbaikan: Menggunakan string untuk deskripsi
                $deskripsiLog = "Melakukan verifikasi massal terhadap {$updatedCount} realisasi KPI";

                AktivitasLog::log(
                    $user,
                    'verify',
                    'Verifikasi Massal Realisasi KPI',
                    $deskripsiLog,
                    null, // Model null
                    $logData, // Data sebagai array
                    $ip,
                    $agent
                );
            } catch (\Exception $e) {
                // Log error tapi tetap lanjutkan proses
                Log::error('Error saat mencatat aktivitas log: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', "Berhasil memverifikasi {$updatedCount} realisasi terpilih.");
        }

        // Tidak ada yang bisa diverifikasi
        return redirect()->back()->with('info', 'Tidak ada realisasi yang berhasil diverifikasi. Mungkin sudah diverifikasi atau periode telah dikunci.');
    }

    /**
     * Menyetujui realisasi oleh PIC
     */
    public function approveByPic(Request $request, $id)
    {
        $user = Auth::user();
        $realisasi = Realisasi::with('indikator.bidang')->findOrFail($id);

        // Validasi bahwa user adalah PIC dari bidang terkait
        $bidang = $realisasi->indikator->bidang;
        $isPic = str_contains($user->role, 'pic_');

        if (!$isPic) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui realisasi ini.');
        }

        // Cek apakah bidang sesuai dengan role PIC
        $rolePicMapping = [
            'pic_keuangan' => 'Keuangan',
            'pic_manajemen_risiko' => 'Manajemen Risiko',
            'pic_sekretaris_perusahaan' => 'Sekretaris Perusahaan',
            'pic_perencanaan_operasi' => 'Perencanaan Operasi',
            'pic_pengembangan_bisnis' => 'Pengembangan Bisnis',
            'pic_human_capital' => 'Human Capital',
            'pic_k3l' => 'K3L',
            'pic_perencanaan_korporat' => 'Perencanaan Korporat',
            'pic_hukum' => 'Hukum'
        ];

        $bidangName = $bidang->nama;
        $userRole = $user->role;

        $hasAccess = false;
        foreach ($rolePicMapping as $role => $bidangNama) {
            if ($userRole === $role && stripos($bidangName, $bidangNama) !== false) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui realisasi dari bidang ini.');
        }

        // Update status persetujuan
        $realisasi->update([
            'disetujui_pic' => true,
            'disetujui_pic_oleh' => $user->id,
            'disetujui_pic_pada' => now(),
            'approval_level' => 1
        ]);

        // Perbaikan: Deskripsi sebagai string, data sebagai array
        $deskripsi = "Persetujuan PIC untuk realisasi KPI: " . $realisasi->indikator->kode . " - " . $realisasi->indikator->nama;
        $data = [
            'indikator_id' => $realisasi->indikator_id,
            'nilai' => $realisasi->nilai,
            'tahun' => $realisasi->tahun,
            'bulan' => $realisasi->bulan,
        ];

        // Log aktivitas
        AktivitasLog::log(
            $user,
            'approve',
            'Menyetujui realisasi KPI ' . $realisasi->indikator->kode . ' - ' . $realisasi->indikator->nama . ' (PIC)',
            $deskripsi,
            null,
            $data,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->back()->with('success', 'Realisasi berhasil disetujui oleh PIC.');
    }

    /**
     * Menyetujui realisasi oleh Manager
     */
    public function approveByManager(Request $request, $id)
    {
        $user = Auth::user();
        $realisasi = Realisasi::with('indikator')->findOrFail($id);

        // Validasi bahwa user adalah Manager
        if ($user->role !== 'manager') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menyetujui realisasi ini.');
        }

        // Cek apakah sudah disetujui oleh PIC
        if (!$realisasi->disetujui_pic) {
            return redirect()->back()->with('error', 'Realisasi harus disetujui oleh PIC terlebih dahulu.');
        }

        // Update status persetujuan
        $realisasi->update([
            'disetujui_manager' => true,
            'disetujui_manager_oleh' => $user->id,
            'disetujui_manager_pada' => now(),
            'approval_level' => 2
        ]);

        // Perbaikan: Deskripsi sebagai string, data sebagai array
        $deskripsi = "Persetujuan Manager untuk realisasi KPI: " . $realisasi->indikator->kode . " - " . $realisasi->indikator->nama;
        $data = [
            'indikator_id' => $realisasi->indikator_id,
            'nilai' => $realisasi->nilai,
            'tahun' => $realisasi->tahun,
            'bulan' => $realisasi->bulan,
        ];

        // Log aktivitas
        AktivitasLog::log(
            $user,
            'approve',
            'Menyetujui realisasi KPI ' . $realisasi->indikator->kode . ' - ' . $realisasi->indikator->nama . ' (Manager)',
            $deskripsi,
            null,
            $data,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->back()->with('success', 'Realisasi berhasil disetujui oleh Manager.');
    }
}
