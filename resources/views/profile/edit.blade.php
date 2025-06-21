@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page_title', 'EDIT PROFIL')

@section('styles')
<link rel="stylesheet" href="{{ asset('pln-animations.css') }}">
<style>
    .profile-container {
        background: var(--pln-accent-bg);
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1),
                    0 5px 15px rgba(0, 123, 255, 0.1),
                    inset 0 -2px 2px rgba(255, 255, 255, 0.08);
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border);
        transition: all 0.4s ease;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        background: linear-gradient(135deg, var(--pln-surface), rgba(255, 255, 255, 0.05));
        padding: 20px 25px;
        border-radius: 12px;
        border-left: 5px solid var(--pln-blue);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.1), transparent 70%);
        z-index: 1;
    }

    .profile-title {
        margin: 0;
        font-size: 1.5rem;
        color: var(--pln-blue);
        font-weight: 700;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .profile-subtitle {
        font-size: 1rem;
        color: var(--pln-text-secondary);
        margin-top: 8px;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .profile-subtitle i {
        background: rgba(0, 123, 255, 0.1);
        padding: 5px;
        border-radius: 50%;
        margin-right: 5px;
        transition: all 0.3s ease;
    }

    .profile-photo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid var(--pln-border);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        background: var(--pln-surface);
        overflow: hidden;
    }

    .profile-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-photo-upload {
        position: relative;
        overflow: hidden;
        display: inline-block;
        cursor: pointer;
        margin-top: 15px;
    }

    .profile-photo-upload input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .profile-form-container {
        background: var(--pln-surface);
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--pln-border);
    }

    .form-label {
        font-weight: 600;
        color: var(--pln-text);
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border: 1px solid var(--pln-border);
        padding: 12px 15px;
        border-radius: 8px;
        background: var(--pln-accent-bg);
        color: var(--pln-text);
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 20px;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        border-color: var(--pln-light-blue);
        outline: none;
    }

    .profile-save-btn {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        border: none;
        border-radius: 30px;
        padding: 12px 25px;
        font-weight: 600;
        color: white;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        margin-top: 10px;
    }

    .profile-save-btn i {
        margin-right: 8px;
        transition: all 0.3s ease;
    }

    .profile-save-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
    }

    .profile-save-btn:hover i {
        transform: translateX(-3px);
    }

    .profile-save-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }

    .profile-save-btn:hover::before {
        left: 100%;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--pln-blue);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--pln-border);
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 60px;
        height: 2px;
        background: var(--pln-blue);
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }

    .form-group {
        flex: 1;
    }

    .alert {
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border-left: 4px solid #28a745;
        color: #28a745;
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .profile-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row fade-in-up">
        <div class="col-md-12">
            <div class="profile-container glass-morphism shadow-soft">
                <div class="profile-header">
                    <div>
                        <h4 class="profile-title">
                            <i class="fas fa-user-edit mr-2"></i> Kelola Profil Anda
                        </h4>
                        <p class="profile-subtitle">
                            <i class="fas fa-info-circle"></i> Perbarui informasi profil dan preferensi akun Anda di sini
                        </p>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success fade-in">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
                @endif

                <div class="row">
                    <div class="col-md-3">
                        <div class="profile-photo-container fade-in-up">
                            <div class="profile-photo">
                                @if($user->profile_photo)
                                    <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}" />
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--pln-accent-bg);">
                                        <i class="fas fa-user" style="font-size: 64px; color: var(--pln-text-secondary);"></i>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="profile-photo-upload mt-3">
                                    <input type="file" name="profile_photo" id="profile_photo" onchange="this.form.submit()">
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('profile_photo').click();">
                                        <i class="fas fa-camera mr-2"></i> Ubah Foto
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <small class="text-muted">Klik untuk mengunggah foto baru</small>
                                <p class="mb-0 mt-3"><strong>{{ $user->name }}</strong></p>
                                <p class="text-muted">{{ $user->role }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="profile-form-container fade-in-up delay-100">
                            <h5 class="section-title">Informasi Pribadi</h5>

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <h5 class="section-title mt-4">Ubah Password</h5>
                                <small class="text-muted mb-3 d-block">Kosongkan kolom password jika tidak ingin mengubahnya</small>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="profile-save-btn">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Efek hover pada sections
        $('.profile-form-container').hover(
            function() {
                $(this).css('transform', 'translateY(-5px)');
                $(this).css('box-shadow', '0 15px 40px rgba(0, 0, 0, 0.1)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
                $(this).css('box-shadow', '0 5px 20px rgba(0, 0, 0, 0.05)');
            }
        );

        // Preview gambar saat dipilih
        $('#profile_photo').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.profile-photo img').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
