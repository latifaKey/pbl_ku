<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AktivitasLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataKinerjaController;
use App\Http\Controllers\EksporPdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\TahunPenilaianController;
use App\Http\Controllers\TargetKinerjaController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Auth;
use App\Models\Bidang;
use App\Models\Indikator;
use App\Models\Realisasi;

// Redirect ke halaman utama
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route dashboard yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {

    // Dashboard utama - otomatis redirect berdasarkan role di controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/master', [DashboardController::class, 'master'])->name('dashboard.master');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');

    // Dashboard untuk PIC admin per bidang
    Route::get('/dashboard/admin/keuangan', function () {
        return view('dashboard.admin_keuangan');
    })->name('dashboard.admin.keuangan');

    Route::get('/dashboard/admin/risiko', function () {
        return view('dashboard.admin_risiko');
    })->name('dashboard.admin.risiko');

    Route::get('/dashboard/admin/skreperusahaan', function () {
        return view('dashboard.admin_skreperusahaan');
    })->name('dashboard.admin.skreperusahaan');

    Route::get('/dashboard/admin/perencanaan-operasi', function () {
        return view('dashboard.admin_perencanaan_operasi');
    })->name('dashboard.admin.perencanaan_operasi');

    Route::get('/dashboard/admin/pengembangan-bisnis', function () {
        return view('dashboard.admin_pengembangan_bisnis');
    })->name('dashboard.admin.pengembangan_bisnis');

    Route::get('/dashboard/admin/human-capital', function () {
        return view('dashboard.admin_human_capital');
    })->name('dashboard.admin.human_capital');

    Route::get('/dashboard/admin/k3l', function () {
        return view('dashboard.admin_k3l');
    })->name('dashboard.admin.k3l');

    Route::get('/dashboard/admin/perencanaan-korporat', function () {
        return view('dashboard.admin_perencanaan_korporat');
    })->name('dashboard.admin.perencanaan_korporat');

    Route::get('/dashboard/admin/sekretaris-perusahaan', function () {
        return view('dashboard.admin_sekretaris');
    })->name('dashboard.admin.sekretaris_perusahaan');

    // CRUD Akun - sudah dikonfigurasi di controller
    Route::resource('akun', AkunController::class);

    // Routes untuk Data Kinerja
    Route::get('/dataKinerja', [DataKinerjaController::class, 'index'])->name('dataKinerja.index');
    Route::get('/dataKinerja/pilar/{id?}', [DataKinerjaController::class, 'pilar'])->name('dataKinerja.pilar');
    Route::get('/dataKinerja/bidang/{id?}', [DataKinerjaController::class, 'bidang'])->name('dataKinerja.bidang');
    Route::get('/dataKinerja/indikator/{id}', [DataKinerjaController::class, 'indikator'])->name('dataKinerja.indikator');
    Route::get('/dataKinerja/perbandingan', [DataKinerjaController::class, 'perbandingan'])->name('dataKinerja.perbandingan');

    // Profile routes langsung (tidak pakai prefix) - tidak perlu ada duplikasi
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');

    // Routes untuk Realisasi
    Route::get('/realisasi', [RealisasiController::class, 'index'])->name('realisasi.index');
    Route::get('/realisasi/{indikator}/create', [RealisasiController::class, 'create'])->name('realisasi.create');
    Route::post('/realisasi/{indikator}', [RealisasiController::class, 'store'])->name('realisasi.store');
    Route::get('/realisasi/{indikator}/edit', [RealisasiController::class, 'edit'])->name('realisasi.edit');
    Route::put('/realisasi/{id}', [RealisasiController::class, 'update'])->name('realisasi.update');
    Route::get('/realisasi/{id}/verify', [RealisasiController::class, 'verify'])->name('realisasi.verify');
    Route::get('/realisasi/{id}/unverify', [RealisasiController::class, 'unverify'])->name('realisasi.unverify');

    // Tahun Penilaian
    Route::resource('tahunPenilaian', TahunPenilaianController::class);
    Route::get('/tahunPenilaian/{id}/activate', [TahunPenilaianController::class, 'activate'])->name('tahunPenilaian.activate');
    Route::get('/tahunPenilaian/{id}/lock', [TahunPenilaianController::class, 'lock'])->name('tahunPenilaian.lock');
    Route::get('/tahunPenilaian/{id}/unlock', [TahunPenilaianController::class, 'unlock'])->name('tahunPenilaian.unlock');

    Route::get('/ekspor-pdf', [EksporPdfController::class, 'index'])->name('eksporPdf.index');
    Route::post('/ekspor-pdf/keseluruhan', [EksporPdfController::class, 'eksporKeseluruhan'])->name('eksporPdf.keseluruhan');

    // Log Aktivitas
    Route::prefix('aktivitas-log')->name('aktivitasLog.')->group(function () {
        Route::get('/', [AktivitasLogController::class, 'index'])->name('index');
        Route::get('/ekspor-csv', [AktivitasLogController::class, 'eksporCsv'])->name('eksporCsv');
        Route::post('/hapus-log-lama', [AktivitasLogController::class, 'hapusLogLama'])->name('hapusLogLama');
        Route::delete('/{id}', [AktivitasLogController::class, 'destroy'])->name('destroy');
        Route::post('/hapus-multiple', [AktivitasLogController::class, 'hapusMultiple'])->name('hapusMultiple');
        Route::get('/{id}', [AktivitasLogController::class, 'show'])->name('show')->where('id', '[0-9]+');
    });

    // Routes untuk Target Kinerja
    Route::get('/targetKinerja', [TargetKinerjaController::class, 'index'])->name('targetKinerja.index');
    Route::get('/targetKinerja/create', [TargetKinerjaController::class, 'create'])->name('targetKinerja.create');
    Route::post('/targetKinerja', [TargetKinerjaController::class, 'store'])->name('targetKinerja.store');
    Route::get('/targetKinerja/{targetKinerja}/edit', [TargetKinerjaController::class, 'edit'])->name('targetKinerja.edit');
    Route::put('/targetKinerja/{targetKinerja}', [TargetKinerjaController::class, 'update'])->name('targetKinerja.update');
    Route::get('/targetKinerja/{targetKinerja}/approve', [TargetKinerjaController::class, 'approve'])->name('targetKinerja.approve');
    Route::get('/targetKinerja/{targetKinerja}/unapprove', [TargetKinerjaController::class, 'unapprove'])->name('targetKinerja.unapprove');

    // Verifikasi KPI - PENTING: Rute massal harus didefinisikan SEBELUM resource route
    Route::post('/verifikasi/massal', [VerifikasiController::class, 'verifikasiMassal'])->name('verifikasi.massal');

    // Tambahkan rute baru khusus untuk verifikasi massal
    Route::post('/verifikasi-massal', [VerifikasiController::class, 'verifikasiMassal'])->name('verifikasi.massal.alt');

    // Rute untuk approval berjenjang
    Route::post('/verifikasi/{id}/approve-pic', [VerifikasiController::class, 'approveByPic'])->name('verifikasi.approve.pic');
    Route::post('/verifikasi/{id}/approve-manager', [VerifikasiController::class, 'approveByManager'])->name('verifikasi.approve.manager');

    Route::resource('verifikasi', VerifikasiController::class)->except(['create', 'edit', 'store']);
});

