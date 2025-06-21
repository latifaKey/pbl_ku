<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ActivityLoggable;

class Indikator extends Model
{
    use HasFactory, ActivityLoggable;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'pilar_id',
        'bidang_id',
        'kode',
        'nama',
        'deskripsi',
        'bobot',
        'target',
        'urutan',
        'aktif',
        'is_utama',
        'prioritas',
    ];

    // Casting tipe data otomatis
    protected $casts = [
        'bobot' => 'float',
        'target' => 'float',
        'aktif' => 'boolean',
        'is_utama' => 'boolean',
        'prioritas' => 'integer',
    ];

    /**
     * Relasi ke Pilar
     * @return BelongsTo
     */
    public function pilar(): BelongsTo
    {
        return $this->belongsTo(Pilar::class);
    }

    /**
     * Relasi ke Bidang (PIC)
     * @return BelongsTo
     */
    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }

    /**
     * Relasi ke banyak Realisasi indikator ini
     * @return HasMany
     */
    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class, 'indikator_id');
    }

    /**
     * Relasi ke banyak Target KPI indikator ini
     * @return HasMany
     */
    public function targetKPI()
{
    return $this->hasMany(TargetKPI::class, 'indikator_id');
}
public function targetKPIs()
{
    return $this->hasMany(\App\Models\TargetKPI::class, 'indikator_id');
}

    /**
     * Ambil nilai realisasi (persentase) untuk tahun, bulan, dan tipe periode tertentu
     * @param int $tahun
     * @param int $bulan
     * @param string $periodeTipe (default 'bulanan')
     * @return float
     */
    public function getNilai(int $tahun, int $bulan, string $periodeTipe = 'bulanan'): float
    {
        $realisasi = $this->realisasis()
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('periode_tipe', $periodeTipe)
            ->first();

        return $realisasi ? $realisasi->persentase : 0;
    }

    /**
     * Ambil target KPI berdasarkan tahun penilaian
     * @param int $tahunPenilaianId
     * @return TargetKPI|null
     */
    public function getTarget(int $tahunPenilaianId): ?TargetKPI
    {
        return $this->targetKPIs()
            ->where('tahun_penilaian_id', $tahunPenilaianId)
            ->first();
    }

    /**
     * Ambil histori data realisasi untuk tahun dan tipe periode tertentu
     * @param int $tahun
     * @param string $periodeTipe
     * @return array
     */
    public function getHistoryData(int $tahun, string $periodeTipe = 'bulanan'): array
    {
        return $this->realisasis()
            ->where('tahun', $tahun)
            ->where('periode_tipe', $periodeTipe)
            ->orderBy('bulan')
            ->orderBy('minggu')
            ->get()
            ->toArray();
    }

    /**
     * Judul untuk log aktivitas (dari trait ActivityLoggable)
     * @return string
     */
    public function getActivityLogTitle(): string
    {
        return $this->nama;
    }

    /**
     * Relasi realisasis filtered by user_id dan tanggal (tanpa parameter)
     * Digunakan untuk eager loading dengan filter dinamis
     * @return HasMany
     */
    public function realisasisFiltered()
    {
        return $this->hasMany(Realisasi::class, 'indikator_id');
    }

    /**
     * Ambil satu realisasi spesifik untuk user dan tanggal tertentu (fungsi biasa, bukan relasi)
     *
     * @param int $userId
     * @param string $tanggal (format 'Y-m-d')
     * @return Realisasi|null
     */
    public function getRealisasiForUserTanggal(int $userId, string $tanggal)
    {
        return $this->realisasis()
            ->where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->first();
    }
    // app/Models/Indikator.php

public function getPersentase($tahun, $bulan)
{
    $realisasi = $this->realisasis()
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->first();

    if (!$realisasi || $realisasi->nilai == 0 || $this->target == 0) {
        return 0;
    }

    return round(($realisasi->nilai / $this->target) * 100, 2);
}



}
