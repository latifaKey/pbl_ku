@extends('layouts.app')

@section('title', 'Tambah Tahun Penilaian')
@section('page_title', 'TAMBAH TAHUN PENILAIAN')

@section('styles')
<style>
    /* Gaya dasar untuk container */
    .container {
        padding: 30px;
        margin: 20px auto;
        background: var(--pln-accent-bg);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1),
                    0 5px 15px rgba(0, 123, 255, 0.1),
                    inset 0 -2px 2px rgba(255, 255, 255, 0.08);
        border: 1px solid var(--pln-border);
        transition: all 0.4s ease;
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    /* Glassmorphism effect dengan highlight gradient */
    .container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue), var(--pln-blue));
        background-size: 200% 100%;
        animation: gradientShift 8s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Gaya untuk judul */
    .tahun-title {
        margin-bottom: 20px;
        color: var(--pln-text);
        font-weight: 700;
        font-size: 24px;
        position: relative;
        padding-left: 16px;
        animation: fadeInLeft 0.6s ease-out;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .tahun-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 80%;
        background: linear-gradient(to bottom, var(--pln-blue), var(--pln-light-blue));
        border-radius: 4px;
    }

    /* Efek ripple untuk tombol */
    .ripple {
        position: absolute;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Form Container */
    .form-container {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 16px;
        border: 1px solid var(--pln-border);
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        animation: fadeIn 0.6s ease-out;
    }

    .form-container::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--pln-border), transparent);
    }

    /* Form styling */
    .form-group {
        margin-bottom: 20px;
        position: relative;
        animation: fadeInUp 0.4s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-label {
        font-weight: 600;
        color: var(--pln-text);
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--pln-border);
        padding: 12px 15px;
        border-radius: 12px;
        color: var(--pln-text);
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        border-color: var(--pln-light-blue);
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.15), inset 0 2px 4px rgba(0, 0, 0, 0.05);
        outline: none;
    }

    .form-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--pln-border);
        padding: 12px 15px;
        border-radius: 12px;
        color: var(--pln-text);
        width: 100%;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
        padding-right: 40px;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .form-select:focus {
        border-color: var(--pln-light-blue);
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.15), inset 0 2px 4px rgba(0, 0, 0, 0.05);
        outline: none;
    }

    .form-text {
        font-size: 12px;
        color: var(--pln-text-secondary);
        margin-top: 5px;
    }

    /* Checkbox styling */
    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        position: relative;
        padding-left: 30px;
        cursor: pointer;
    }

    .form-check-input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--pln-border);
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .form-check:hover .checkmark {
        border-color: var(--pln-light-blue);
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.1);
    }

    .form-check-input:checked ~ .checkmark {
        background: linear-gradient(135deg, var(--pln-light-blue), var(--pln-blue));
        border-color: transparent;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .form-check-input:checked ~ .checkmark:after {
        display: block;
    }

    .form-check-label {
        color: var(--pln-text);
        font-size: 14px;
        font-weight: 500;
        margin-left: 10px;
        user-select: none;
    }

    /* Button styling */
    .btn {
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
        margin-right: 10px;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-3px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--pln-light-blue), var(--pln-blue));
        color: white;
        box-shadow: 0 4px 15px rgba(0, 156, 222, 0.3);
    }

    .btn-primary:hover {
        box-shadow: 0 8px 25px rgba(0, 156, 222, 0.5);
    }

    .btn-primary:hover i {
        transform: scale(1.2);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: var(--pln-text);
        border: 1px solid var(--pln-border);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary:hover i {
        transform: rotate(90deg);
    }

    /* Gaya untuk alert */
    .alert {
        border-radius: 10px !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        padding: 1rem 1.25rem !important;
        margin-bottom: 1.5rem !important;
        position: relative !important;
        overflow: hidden !important;
        animation: slideInDown 0.5s ease-out;
    }

    .alert::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1) !important;
        color: var(--error-color) !important;
    }

    .alert-danger::before {
        background-color: var(--error-color) !important;
    }

    /* Animation */
    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Button Bar Animation */
    .button-bar {
        display: flex;
        align-items: center;
        margin-top: 30px;
        position: relative;
        padding-top: 20px;
        animation: fadeIn 0.8s ease-out;
    }

    .button-bar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--pln-border), transparent);
    }

    /* Create Form Animation */
    .create-form {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, var(--pln-light-blue), var(--pln-blue));
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: content-box;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #0094d3, var(--pln-blue));
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }

        .form-container {
            padding: 20px;
        }

        .button-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn {
            margin-bottom: 10px;
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .form-label, .form-check-label, .btn {
            font-size: 13px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2 class="tahun-title">Form Tambah Tahun Penilaian</h2>

    <div class="mb-4">
        <a href="{{ route('tahunPenilaian.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('tahunPenilaian.store') }}" method="POST" class="create-form">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="tahun" name="tahun" min="2020" max="2100"
                               value="{{ old('tahun', date('Y')) }}" required>
                        <small class="form-text">Tahun berupa angka 4 digit, minimal 2020</small>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2">{{ old('deskripsi') }}</textarea>
                        <small class="form-text">Berikan deskripsi singkat untuk tahun penilaian ini</small>
                    </div>

                    <div class="form-group">
                        <label for="tipe_periode" class="form-label">Tipe Periode <span class="text-danger">*</span></label>
                        <select class="form-select" id="tipe_periode" name="tipe_periode" required>
                            <option value="tahunan" {{ old('tipe_periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                            <option value="semesteran" {{ old('tipe_periode') == 'semesteran' ? 'selected' : '' }}>Semesteran</option>
                            <option value="triwulanan" {{ old('tipe_periode') == 'triwulanan' ? 'selected' : '' }}>Triwulanan</option>
                            <option value="bulanan" {{ old('tipe_periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                        <small class="form-text">Pilih tipe periode untuk penilaian KPI</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                               value="{{ old('tanggal_mulai') }}">
                        <small class="form-text">Jika dikosongkan, akan diisi otomatis berdasarkan tipe periode</small>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                               value="{{ old('tanggal_selesai') }}">
                        <small class="form-text">Jika dikosongkan, akan diisi otomatis berdasarkan tipe periode</small>
                    </div>

                    <div class="form-group">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_aktif" name="is_aktif" value="1"
                                   {{ old('is_aktif') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="form-check-label">Jadikan sebagai tahun aktif</span>
                        </label>
                        <small class="form-text">Jika dicentang, tahun lain yang aktif akan dinonaktifkan</small>
                    </div>

                    <div class="form-group">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_locked" name="is_locked" value="1"
                                   {{ old('is_locked') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="form-check-label">Kunci periode penilaian</span>
                        </label>
                        <small class="form-text">Jika dicentang, data periode ini tidak dapat diubah kecuali oleh Master Admin</small>
                    </div>
                </div>
            </div>

            <div class="button-bar">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('tahunPenilaian.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika untuk mengatur tanggal otomatis berdasarkan tipe periode yang dipilih
        const tipePeriodeSelect = document.getElementById('tipe_periode');
        const tahunInput = document.getElementById('tahun');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalSelesaiInput = document.getElementById('tanggal_selesai');

        tipePeriodeSelect.addEventListener('change', function() {
            const tahun = tahunInput.value;
            if (!tahun || isNaN(tahun) || tahun < 2020) return;

            // Hanya isi otomatis jika kedua field tanggal kosong
            if (!tanggalMulaiInput.value && !tanggalSelesaiInput.value) {
                switch(this.value) {
                    case 'tahunan':
                        tanggalMulaiInput.value = `${tahun}-01-01`;
                        tanggalSelesaiInput.value = `${tahun}-12-31`;
                        break;
                    case 'semesteran':
                        tanggalMulaiInput.value = `${tahun}-01-01`;
                        tanggalSelesaiInput.value = `${tahun}-06-30`;
                        break;
                    case 'triwulanan':
                        tanggalMulaiInput.value = `${tahun}-01-01`;
                        tanggalSelesaiInput.value = `${tahun}-03-31`;
                        break;
                    case 'bulanan':
                        tanggalMulaiInput.value = `${tahun}-01-01`;
                        tanggalSelesaiInput.value = `${tahun}-01-31`;
                        break;
                }
            }
        });

        // Jika tanggal kosong, trigger change event untuk mengisi tanggal otomatis
        if (!tanggalMulaiInput.value && !tanggalSelesaiInput.value) {
            tipePeriodeSelect.dispatchEvent(new Event('change'));
        }

        // Efek animasi saat halaman dimuat
        const formGroups = document.querySelectorAll('.form-group');
        formGroups.forEach((group, index) => {
            group.style.opacity = '0';
            setTimeout(() => {
                group.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                group.style.opacity = '1';
            }, 100 + (index * 50));
        });

        // Efek ripple pada tombol
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (button.type === 'submit') return;

                e.preventDefault();

                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();

                    // Navigasi ke halaman jika ini adalah link
                    if (this.tagName === 'A' && this.href) {
                        window.location.href = this.href;
                    }
                }, 600);
            });
        });

        // Animasi untuk checkbox
        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkmark = this.nextElementSibling;
                checkmark.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    checkmark.style.transform = 'scale(1)';
                }, 200);
            });
        });

        // Form field focus animation
        const formFields = document.querySelectorAll('.form-control, .form-select');
        formFields.forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateX(5px)';
                setTimeout(() => {
                    this.parentElement.style.transform = 'translateX(0)';
                }, 300);
            });
        });
    });
</script>
@endsection
