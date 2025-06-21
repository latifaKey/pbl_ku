<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AktivitasLog;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Verifikasi apakah user ada di database
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Log untuk debugging
                Log::warning('Login attempt failed: User not found', [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                // Regenerasi token CSRF untuk menghindari error 419
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Email tidak ditemukan. Silakan periksa kembali email Anda.');
            }

            // Menyiapkan kredensial
            $credentials = $request->only('email', 'password');

            // Cek kredensial dan login
            if (Auth::attempt($credentials)) {
                // Regenerasi session untuk menghindari serangan session fixation
                $request->session()->regenerate();

                // Log sukses login
                Log::info('User logged in successfully', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role,
                    'ip' => $request->ip()
                ]);

                // Cek apakah role pengguna diperbolehkan
                $allowedRoles = [
                    'asisten_manager',
                    'pic_keuangan',
                    'pic_manajemen_risiko',
                    'pic_sekretaris_perusahaan',
                    'pic_perencanaan_operasi',
                    'pic_pengembangan_bisnis',
                    'pic_human_capital',
                    'pic_k3l',
                    'pic_perencanaan_korporat',
                    'pic_hukum',
                    'karyawan',
                ];

                // Jika role valid, arahkan ke dashboard sesuai role
                if (in_array(Auth::user()->role, $allowedRoles)) {
                    return $this->redirectBasedOnRole();
                }

                // Jika role tidak diperbolehkan
                Log::warning('Login attempt failed: Invalid role', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role,
                    'ip' => $request->ip()
                ]);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Role Anda tidak diizinkan untuk login.');
            }

            // Log password salah
            Log::warning('Login attempt failed: Invalid password', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Regenerasi token CSRF untuk menghindari error 419
            $request->session()->regenerateToken();

            // Jika login gagal
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah. Silakan coba lagi.');

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage(), [
                'email' => $request->email,
                'ip' => $request->ip(),
                'trace' => $e->getTraceAsString()
            ]);

            // Regenerasi token CSRF untuk menghindari error 419
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    /**
     * Redirect berdasarkan role user
     */
    private function redirectBasedOnRole()
    {
        // Semua role diarahkan ke dashboard utama yang akan menangani pengarahan berdasarkan role
        return redirect()->route('dashboard');
    }

    /**
     * Logout pengguna
     */
    public function logout(Request $request)
    {
        // Catat aktivitas logout
        if (Auth::check()) {
            AktivitasLog::logLogout(
                Auth::user(),
                $request->ip(),
                $request->userAgent()
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
