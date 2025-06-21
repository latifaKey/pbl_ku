<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AktivitasLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    /**
     * Konstruktor - hanya Master Admin yang bisa mengakses
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
     * Menampilkan daftar semua akun pengguna
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Default 10 per page, bisa diubah
        $users = User::orderBy('name')
            ->when($request->input('search'), function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('role', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        // Pastikan setiap user memiliki nama yang valid
        $users->getCollection()->transform(function ($user) {
            if (empty($user->name)) {
                $user->name = 'Pengguna #' . $user->id;
            }
            return $user;
        });

        return view('akun.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat akun baru
     */
    public function create()
    {
        // Array daftar role yang diizinkan
        $availableRoles = [
            'asisten_manager' => 'Asisten Manager',
            'pic_keuangan' => 'PIC Keuangan',
            'pic_manajemen_risiko' => 'PIC Manajemen Risiko',
            'pic_sekretaris_perusahaan' => 'PIC Sekretaris Perusahaan',
            'pic_perencanaan_operasi' => 'PIC Perencanaan Operasi',
            'pic_pengembangan_bisnis' => 'PIC Pengembangan Bisnis',
            'pic_human_capital' => 'PIC Human Capital',
            'pic_k3l' => 'PIC K3L',
            'pic_perencanaan_korporat' => 'PIC Perencanaan Korporat',
            'karyawan' => 'Karyawan'
        ];

        return view('akun.create', compact('availableRoles'));
    }

    /**
     * Menyimpan akun baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:asisten_manager,pic_keuangan,pic_manajemen_risiko,pic_sekretaris_perusahaan,pic_perencanaan_operasi,pic_pengembangan_bisnis,pic_human_capital,pic_k3l,pic_perencanaan_korporat,karyawan',
        ]);

        try {
            // Periksa apakah koneksi database sudah benar
            if (!\DB::connection()->getPdo()) {
                throw new \Exception('Database connection failed');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Verifikasi apakah user benar-benar dibuat
            $createdUser = User::find($user->id);
            if (!$createdUser) {
                throw new \Exception('User was not properly created in the database');
            }

            // Catat log aktivitas
            AktivitasLog::log(
                Auth::user(),
                'create',
                'Membuat akun baru: ' . $user->name . ' (' . $user->role . ')',
                'Menambahkan akun pengguna baru',
                $user,
                [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                $request->ip(),
                $request->userAgent()
            );

            return redirect()->route('akun.index')->with('success', 'Akun berhasil dibuat.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error creating user account: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return redirect()->back()->with('error', 'Gagal membuat akun: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail akun pengguna
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('akun.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit akun
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Array daftar role yang diizinkan
        $availableRoles = [
            'asisten_manager' => 'Asisten Manager',
            'pic_keuangan' => 'PIC Keuangan',
            'pic_manajemen_risiko' => 'PIC Manajemen Risiko',
            'pic_sekretaris_perusahaan' => 'PIC Sekretaris Perusahaan',
            'pic_perencanaan_operasi' => 'PIC Perencanaan Operasi',
            'pic_pengembangan_bisnis' => 'PIC Pengembangan Bisnis',
            'pic_human_capital' => 'PIC Human Capital',
            'pic_k3l' => 'PIC K3L',
            'pic_perencanaan_korporat' => 'PIC Perencanaan Korporat',
            'karyawan' => 'Karyawan'
        ];

        return view('akun.edit', compact('user', 'availableRoles'));
    }

    /**
     * Update akun pengguna
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:asisten_manager,pic_keuangan,pic_manajemen_risiko,pic_sekretaris_perusahaan,pic_perencanaan_operasi,pic_pengembangan_bisnis,pic_human_capital,pic_k3l,pic_perencanaan_korporat,karyawan',
        ];

        // Tambahkan validasi password hanya jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        try {
            // Simpan data lama untuk log
            $oldRole = $user->role;

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ];

            // Update password jika ada
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            // Verifikasi apakah update berhasil
            $updatedUser = User::find($user->id);
            if (!$updatedUser || $updatedUser->name !== $request->name || $updatedUser->email !== $request->email || $updatedUser->role !== $request->role) {
                throw new \Exception('User data was not properly updated in the database');
            }

            // Catat log aktivitas
            AktivitasLog::log(
                Auth::user(),
                'update',
                'Mengupdate akun: ' . $user->name,
                'Mengubah data akun pengguna',
                $user,
                [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role_lama' => $oldRole,
                    'role_baru' => $user->role,
                    'password_diubah' => $request->filled('password'),
                ],
                $request->ip(),
                $request->userAgent()
            );

            return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error updating user account: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return redirect()->back()->with('error', 'Gagal memperbarui akun: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus akun pengguna
     */
    public function destroy(Request $request, $id)
    {
        // Cek jika user mencoba menghapus dirinya sendiri
        if (Auth::id() == $id) {
            return redirect()->route('akun.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $userName = $user->name;
        $userRole = $user->role;

        // Hapus user
        $user->delete();

        // Catat log aktivitas
        AktivitasLog::log(
            Auth::user(),
            'delete',
            'Menghapus akun: ' . $userName . ' (' . $userRole . ')',
            'Menghapus akun pengguna dari sistem',
            null,
            [
                'user_id' => $id,
                'role' => $userRole,
            ],
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
