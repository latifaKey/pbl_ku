<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class AktivitasLogController extends Controller
{
    /**
     * Constructor untuk menerapkan middleware role
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'asisten_manager') {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar log aktivitas
     */
    public function index(Request $request)
    {
        $query = AktivitasLog::with('user');

        // Filter berdasarkan user
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan tipe
        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan model
        if ($request->has('model_type') && $request->model_type != '') {
            $query->where('loggable_type', $request->model_type);
        }

        // Filter berdasarkan kata kunci
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = '%' . $request->keyword . '%';
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', $keyword)
                  ->orWhere('deskripsi', 'like', $keyword)
                  ->orWhereHas('user', function($userQuery) use ($keyword) {
                      $userQuery->where('name', 'like', $keyword);
                  });
            });
        }

        // Ambil data dengan pagination
        $perPage = $request->input('per_page', 15); // Default 15 log per halaman jika tidak ditentukan
        $logs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $users = User::orderBy('name')->get();
        $tipes = [
            AktivitasLog::TYPE_LOGIN,
            AktivitasLog::TYPE_LOGOUT,
            AktivitasLog::TYPE_CREATE,
            AktivitasLog::TYPE_UPDATE,
            AktivitasLog::TYPE_DELETE,
            AktivitasLog::TYPE_VERIFY
        ];

        // Dapatkan model types yang tersedia
        $modelTypes = AktivitasLog::select('loggable_type')
            ->distinct()
            ->whereNotNull('loggable_type')
            ->pluck('loggable_type');

        // Statistik untuk dashboard
        $stats = $this->getStatistikAktivitas();

        return view('aktivitasLog.index', compact('logs', 'users', 'tipes', 'modelTypes', 'stats'));
    }

    /**
     * Menampilkan detail log aktivitas
     */
    public function show($id)
    {
        $log = AktivitasLog::with(['user', 'loggable'])->findOrFail($id);
        return view('aktivitasLog.show', compact('log'));
    }

    /**
     * Mengekspor log aktivitas ke CSV
     */
    public function eksporCsv(Request $request)
    {
        $query = AktivitasLog::with('user');

        // Filter berdasarkan user
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan tipe
        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan model
        if ($request->has('model_type') && $request->model_type != '') {
            $query->where('loggable_type', $request->model_type);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        // Buat filename untuk CSV
        $filename = 'log_aktivitas_' . date('Y-m-d_His') . '.csv';

        // Header untuk file CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Buat callback untuk menghasilkan konten CSV
        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, ['ID', 'User', 'Tipe', 'Judul', 'Deskripsi', 'Model', 'Data', 'IP Address', 'User Agent', 'Waktu']);

            // Data CSV
            foreach ($logs as $log) {
                $modelInfo = $log->loggable_type && $log->loggable_id
                    ? class_basename($log->loggable_type) . ' #' . $log->loggable_id
                    : '';

                fputcsv($file, [
                    $log->id,
                    $log->user ? $log->user->name : 'Tidak Ada',
                    $log->tipe,
                    $log->judul,
                    $log->deskripsi,
                    $modelInfo,
                    $log->data ? json_encode($log->data) : '',
                    $log->ip_address,
                    $log->user_agent,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, Response::HTTP_OK, $headers);
    }

    /**
     * Menghapus log aktivitas yang lebih lama dari periode tertentu
     */
    public function hapusLogLama(Request $request)
    {
        $request->validate([
            'periode' => 'required|in:1,3,6,12',
        ]);

        $periode = (int) $request->periode;
        $cutoffDate = Carbon::now()->subMonths($periode);

        $count = AktivitasLog::where('created_at', '<', $cutoffDate)->count();
        AktivitasLog::where('created_at', '<', $cutoffDate)->delete();

        return redirect()->route('aktivitasLog.index')->with('success', "$count log aktivitas berhasil dihapus.");
    }

    /**
     * Menghapus log aktivitas individual
     */
    public function destroy($id)
    {
        $log = AktivitasLog::findOrFail($id);
        $log->delete();

        return redirect()->route('aktivitasLog.index')->with('success', 'Log aktivitas berhasil dihapus.');
    }

    /**
     * Menghapus multiple log aktivitas sekaligus
     */
    public function hapusMultiple(Request $request)
    {
        $request->validate([
            'log_ids' => 'required|array',
            'log_ids.*' => 'required|integer|exists:aktivitas_logs,id',
        ]);

        $count = AktivitasLog::whereIn('id', $request->log_ids)->count();
        AktivitasLog::whereIn('id', $request->log_ids)->delete();

        return redirect()->route('aktivitasLog.index')->with('success', "$count log aktivitas berhasil dihapus.");
    }

    /**
     * Static method untuk mencatat log aktivitas
     */
    public static function log(User $user, string $tipe, string $pesan, array $data = null, string $ip = null, string $userAgent = null)
    {
        AktivitasLog::create([
            'user_id' => $user->id,
            'tipe' => $tipe,
            'pesan' => $pesan,
            'data' => $data,
            'ip' => $ip,
            'user_agent' => $userAgent,
        ]);
    }

    /**
     * Mendapatkan statistik aktivitas untuk dashboard
     *
     * @return array
     */
    private function getStatistikAktivitas(): array
    {
        $stats = [];

        // Total aktivitas
        $stats['total'] = AktivitasLog::count();

        // Aktivitas hari ini
        $stats['today'] = AktivitasLog::whereDate('created_at', Carbon::today())->count();

        // Aktivitas minggu ini
        $stats['week'] = AktivitasLog::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Aktivitas bulan ini
        $stats['month'] = AktivitasLog::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Tipe aktivitas (untuk chart)
        $tipeCounts = AktivitasLog::select('tipe', DB::raw('count(*) as count'))
            ->groupBy('tipe')
            ->get()
            ->pluck('count', 'tipe')
            ->toArray();
        $stats['tipe_counts'] = $tipeCounts;

        // Aktivitas per user (top 5)
        $userCounts = AktivitasLog::select('user_id', DB::raw('count(*) as count'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        foreach ($userCounts as $userCount) {
            $user = User::find($userCount->user_id);
            if ($user) {
                $stats['user_counts'][] = [
                    'name' => $user->name,
                    'count' => $userCount->count
                ];
            }
        }

        // Aktivitas per hari (7 hari terakhir untuk line chart)
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = AktivitasLog::whereDate('created_at', $date->format('Y-m-d'))->count();
            $dailyStats[] = [
                'date' => $date->format('d/m'),
                'count' => $count
            ];
        }
        $stats['daily'] = $dailyStats;

        return $stats;
    }
}
