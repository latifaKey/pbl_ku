<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ActivityLoggable;

class User extends Authenticatable
{
    use HasFactory, ActivityLoggable;

    /**
     * Atribut yang boleh diisi massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang disembunyikan saat array atau JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus dikonversi tipe datanya.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Realisasi yang diinput oleh user ini
     */
    public function realisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class);
    }

    /**
     * Realisasi yang diverifikasi oleh user ini
     */
    public function verifiedRealisasis(): HasMany
    {
        return $this->hasMany(Realisasi::class, 'verifikasi_oleh');
    }

    /**
     * Cek apakah user adalah master admin (asisten manajer)
     */
    public function isMasterAdmin(): bool
    {
        return $this->role === 'asisten_manager';
    }

    /**
     * Cek apakah user adalah admin (PIC bidang)
     */
    public function isAdmin(): bool
    {
        return strpos($this->role, 'pic_') === 0;
    }

    /**
     * Cek apakah user adalah karyawan biasa
     */
    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    /**
     * Mendapatkan bidang yang dikelola oleh PIC ini
     */
    public function getBidang()
    {
        if (!$this->isAdmin()) {
            return null;
        }

        return Bidang::where('role_pic', $this->role)->first();
    }

    /**
     * Mendapatkan indikator yang menjadi tanggung jawab PIC ini
     */
    public function getIndikators()
    {
        $bidang = $this->getBidang();
        if (!$bidang) {
            return collect();
        }

        return $bidang->indikators()->get();
    }

    /**
     * Alias untuk getIndikators() (bentuk singular)
     */
    public function indikator()
    {
        $bidang = $this->getBidang();
        if (!$bidang) {
            return $this->hasMany(Indikator::class, 'id', 'id')->where('id', 0);
        }

        return $bidang->indikator();
    }

    /**
     * Mendapatkan judul untuk log aktivitas
     */
    public function getActivityLogTitle()
    {
        return $this->name;
    }
    /**
     * Cek apakah user memiliki salah satu dari beberapa role
     */
    public function hasRole($roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }

        return $this->role === $roles;
    }
public function isRole($role)
{
    return $this->role === $role;
}

}
