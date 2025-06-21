<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AktivitasLog extends Model
{
    use HasFactory;

    /**
     * Konstanta tipe aktivitas log
     */
    public const TYPE_LOGIN = 'login';
    public const TYPE_LOGOUT = 'logout';
    public const TYPE_CREATE = 'create';
    public const TYPE_UPDATE = 'update';
    public const TYPE_DELETE = 'delete';
    public const TYPE_VERIFY = 'verify';

    /**
     * Nama tabel yang terkait dengan model
     *
     * @var string
     */
    protected $table = 'aktivitas_logs';

    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tipe',
        'judul',
        'deskripsi',
        'loggable_type',
        'loggable_id',
        'data',
        'ip_address',
        'user_agent',
    ];

    /**
     * Atribut yang harus dikonversi tipe datanya
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * User yang melakukan aktivitas
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Model yang terkait dengan aktivitas log
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mendapatkan perubahan data dalam format yang mudah dibaca
     */
    public function getPerubahan(): array
    {
        if (empty($this->data)) {
            return [];
        }

        if (isset($this->data['attributes']) && isset($this->data['old'])) {
            $perubahan = [];
            foreach ($this->data['attributes'] as $key => $value) {
                $oldValue = $this->data['old'][$key] ?? null;
                if ($oldValue !== $value) {
                    $perubahan[$key] = [
                        'sebelum' => $oldValue,
                        'sesudah' => $value
                    ];
                }
            }
            return $perubahan;
        }

        // Jika format data adalah array tetapi tidak memiliki struktur yang diharapkan,
        // konversi data ke format yang sesuai dengan harapan view
        if (is_array($this->data)) {
            $perubahan = [];
            foreach ($this->data as $key => $value) {
                $perubahan[$key] = [
                    'sebelum' => null, // Default null jika tidak ada nilai sebelumnya
                    'sesudah' => $value
                ];
            }
            return $perubahan;
        }

        return [];
    }

    /**
     * Mendapatkan label tipe yang lebih user-friendly
     *
     * @return string
     */
    public function getTipeLabel(): string
    {
        switch ($this->tipe) {
            case self::TYPE_LOGIN:
                return 'Login';
            case self::TYPE_LOGOUT:
                return 'Logout';
            case self::TYPE_CREATE:
                return 'Tambah';
            case self::TYPE_UPDATE:
                return 'Ubah';
            case self::TYPE_DELETE:
                return 'Hapus';
            case self::TYPE_VERIFY:
                return 'Verifikasi';
            default:
                return ucfirst($this->tipe);
        }
    }

    /**
     * Mendapatkan warna untuk tipe log (untuk tampilan badge)
     *
     * @return string
     */
    public function getTipeColor(): string
    {
        switch ($this->tipe) {
            case self::TYPE_LOGIN:
                return 'success';
            case self::TYPE_LOGOUT:
                return 'warning';
            case self::TYPE_CREATE:
                return 'info';
            case self::TYPE_UPDATE:
                return 'primary';
            case self::TYPE_DELETE:
                return 'danger';
            case self::TYPE_VERIFY:
                return 'secondary';
            default:
                return 'light';
        }
    }

    /**
     * Mendapatkan ikon untuk tipe log
     *
     * @return string
     */
    public function getTipeIcon(): string
    {
        switch ($this->tipe) {
            case self::TYPE_LOGIN:
                return 'fa-sign-in-alt';
            case self::TYPE_LOGOUT:
                return 'fa-sign-out-alt';
            case self::TYPE_CREATE:
                return 'fa-plus';
            case self::TYPE_UPDATE:
                return 'fa-edit';
            case self::TYPE_DELETE:
                return 'fa-trash';
            case self::TYPE_VERIFY:
                return 'fa-check-circle';
            default:
                return 'fa-history';
        }
    }

    /**
     * Cek apakah log aktivitas ini berisi perubahan data
     *
     * @return bool
     */
    public function hasPerubahanData(): bool
    {
        return !empty($this->getPerubahan());
    }

    /**
     * Dapatkan judul yang mudah dibaca untuk model yang terkait
     *
     * @return string|null
     */
    public function getLoggableTitle(): ?string
    {
        if (!$this->loggable) {
            return null;
        }

        if (method_exists($this->loggable, 'getActivityLogTitle')) {
            return $this->loggable->getActivityLogTitle();
        }

        return class_basename($this->loggable_type) . ' #' . $this->loggable_id;
    }

    /**
     * Log aktivitas login
     *
     * @param User $user User yang login
     * @param string $ipAddress IP address
     * @param string $userAgent User agent
     * @return AktivitasLog
     */
    public static function logLogin($user, $ipAddress = null, $userAgent = null)
    {
        return self::create([
            'user_id' => $user->id,
            'tipe' => self::TYPE_LOGIN,
            'judul' => 'Login ke Sistem',
            'deskripsi' => 'Login ke sistem',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }

    /**
     * Log aktivitas logout
     *
     * @param User $user User yang logout
     * @param string $ipAddress IP address
     * @param string $userAgent User agent
     * @return AktivitasLog
     */
    public static function logLogout($user, $ipAddress = null, $userAgent = null)
    {
        return self::create([
            'user_id' => $user->id,
            'tipe' => self::TYPE_LOGOUT,
            'judul' => 'Logout dari Sistem',
            'deskripsi' => 'Logout dari sistem',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }

    /**
     * Log aktivitas CRUD
     *
     * @param User $user User yang melakukan aktivitas
     * @param string $tipe Tipe aktivitas (create, update, delete, verify)
     * @param string $judul Judul aktivitas
     * @param string $deskripsi Deskripsi aktivitas
     * @param Model|null $model Model yang terkait aktivitas
     * @param array $data Data terkait aktivitas
     * @param string $ipAddress IP address
     * @param string $userAgent User agent
     * @return AktivitasLog
     */
    public static function log($user, $tipe, $judul, $deskripsi, $model = null, $data = [], $ipAddress = null, $userAgent = null)
    {
        $logData = [
            'user_id' => $user ? $user->id : null,
            'tipe' => $tipe,
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'data' => is_array($data) ? $data : [], // Memastikan data adalah array
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ];

        if ($model && is_object($model)) {
            $logData['loggable_type'] = get_class($model);
            $logData['loggable_id'] = $model->getKey();
        }

        return self::create($logData);
    }
}
