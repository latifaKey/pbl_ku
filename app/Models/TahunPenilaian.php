<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPenilaian extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini
     *
     * @var string
     */
    protected $table = 'tahun_penilaians';

    /**
     * Atribut yang dapat diisi
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun',
        'deskripsi',
        'tipe_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
        'is_locked',
        'dibuat_oleh',
        'diupdate_oleh',
    ];

    /**
     * Atribut yang harus dikonversi tipe datanya
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_aktif' => 'boolean',
        'is_locked' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Mendapatkan user yang membuat tahun penilaian
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /**
     * Mendapatkan user yang mengupdate tahun penilaian
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'diupdate_oleh');
    }

    /**
     * Mendapatkan tahun aktif
     *
     * @return TahunPenilaian|null
     */
    public static function getActive()
    {
        return self::where('is_aktif', true)->first();
    }

    /**
     * Mendapatkan tahun aktif atau tahun saat ini jika tidak ada yang aktif
     *
     * @return int
     */
    public static function getActiveTahun()
    {
        $active = self::getActive();
        return $active ? $active->tahun : date('Y');
    }

    /**
     * Cek apakah periode sudah terkunci (locked)
     *
     * @return bool
     */
    public function isLocked()
    {
        return $this->is_locked;
    }

    /**
     * Mendapatkan label untuk tipe periode
     *
     * @return string
     */
    public function getTipePeriodeLabel()
    {
        $labels = [
            'tahunan' => 'Tahunan',
            'semesteran' => 'Semesteran',
            'triwulanan' => 'Triwulanan',
            'bulanan' => 'Bulanan',
        ];

        return $labels[$this->tipe_periode] ?? 'Tahunan';
    }
}
