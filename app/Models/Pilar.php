<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ActivityLoggable;

class Pilar extends Model
{
    use HasFactory, ActivityLoggable;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'urutan',
    ];

    /**
     * Mendapatkan semua indikator yang termasuk dalam pilar ini
     */
    public function indikators(): HasMany
    {
        return $this->hasMany(Indikator::class)->orderBy('urutan');
    }

    /**
     * Alias untuk indikators() untuk backward compatibility
     */
    public function indikator(): HasMany
    {
        return $this->indikators();
    }

    /**
     * Mendapatkan total realisasi pilar berdasarkan indikator-indikatornya
     *
     * @param int $tahun
     * @param int $bulan
     * @param string $periodeTipe
     * @return float
     */
    public function getNilai(int $tahun, int $bulan, string $periodeTipe = 'bulanan'): float
    {
        $totalBobot = $this->indikators()->sum('bobot');
        if ($totalBobot <= 0) {
            return 0;
        }

        $totalNilaiTertimbang = 0;
        foreach ($this->indikators as $indikator) {
            $nilaiIndikator = $indikator->getNilai($tahun, $bulan, $periodeTipe);
            $totalNilaiTertimbang += ($nilaiIndikator * $indikator->bobot / 100);
        }

        return round($totalNilaiTertimbang, 2);
    }

    /**
     * Mendapatkan judul untuk log aktivitas
     */
    public function getActivityLogTitle()
    {
        return $this->nama;
    }
}
