<?php

namespace App\Traits;

use App\Models\AktivitasLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait ActivityLoggable
{
    /**
     * Boot trait
     */
    protected static function bootActivityLoggable()
    {
        // Rekam aktivitas saat model dibuat
        static::created(function (Model $model) {
            if (!$model->shouldLogActivity()) return;

            // Dapatkan user yang melakukan aktivitas
            $user = Auth::user();
            $request = request();

            AktivitasLog::log(
                $user,
                AktivitasLog::TYPE_CREATE,
                'Buat ' . $model->getActivityLogTitle(),
                'Membuat ' . class_basename($model) . ' baru',
                $model,
                ['attributes' => $model->getActivityLogAttributes()],
                $request ? $request->ip() : null,
                $request ? $request->userAgent() : null
            );
        });

        // Rekam aktivitas saat model diupdate
        static::updated(function (Model $model) {
            if (!$model->shouldLogActivity()) return;

            // Jika tidak ada perubahan, skip
            if (empty($model->getDirty())) return;

            // Dapatkan user yang melakukan aktivitas
            $user = Auth::user();
            $request = request();

            // Hanya log atribut yang diubah
            $changed = $model->getDirty();
            $old = [];

            foreach ($changed as $key => $value) {
                $old[$key] = $model->getOriginal($key);
            }

            AktivitasLog::log(
                $user,
                AktivitasLog::TYPE_UPDATE,
                'Update ' . $model->getActivityLogTitle(),
                'Memperbarui ' . class_basename($model) . ' #' . $model->getKey(),
                $model,
                [
                    'attributes' => $changed,
                    'old' => $old,
                ],
                $request ? $request->ip() : null,
                $request ? $request->userAgent() : null
            );
        });

        // Rekam aktivitas saat model dihapus
        static::deleted(function (Model $model) {
            if (!$model->shouldLogActivity()) return;

            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return; // Hindari double logging untuk soft delete
            }

            // Dapatkan user yang melakukan aktivitas
            $user = Auth::user();
            $request = request();

            AktivitasLog::log(
                $user,
                AktivitasLog::TYPE_DELETE,
                'Hapus ' . $model->getActivityLogTitle(),
                'Menghapus ' . class_basename($model) . ' #' . $model->getKey(),
                $model,
                ['attributes' => $model->getActivityLogAttributes()],
                $request ? $request->ip() : null,
                $request ? $request->userAgent() : null
            );
        });
    }

    /**
     * Menentukan apakah aktivitas model ini perlu dilog
     *
     * @return bool
     */
    public function shouldLogActivity()
    {
        return config('aktivitas_log.enabled', true);
    }

    /**
     * Mendapatkan judul untuk log aktivitas
     *
     * @return string
     */
    public function getActivityLogTitle()
    {
        return method_exists($this, 'getActivityTitle')
            ? $this->getActivityTitle()
            : class_basename($this) . ' #' . $this->getKey();
    }

    /**
     * Mendapatkan atribut untuk dicatat dalam log
     *
     * @return array
     */
    public function getActivityLogAttributes()
    {
        return $this->getAttributes();
    }

    /**
     * Log aktivitas verifikasi model
     *
     * @param string $deskripsi
     * @param array $data
     * @return void
     */
    public function logVerify($deskripsi = null, $data = [])
    {
        $user = Auth::user();
        $request = request();

        if (!$deskripsi) {
            $deskripsi = 'Verifikasi ' . class_basename($this) . ' #' . $this->getKey();
        }

        AktivitasLog::log(
            $user,
            AktivitasLog::TYPE_VERIFY,
            'Verifikasi ' . $this->getActivityLogTitle(),
            $deskripsi,
            $this,
            $data,
            $request ? $request->ip() : null,
            $request ? $request->userAgent() : null
        );
    }

    /**
     * Log aktivitas kustom
     *
     * @param string $tipe
     * @param string $judul
     * @param string $deskripsi
     * @param array $data
     * @return void
     */
    public function logAktivitas($tipe, $judul, $deskripsi, $data = [])
    {
        $user = Auth::user();
        $request = request();

        AktivitasLog::log(
            $user,
            $tipe,
            $judul,
            $deskripsi,
            $this,
            $data,
            $request ? $request->ip() : null,
            $request ? $request->userAgent() : null
        );
    }
}
