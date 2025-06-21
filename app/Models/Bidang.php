<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ActivityLoggable;
use App\Models\Realisasi;

class Bidang extends Model
{
    use HasFactory, ActivityLoggable;

    protected $fillable = [
        'nama',
        'kode',
        'role_pic',
        'deskripsi',
    ];

    /**
     * Mendapatkan semua indikator yang terkait dengan bidang ini
     */
    public function indikators(): HasMany
    {
        return $this->hasMany(Indikator::class);
    }

    /**
     * Alias untuk indikators() untuk backward compatibility
     */
    public function indikator(): HasMany
    {
        return $this->indikators();
    }

    /**
     * Mendapatkan PIC user dari bidang ini
     *
     * @return \App\Models\User|null
     */
    public function getPICUser()
    {
        return User::where('role', $this->role_pic)->first();
    }

    /**
     * Mendapatkan nilai rata-rata dari semua indikator dalam bidang ini
     */
    public function getNilaiRata(int $tahun, int $bulan): float
    {
        $indikators = $this->indikators()->where('aktif', true)->get();
        if ($indikators->isEmpty()) {
            return 0;
        }

        $total = 0;
        foreach ($indikators as $indikator) {
            $total += $indikator->getNilai($tahun, $bulan);
        }

        return round($total / $indikators->count(), 2);
    }

    /**
     * Memeriksa apakah semua indikator dalam bidang ini sudah diverifikasi
     */
    public function getVerifikasiAttribute(): bool
    {
        $indikators = $this->indikators()->where('aktif', true)->get();
        if ($indikators->isEmpty()) {
            return false;
        }

        $tahun = date('Y');
        $bulan = date('m');

        foreach ($indikators as $indikator) {
            $realisasi = Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();

            if (!$realisasi || !$realisasi->diverifikasi) {
                return false;
            }
        }

        return true;
    }

    /**
     * Mendapatkan judul untuk log aktivitas
     */
    public function getActivityLogTitle()
    {
        return $this->nama;
    }
}
