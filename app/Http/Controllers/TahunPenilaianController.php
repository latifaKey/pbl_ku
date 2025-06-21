<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunPenilaian;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TahunPenilaianController extends Controller
{
    /**
     * Batasi akses hanya untuk master admin
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'asisten_manager') {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar tahun penilaian
     */
    public function index()
    {
        $tahunPenilaians = TahunPenilaian::orderBy('tahun', 'desc')->get();
        return view('tahunPenilaian.index', compact('tahunPenilaians'));
    }

    /**
     * Menampilkan form tambah tahun penilaian
     */
    public function create()
    {
        return view('tahunPenilaian.create');
    }

    /**
     * Menyimpan tahun penilaian baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020|unique:tahun_penilaians,tahun',
            'deskripsi' => 'nullable|string|max:255',
            'tipe_periode' => 'required|in:tahunan,semesteran,triwulanan,bulanan',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_aktif' => 'boolean',
            'is_locked' => 'boolean',
        ]);

        // Tentukan tanggal otomatis jika tidak diisi
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        if (!$tanggalMulai) {
            switch ($request->tipe_periode) {
                case 'tahunan':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 12, 31)->format('Y-m-d');
                    break;
                case 'semesteran':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 6, 30)->format('Y-m-d');
                    break;
                case 'triwulanan':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 3, 31)->format('Y-m-d');
                    break;
                case 'bulanan':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 1, 31)->format('Y-m-d');
                    break;
            }
        }

        // Jika tahun aktif, nonaktifkan tahun lainnya
        if ($request->is_aktif) {
            TahunPenilaian::where('is_aktif', true)->update(['is_aktif' => false]);
        }

        TahunPenilaian::create([
            'tahun' => $request->tahun,
            'deskripsi' => $request->deskripsi,
            'tipe_periode' => $request->tipe_periode,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'is_aktif' => $request->is_aktif ?? false,
            'is_locked' => $request->is_locked ?? false,
            'dibuat_oleh' => Auth::id(),
        ]);

        return redirect()->route('tahunPenilaian.index')
            ->with('success', 'Tahun penilaian berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit tahun penilaian
     */
    public function edit($id)
    {
        $tahunPenilaian = TahunPenilaian::findOrFail($id);
        return view('tahunPenilaian.edit', compact('tahunPenilaian'));
    }

    /**
     * Mengupdate tahun penilaian
     */
    public function update(Request $request, $id)
    {
        $tahunPenilaian = TahunPenilaian::findOrFail($id);

        // Validasi data yang diinput
        $request->validate([
            'tahun' => 'required|integer|min:2020|unique:tahun_penilaians,tahun,' . $id,
            'deskripsi' => 'nullable|string|max:255',
            'tipe_periode' => 'required|in:tahunan,semesteran,triwulanan,bulanan',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_aktif' => 'boolean',
            'is_locked' => 'boolean',
        ]);

        // Cek apakah data yang terkunci masih bisa diubah
        if ($tahunPenilaian->is_locked && !Auth::user()->role === 'asisten_manager') {
            return redirect()->route('tahunPenilaian.index')
                ->with('error', 'Tahun penilaian yang terkunci tidak dapat diubah.');
        }

        // Tentukan tanggal otomatis jika tidak diisi
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        if (!$tanggalMulai) {
            switch ($request->tipe_periode) {
                case 'tahunan':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 12, 31)->format('Y-m-d');
                    break;
                case 'semesteran':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 6, 30)->format('Y-m-d');
                    break;
                case 'triwulanan':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 3, 31)->format('Y-m-d');
                    break;
                case 'bulanan':
                    $tanggalMulai = Carbon::createFromDate($request->tahun, 1, 1)->format('Y-m-d');
                    $tanggalSelesai = Carbon::createFromDate($request->tahun, 1, 31)->format('Y-m-d');
                    break;
            }
        }

        // Jika tahun aktif, nonaktifkan tahun lainnya
        if ($request->is_aktif) {
            TahunPenilaian::where('is_aktif', true)->update(['is_aktif' => false]);
        }

        $tahunPenilaian->update([
            'tahun' => $request->tahun,
            'deskripsi' => $request->deskripsi,
            'tipe_periode' => $request->tipe_periode,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'is_aktif' => $request->is_aktif ?? false,
            'is_locked' => $request->is_locked ?? false,
            'diupdate_oleh' => Auth::id(),
        ]);

        return redirect()->route('tahunPenilaian.index')
            ->with('success', 'Tahun penilaian berhasil diperbarui');
    }

    /**
     * Mengaktifkan tahun penilaian
     */
    public function activate($id)
    {
        $tahunPenilaian = TahunPenilaian::findOrFail($id);

        // Nonaktifkan semua tahun
        TahunPenilaian::where('is_aktif', true)->update(['is_aktif' => false]);

        // Aktifkan tahun yang dipilih
        $tahunPenilaian->update([
            'is_aktif' => true,
            'diupdate_oleh' => Auth::id(),
        ]);

        return redirect()->route('tahunPenilaian.index')
            ->with('success', 'Tahun penilaian ' . $tahunPenilaian->tahun . ' berhasil diaktifkan');
    }

    /**
     * Mengunci tahun penilaian
     */
    public function lock($id)
    {
        $tahunPenilaian = TahunPenilaian::findOrFail($id);

        $tahunPenilaian->update([
            'is_locked' => true,
            'diupdate_oleh' => Auth::id(),
        ]);

        return redirect()->route('tahunPenilaian.index')
            ->with('success', 'Tahun penilaian ' . $tahunPenilaian->tahun . ' berhasil dikunci');
    }

    /**
     * Membuka kunci tahun penilaian
     */
    public function unlock($id)
    {
        $tahunPenilaian = TahunPenilaian::findOrFail($id);

        $tahunPenilaian->update([
            'is_locked' => false,
            'diupdate_oleh' => Auth::id(),
        ]);

        return redirect()->route('tahunPenilaian.index')
            ->with('success', 'Tahun penilaian ' . $tahunPenilaian->tahun . ' berhasil dibuka kuncinya');
    }

    /**
     * Menghapus tahun penilaian
     */
    public function destroy($id)
    {
        $tahunPenilaian = TahunPenilaian::findOrFail($id);

        // Jika tahun aktif, tidak bisa dihapus
        if ($tahunPenilaian->is_aktif) {
            return redirect()->route('tahunPenilaian.index')
                ->with('error', 'Tahun penilaian yang aktif tidak dapat dihapus');
        }

        // Jika tahun terkunci, tidak bisa dihapus
        if ($tahunPenilaian->is_locked) {
            return redirect()->route('tahunPenilaian.index')
                ->with('error', 'Tahun penilaian yang terkunci tidak dapat dihapus');
        }

        $tahunPenilaian->delete();

        return redirect()->route('tahunPenilaian.index')
            ->with('success', 'Tahun penilaian berhasil dihapus');
    }
}
