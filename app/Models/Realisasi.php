<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ActivityLoggable;
use App\Models\User;
use App\Models\Indikator;

class Realisasi extends Model
{
    use HasFactory, ActivityLoggable;

    protected $table = 'realisasis';

    protected $guarded = ['id'];

    protected $fillable = [
        'indikator_id',
        'user_id',
        'tanggal',
        'nilai',
        'persentase',
        'keterangan',
        'diverifikasi',
        'verifikasi_oleh',
        'verifikasi_pada',
        'tahun',      // ditambahkan
        'bulan',      // ditambahkan
        'periode_tipe', // ditambahkan
        'approval_level', // level approval (1: PIC, 2: Manager, 3: Asisten Manager)
        'disetujui_pic', // disetujui oleh PIC
        'disetujui_pic_oleh', // ID user PIC yang menyetujui
        'disetujui_pic_pada', // waktu disetujui oleh PIC
        'disetujui_manager', // disetujui oleh Manager
        'disetujui_manager_oleh', // ID user Manager yang menyetujui
        'disetujui_manager_pada', // waktu disetujui oleh Manager
    ];

    protected $casts = [
        'diverifikasi' => 'boolean',
        'verifikasi_pada' => 'datetime',
        'nilai' => 'float',
        'persentase' => 'float',
        'tanggal' => 'date',
        'tahun' => 'integer',
        'bulan' => 'integer',
        'approval_level' => 'integer',
        'disetujui_pic' => 'boolean',
        'disetujui_pic_pada' => 'datetime',
        'disetujui_manager' => 'boolean',
        'disetujui_manager_pada' => 'datetime',
    ];

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifikasi_oleh');
    }

    public function scopeTanggal($query, string $tanggal)
    {
        return $query->where('tanggal', $tanggal);
    }

    public function getNamaTanggalAttribute(): string
    {
        return $this->tanggal ? $this->tanggal->format('d F Y') : '';
    }

    public function getActivityLogTitle()
    {
        $tanggal = $this->tanggal ? $this->tanggal->format('d/m/Y') : '';
        $indikatorNama = $this->indikator ? $this->indikator->nama : '';

        return "Nilai KPI {$indikatorNama} tanggal {$tanggal}";
    }

    public function isVerified()
    {
        return $this->diverifikasi;
    }

    /**
     * Memeriksa apakah realisasi telah disetujui oleh PIC
     */
    public function isApprovedByPic()
    {
        return $this->disetujui_pic;
    }

    /**
     * Memeriksa apakah realisasi telah disetujui oleh Manager
     */
    public function isApprovedByManager()
    {
        return $this->disetujui_manager;
    }

    /**
     * Mendapatkan level approval saat ini
     */
    public function getCurrentApprovalLevel()
    {
        if ($this->diverifikasi) {
            return 3; // Fully verified
        } elseif ($this->disetujui_manager) {
            return 2; // Approved by manager
        } elseif ($this->disetujui_pic) {
            return 1; // Approved by PIC
        } else {
            return 0; // Not approved
        }
    }

    /**
     * Mendapatkan status approval dalam bentuk string
     */
    public function getApprovalStatusAttribute()
    {
        if ($this->diverifikasi) {
            return 'Terverifikasi';
        } elseif ($this->disetujui_manager) {
            return 'Disetujui Manager';
        } elseif ($this->disetujui_pic) {
            return 'Disetujui PIC';
        } else {
            return 'Belum Disetujui';
        }
    }

    /**
     * Mendapatkan warna status approval
     */
    public function getApprovalColorAttribute()
    {
        if ($this->diverifikasi) {
            return 'success';
        } elseif ($this->disetujui_manager) {
            return 'info';
        } elseif ($this->disetujui_pic) {
            return 'primary';
        } else {
            return 'warning';
        }
    }

    // Boot method untuk mengisi tahun, bulan, dan periode_tipe otomatis saat saving
    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->tanggal) {
                $model->tahun = date('Y', strtotime($model->tanggal));
                $model->bulan = (int) date('n', strtotime($model->tanggal));
            }
            // Isi default periode_tipe jika belum ada
            if (empty($model->periode_tipe)) {
                $model->periode_tipe = 'bulanan';  // default nilai
            }
        });
    }
}
