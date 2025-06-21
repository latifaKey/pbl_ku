<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update data profil pengguna
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Log untuk debugging
        \Log::info('Profile update request received', [
            'user_id' => $user->id,
            'has_password' => $request->has('password'),
            'update_type' => $request->input('update_type'),
            'request_method' => $request->method(),
            'password_length' => $request->has('password') ? strlen($request->input('password')) : 0
        ]);

        // Jika ini adalah update password
        if ($request->input('update_type') === 'password') {
            \Log::info('Password update requested', ['user_id' => $user->id]);

            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $plainPassword = $request->input('password');

            // Hashing password secara langsung menggunakan Hash facade
            $hashedPassword = Hash::make($plainPassword);

            // Debug password yang di-hash
            \Log::info('Password hashed', [
                'user_id' => $user->id,
                'hash_length' => strlen($hashedPassword)
            ]);

            // Update password langsung ke database untuk memastikan
            DB::table('users')
                ->where('id', $user->id)
                ->update(['password' => $hashedPassword]);

            // Verifikasi bahwa password baru dapat digunakan untuk autentikasi
            if (Hash::check($plainPassword, $hashedPassword)) {
                \Log::info('Password hash verification successful');
            } else {
                \Log::error('Password hash verification failed');
            }

            // Refresh user dari database untuk memastikan perubahan terlihat
            $user = User::find($user->id);
            Auth::setUser($user);

            // Clear auth dan session cache
            Auth::logoutOtherDevices($plainPassword);

            // Log bahwa password sudah diupdate
            \Log::info('Password has been updated directly in database', ['user_id' => $user->id]);

            // Flash message yang lebih eksplisit dengan withInput() untuk mempertahankan session
            $request->session()->flash('success', 'Password berhasil diperbarui. Silakan logout dan login kembali dengan password baru Anda.');
            \Log::info('Flash message set');

            return redirect()->back();
        }
        // Jika ini adalah update profil biasa
        else {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            ]);

            // Update data lainnya
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            \Log::info('Profile updated successfully', ['user_id' => $user->id]);
            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        }
    }

    /**
     * Update foto profil pengguna
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Upload foto baru
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
    }
}
