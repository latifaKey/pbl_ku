@extends('layouts.app')

@section('content')
<style>
    .custom-form {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', sans-serif;
    }

    .custom-form h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ccc;
        border-radius: 0.6rem;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #0d6efd;
        outline: none;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
    }

    .form-actions button {
        background-color: #198754;
        color: white;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 0.6rem;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-actions button:hover {
        background-color: #157347;
    }
</style>

<div class="custom-form">
    <h2>Edit Akun</h2>

    <form action="{{ route('akun.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $user->name) }}"
                   placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email', $user->email) }}"
                   placeholder="contoh@email.com" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Biarkan kosong jika tidak diubah">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   placeholder="Biarkan kosong jika tidak diubah">
        </div>

        <div class="form-group">
            <label for="role">Peran</label>
            <select id="role" name="role" required>
                <option value="">-- Pilih Peran --</option>
                <option value="asisten_manager" {{ old('role', $user->role) == 'asisten_manager' ? 'selected' : '' }}>Asisten Manager</option>
                <option value="pic_keuangan" {{ old('role', $user->role) == 'pic_keuangan' ? 'selected' : '' }}>PIC Bidang Keuangan</option>
                <option value="pic_manajemen_risiko" {{ old('role', $user->role) == 'pic_manajemen_risiko' ? 'selected' : '' }}>PIC Manajemen Risiko</option>
                <option value="pic_sekretaris_perusahaan" {{ old('role', $user->role) == 'pic_sekretaris_perusahaan' ? 'selected' : '' }}>PIC Sekretaris Perusahaan</option>
                <option value="pic_perencanaan_operasi" {{ old('role', $user->role) == 'pic_perencanaan_operasi' ? 'selected' : '' }}>PIC Perencanaan Operasi</option>
                <option value="pic_pengembangan_bisnis" {{ old('role', $user->role) == 'pic_pengembangan_bisnis' ? 'selected' : '' }}>PIC Pengembangan Bisnis</option>
                <option value="pic_human_capital" {{ old('role', $user->role) == 'pic_human_capital' ? 'selected' : '' }}>PIC Human Capital</option>
                <option value="pic_k3l" {{ old('role', $user->role) == 'pic_k3l' ? 'selected' : '' }}>PIC K3L</option>
                <option value="pic_perencanaan_korporat" {{ old('role', $user->role) == 'pic_perencanaan_korporat' ? 'selected' : '' }}>PIC Perencanaan Korporat</option>
                <option value="karyawan" {{ old('role', $user->role) == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit">Update</button>
        </div>
    </form>
</div>
@endsection
