@extends('layouts.app')

@section('title', 'Tambah Akun Baru - PLN')
@section('page_title', 'TAMBAH AKUN')

@section('styles')
<style>
    .form-container {
        background: rgba(10, 77, 133, 0.15);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        margin: 0 auto;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .form-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        text-align: center;
    }

    .form-title {
        font-size: 1.8rem;
        color: #fff;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .form-subtitle {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 12px 15px;
        border-radius: 8px;
        color: white;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--pln-light-blue);
        background: rgba(255, 255, 255, 0.08);
        outline: none;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .btn-primary {
        background: var(--pln-light-blue);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 156, 222, 0.3);
    }

    .btn-primary:hover {
        background: #0094d3;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 156, 222, 0.4);
    }

    .form-validation-error {
        color: #f44336;
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="form-container">
    <div class="form-header">
        <h2 class="form-title">Tambah Akun Baru</h2>
        <p class="form-subtitle">Silakan isi form berikut untuk menambahkan akun baru ke sistem</p>
    </div>

    @if ($errors->any())
    <div class="alert-danger mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('akun.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                   placeholder="Masukkan nama lengkap" required>
            @error('name')
                <span class="form-validation-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}"
                   placeholder="contoh@email.com" required>
            @error('email')
                <span class="form-validation-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="Minimal 8 karakter" required>
            @error('password')
                <span class="form-validation-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                   placeholder="Ketik ulang password" required>
            @error('password_confirmation')
                <span class="form-validation-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="role" class="form-label">Peran</label>
            <select id="role" name="role" class="form-control form-select" required>
                <option value="">-- Pilih Peran --</option>
                <option value="asisten_manager" {{ old('role') == 'asisten_manager' ? 'selected' : '' }}>Asisten Manager</option>
                <option value="pic_keuangan" {{ old('role') == 'pic_keuangan' ? 'selected' : '' }}>PIC Bidang Keuangan</option>
                <option value="pic_manajemen_risiko" {{ old('role') == 'pic_manajemen_risiko' ? 'selected' : '' }}>PIC Manajemen Risiko</option>
                <option value="pic_sekretaris_perusahaan" {{ old('role') == 'pic_sekretaris_perusahaan' ? 'selected' : '' }}>PIC Sekretaris Perusahaan</option>
                <option value="pic_perencanaan_operasi" {{ old('role') == 'pic_perencanaan_operasi' ? 'selected' : '' }}>PIC Perencanaan Operasi</option>
                <option value="pic_pengembangan_bisnis" {{ old('role') == 'pic_pengembangan_bisnis' ? 'selected' : '' }}>PIC Pengembangan Bisnis</option>
                <option value="pic_human_capital" {{ old('role') == 'pic_human_capital' ? 'selected' : '' }}>PIC Human Capital</option>
                <option value="pic_k3l" {{ old('role') == 'pic_k3l' ? 'selected' : '' }}>PIC K3L</option>
                <option value="pic_perencanaan_korporat" {{ old('role') == 'pic_perencanaan_korporat' ? 'selected' : '' }}>PIC Perencanaan Korporat</option>
                <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
            @error('role')
                <span class="form-validation-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('akun.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
