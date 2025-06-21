<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pilar;
use App\Models\Bidang;
use App\Models\Indikator;
use App\Models\TargetKPI;
use App\Models\TahunPenilaian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TargetKinerjaController extends Controller
{
    /**
     * Memastikan user telah login
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar target KPI
     */
    public function index(Request $request)
    {
        // Hanya master admin dan admin yang boleh mengakses
        $user = Auth::user();
        if (!$user->isMasterAdmin() && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk fitur ini.');
        }

        // Ambil tahun penilaian aktif atau dari request
        $tahunPenilaianId = $request->tahun_penilaian_id;
        $tahunPenilaian = null;

        if ($tahunPenilaianId) {
            $tahunPenilaian = TahunPenilaian::find($tahunPenilaianId);
        }

        if (!$tahunPenilaian) {
            // Coba cari tahun penilaian aktif
            $tahunPenilaian = TahunPenilaian::where('is_aktif', true)->first();

            // Jika masih tidak ditemukan, coba cari tahun penilaian terbaru
            if (!$tahunPenilaian) {
                $tahunPenilaian = TahunPenilaian::orderBy('tahun', 'desc')->first();

                // Jika sama sekali tidak ada tahun penilaian, tampilkan halaman target kinerja dengan pesan
                if (!$tahunPenilaian) {
                    // Jika user adalah master admin
                    if ($user->isMasterAdmin()) {
                        // Tampilkan halaman kosong dengan pesan error
                        $pilars = collect([]);
                        $totalIndikators = 0;
                        session()->flash('error', 'Tidak ada tahun penilaian yang tersedia. Silakan buat tahun penilaian terlebih dahulu.');
                        return view('targetKinerja.index', compact('pilars', 'tahunPenilaian', 'totalIndikators'));
                    } else {
                        // Jika user admin bidang, tampilkan halaman kosong dengan pesan error
                        $bidang = $user->getBidang();
                        if (!$bidang) {
                            return redirect()->route('dashboard')->with('error', 'Bidang tidak ditemukan untuk admin ini.');
                        }
                        $indikators = collect([]);
                        session()->flash('error', 'Tidak ada tahun penilaian yang tersedia. Silakan hubungi administrator.');
                        return view('targetKinerja.index_admin', compact('indikators', 'bidang', 'tahunPenilaian'));
                    }
                }

                // Tampilkan peringatan bahwa tidak ada tahun aktif
                session()->flash('warning', 'Tidak ada tahun penilaian aktif. Menggunakan tahun penilaian terbaru (' . $tahunPenilaian->tahun . ').');
            }
        }

        // Jika user adalah master admin, ambil semua indikator
        if ($user->isMasterAdmin()) {
            // Ambil semua pilar dengan relasinya dalam satu query
            $pilars = Pilar::with([
                'indikators' => function($query) {
                    $query->with('bidang')->orderBy('kode');
                }
            ])->orderBy('urutan')->get();

            // Cek apakah pilars tidak kosong
            if ($pilars->isEmpty()) {
                return redirect()->route('dashboard')->with('error', 'Data pilar belum tersedia. Silakan hubungi administrator.');
            }

            // Tambahkan data target ke tiap indikator
            foreach ($pilars as $pilar) {
                foreach ($pilar->indikators as $indikator) {
                    $target = $indikator->getTarget($tahunPenilaian->id);
                    $indikator->target_data = $target;
                }
            }

            // Hitung total indikator untuk memastikan semua data diambil
            $totalIndikators = $pilars->sum(function($pilar) {
                return $pilar->indikators->count();
            });

            // Log untuk debugging
            \Log::info("Total Pilar: " . $pilars->count());
            \Log::info("Total Indikator: " . $totalIndikators);

            return view('targetKinerja.index', compact('pilars', 'tahunPenilaian', 'totalIndikators'));
        }

        // Jika user adalah admin bidang, hanya ambil indikator di bidangnya
        else {
            $bidang = $user->getBidang();
            if (!$bidang) {
                return redirect()->route('dashboard')->with('error', 'Bidang tidak ditemukan untuk admin ini.');
            }

            $indikators = Indikator::where('bidang_id', $bidang->id)
                ->orderBy('kode')
                ->get();

            // Tambahkan data target ke tiap indikator
            foreach ($indikators as $indikator) {
                $target = $indikator->getTarget($tahunPenilaian->id);
                $indikator->target_data = $target;
            }

            return view('targetKinerja.index_admin', compact('indikators', 'bidang', 'tahunPenilaian'));
        }
    }

    /**
     * Menampilkan form untuk membuat target KPI baru
     */
    public function create(Request $request)
    {
        // Hanya master admin dan admin yang boleh mengakses
        $user = Auth::user();
        if (!$user->isMasterAdmin() && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk fitur ini.');
        }

        $indikatorId = $request->indikator_id;
        $tahunPenilaianId = $request->tahun_penilaian_id;

        if (!$indikatorId || !$tahunPenilaianId) {
            return redirect()->route('targetKinerja.index')->with('error', 'Parameter tidak lengkap.');
        }

        $indikator = Indikator::findOrFail($indikatorId);
        $tahunPenilaian = TahunPenilaian::findOrFail($tahunPenilaianId);

        // Cek apakah user adalah admin dan memiliki akses ke indikator ini
        if ($user->isAdmin()) {
            $bidang = $user->getBidang();
            if (!$bidang || $bidang->id != $indikator->bidang_id) {
                return redirect()->route('targetKinerja.index')->with('error', 'Anda tidak memiliki akses untuk indikator ini.');
            }
        }

        // Cek apakah target sudah ada
        $existingTarget = TargetKPI::where('indikator_id', $indikatorId)
            ->where('tahun_penilaian_id', $tahunPenilaianId)
            ->first();

        if ($existingTarget) {
            return redirect()->route('targetKinerja.edit', ['targetKinerja' => $existingTarget->id])
                ->with('info', 'Target untuk indikator ini sudah ada.');
        }

        return view('targetKinerja.create', compact('indikator', 'tahunPenilaian'));
    }

    /**
     * Menyimpan target KPI baru
     */
    public function store(Request $request)
    {
        // Hanya master admin dan admin yang boleh mengakses
        $user = Auth::user();
        if (!$user->isMasterAdmin() && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk fitur ini.');
        }

        $request->validate([
            'indikator_id' => 'required|exists:indikators,id',
            'tahun_penilaian_id' => 'required|exists:tahun_penilaians,id',
            'target_tahunan' => 'required|numeric|min:0',
            'target_bulanan' => 'nullable|array',
            'target_bulanan.*' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $indikator = Indikator::findOrFail($request->indikator_id);

        // Cek apakah user adalah admin dan memiliki akses ke indikator ini
        if ($user->isAdmin()) {
            $bidang = $user->getBidang();
            if (!$bidang || $bidang->id != $indikator->bidang_id) {
                return redirect()->route('targetKinerja.index')->with('error', 'Anda tidak memiliki akses untuk indikator ini.');
            }
        }

        // Cek apakah target sudah ada
        $existingTarget = TargetKPI::where('indikator_id', $request->indikator_id)
            ->where('tahun_penilaian_id', $request->tahun_penilaian_id)
            ->first();

        if ($existingTarget) {
            return redirect()->route('targetKinerja.edit', ['targetKinerja' => $existingTarget->id])
                ->with('info', 'Target untuk indikator ini sudah ada dan telah diperbarui.');
        }

        // Buat target baru
        TargetKPI::create([
            'indikator_id' => $request->indikator_id,
            'tahun_penilaian_id' => $request->tahun_penilaian_id,
            'user_id' => $user->id,
            'target_tahunan' => $request->target_tahunan,
            'target_bulanan' => $request->target_bulanan,
            'keterangan' => $request->keterangan,
            'disetujui' => false,
        ]);

        // Update nilai target di indikator juga
        $indikator->update(['target' => $request->target_tahunan]);

        return redirect()->route('targetKinerja.index', ['tahun_penilaian_id' => $request->tahun_penilaian_id])
            ->with('success', 'Target berhasil disimpan.');
    }

    /**
     * Menampilkan form untuk mengedit target KPI
     */
    public function edit($id)
    {
        // Hanya master admin dan admin yang boleh mengakses
        $user = Auth::user();
        if (!$user->isMasterAdmin() && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk fitur ini.');
        }

        $target = TargetKPI::with(['indikator.bidang', 'tahunPenilaian'])->findOrFail($id);

        // Cek apakah user adalah admin dan memiliki akses ke indikator ini
        if ($user->isAdmin()) {
            $bidang = $user->getBidang();
            if (!$bidang || $bidang->id != $target->indikator->bidang_id) {
                return redirect()->route('targetKinerja.index')->with('error', 'Anda tidak memiliki akses untuk indikator ini.');
            }
        }

        // Jika target sudah disetujui dan user bukan master admin, jangan izinkan edit
        if ($target->disetujui && !$user->isMasterAdmin()) {
            return redirect()->route('targetKinerja.index', ['tahun_penilaian_id' => $target->tahun_penilaian_id])
                ->with('error', 'Target yang sudah disetujui tidak dapat diubah.');
        }

        $indikator = $target->indikator;
        $tahunPenilaian = $target->tahunPenilaian;

        return view('targetKinerja.edit', compact('target', 'indikator', 'tahunPenilaian'));
    }

    /**
     * Menyimpan perubahan target KPI
     */
    public function update(Request $request, $id)
    {
        // Hanya master admin dan admin yang boleh mengakses
        $user = Auth::user();
        if (!$user->isMasterAdmin() && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk fitur ini.');
        }

        $target = TargetKPI::with('indikator')->findOrFail($id);

        // Cek apakah user adalah admin dan memiliki akses ke indikator ini
        if ($user->isAdmin()) {
            $bidang = $user->getBidang();
            if (!$bidang || $bidang->id != $target->indikator->bidang_id) {
                return redirect()->route('targetKinerja.index')->with('error', 'Anda tidak memiliki akses untuk indikator ini.');
            }
        }

        // Jika target sudah disetujui dan user bukan master admin, jangan izinkan update
        if ($target->disetujui && !$user->isMasterAdmin()) {
            return redirect()->route('targetKinerja.index', ['tahun_penilaian_id' => $target->tahun_penilaian_id])
                ->with('error', 'Target yang sudah disetujui tidak dapat diubah.');
        }

        $request->validate([
            'target_tahunan' => 'required|numeric|min:0',
            'target_bulanan' => 'nullable|array',
            'target_bulanan.*' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Update target
        $target->update([
            'target_tahunan' => $request->target_tahunan,
            'target_bulanan' => $request->target_bulanan,
            'keterangan' => $request->keterangan,
            'user_id' => $user->id, // Update user yang terakhir mengedit
        ]);

        // Update nilai target di indikator juga
        $target->indikator->update(['target' => $request->target_tahunan]);

        return redirect()->route('targetKinerja.index', ['tahun_penilaian_id' => $target->tahun_penilaian_id])
            ->with('success', 'Target berhasil diperbarui.');
    }

    /**
     * Menyetujui target KPI
     */
    public function approve($id)
    {
        // Hanya master admin yang boleh menyetujui
        $user = Auth::user();
        if (!$user->isMasterAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Hanya Master Admin yang dapat menyetujui target.');
        }

        $target = TargetKPI::findOrFail($id);

        // Update status persetujuan
        $target->update([
            'disetujui' => true,
            'disetujui_oleh' => $user->id,
            'disetujui_pada' => now(),
        ]);

        return redirect()->route('targetKinerja.index', ['tahun_penilaian_id' => $target->tahun_penilaian_id])
            ->with('success', 'Target berhasil disetujui.');
    }

    /**
     * Membatalkan persetujuan target KPI
     */
    public function unapprove($id)
    {
        // Hanya master admin yang boleh membatalkan persetujuan
        $user = Auth::user();
        if (!$user->isMasterAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Hanya Master Admin yang dapat membatalkan persetujuan target.');
        }

        $target = TargetKPI::findOrFail($id);

        // Update status persetujuan
        $target->update([
            'disetujui' => false,
            'disetujui_oleh' => null,
            'disetujui_pada' => null,
        ]);

        return redirect()->route('targetKinerja.index', ['tahun_penilaian_id' => $target->tahun_penilaian_id])
            ->with('success', 'Persetujuan target berhasil dibatalkan.');
    }
    public function verifikasi($id)
{
    $target = TargetKPI::findOrFail($id);
    $target->disetujui = true;
    $target->verifikasi_oleh = Auth::id();
    $target->verifikasi_pada = now();
    $target->save();

    return redirect()->back()->with('success', 'Target berhasil diverifikasi.');
}

}
