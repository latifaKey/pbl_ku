<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use App\Models\Indikator;
use App\Models\TahunPenilaian;
use App\Models\TargetKPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class RealisasiController extends Controller
{


public function index(Request $request)
{
    $user = Auth::user();

    $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
    $parsedDate = Carbon::parse($tanggal);
    $tahun = $parsedDate->year;

    $indikatorsQuery = Indikator::with([
        'pilar',
        'bidang',
        'targetKPI' => function ($query) use ($tahun) {
            $query->whereHas('tahunPenilaian', function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            });
        },
            'realisasis' => function ($query) use ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

    ]);

    if ($user->isMasterAdmin()) {
        // akses semua indikator
    } elseif ($user->isAdmin()) {
        $bidang = $user->getBidang();
        if (!$bidang) {
            return redirect()->route('dashboard')->with('error', 'Bidang tidak ditemukan.');
        }
        $indikatorsQuery->where('bidang_id', $bidang->id);
    } else {
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses.');
    }

    $indikators = $indikatorsQuery->orderBy('kode')->paginate(10)->withQueryString();

    foreach ($indikators as $indikator) {
    $realisasi = $indikator->realisasis->first();

    $targetKPI = $indikator->targetKPI
        ->where('tahunPenilaian.tahun', $tahun)
        ->first();
    $target_nilai = $targetKPI ? $targetKPI->target_tahunan : 0;

    $persentase = 0;
    if ($realisasi && $target_nilai > 0) {
        $persentase = $targetKPI
            ? $targetKPI->hitungPersentasePencapaian($realisasi->nilai)
            : ($realisasi->nilai / $target_nilai) * 100;
    }

    // Gunakan nama custom agar tidak bentrok
    $indikator->firstRealisasi = $realisasi;
    $indikator->persentase = $persentase;
    $indikator->nilai_id = $realisasi?->id;
    $indikator->diverifikasi = $realisasi?->diverifikasi ?? false;
    $indikator->verifikasi_oleh = $realisasi?->verifikasi_oleh;
    $indikator->verifikasi_pada = $realisasi?->verifikasi_pada;
    $indikator->target_nilai = $target_nilai;
}


    return view('realisasi.index', compact('indikators', 'tanggal', 'tahun'));
}






public function create($indikatorId)
{
    $indikator = Indikator::with(['pilar', 'bidang'])->findOrFail($indikatorId);
    $user = Auth::user();

    // Master Admin (asisten_manager) boleh input semua indikator
    if ($user->isMasterAdmin()) {
        // Akses penuh
    }
    // Admin bidang (pic_*) hanya boleh input jika indikator sesuai bidang mereka
    elseif ($user->isAdmin()) {
        $bidang = \App\Models\Bidang::where('role_pic', $user->role)->first();

        if (!$bidang || $bidang->id !== $indikator->bidang_id) {
            abort(403, 'Anda tidak memiliki akses untuk indikator ini.');
        }
    } else {
        abort(403, 'Anda tidak memiliki akses ke fitur ini.');
    }

    return view('realisasi.create', compact('indikator'));
}




public function store(Request $request, Indikator $indikator)
{
    $request->validate([
        'tanggal' => 'required|date',
        'nilai' => 'required|numeric|min:0',
        'keterangan' => 'nullable|string|max:1000',
    ]);

    $tanggal = \Carbon\Carbon::parse($request->tanggal);
    $user = auth()->user();

    // Cek apakah user berwenang menginput indikator ini
    if (!$user->isMasterAdmin() && !$user->isAdmin()) {
        abort(403, 'Anda tidak memiliki hak untuk input realisasi.');
    }

    // Jika admin/pic, cek apakah indikator milik bidang yang sesuai
    if ($user->isAdmin() && $indikator->bidang->role_pic !== $user->role) {
        abort(403, 'Indikator ini tidak termasuk dalam bidang Anda.');
    }


    $realisasi = new Realisasi([
        'indikator_id' => $indikator->id,
        'user_id' => $user->id,
        'uploaded_by' => $user->id, // ← ✅ Tambahkan ini
        'tanggal' => $tanggal->toDateString(),
        'tahun' => $tanggal->year,
        'bulan' => $tanggal->month,
        'periode_tipe' => 'harian',
        'nilai' => $request->nilai,
        'persentase' => $indikator->target > 0 ? ($request->nilai / $indikator->target) * 100 : 0,
        'keterangan' => $request->keterangan,
        'diverifikasi' => false,
    ]);

    $realisasi->save();

    return redirect()->route('realisasi.index')->with('success', 'Realisasi berhasil disimpan.');
}




    public function edit(Request $request, $indikatorId)
    {
        $indikator = Indikator::with(['pilar', 'bidang'])->findOrFail($indikatorId);
        $user = Auth::user();

        if ($user->isAdmin()) {
            $bidang = $user->getBidang();
            if (!$bidang || $indikator->bidang_id !== $bidang->id) {
                abort(403, 'Anda tidak memiliki akses untuk indikator ini.');
            }
        } elseif (!$user->isMasterAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }

        $tanggal = $request->input('tanggal', now()->toDateString());

        $realisasi = Realisasi::where('indikator_id', $indikator->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if (!$realisasi) {
            return redirect()->back()->with('error', 'Data realisasi tidak ditemukan.');
        }

        return view('realisasi.edit', compact('indikator', 'realisasi', 'tanggal'));
    }


    public function update(Request $request, $id)
    {
        $realisasi = Realisasi::with('indikator')->findOrFail($id);
        $indikator = $realisasi->indikator;
        $user = Auth::user();

        if ($user->isAdmin()) {
            $bidang = $user->getBidang();
            if (!$bidang || $indikator->bidang_id !== $bidang->id) {
                abort(403, 'Anda tidak diizinkan mengedit realisasi ini.');
            }
        } elseif (!$user->isMasterAdmin()) {
            abort(403, 'Anda tidak diizinkan mengedit realisasi ini.');
        }


        $validated = $request->validate([
        'nilai' => 'required|numeric|min:0',
        ]);

        $realisasi->update([
            'nilai' => $validated['nilai'],
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        return redirect()->route('realisasi.index')->with('success', 'Realisasi berhasil diperbarui.');
    }


}
