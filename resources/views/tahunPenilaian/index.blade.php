@extends('layouts.app')

@section('title', 'Manajemen Tahun Penilaian')
@section('page_title', 'MANAJEMEN TAHUN PENILAIAN')

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

    /* Gaya untuk tombol tambah tahun */
    .btn-tambah-tahun {
        background: linear-gradient(135deg, var(--pln-light-blue), var(--pln-blue));
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 156, 222, 0.3);
        position: relative;
        overflow: hidden;
        animation: fadeInRight 0.6s ease-out;
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .btn-tambah-tahun::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: 0.6s;
    }

    .btn-tambah-tahun:hover::before {
        left: 100%;
    }

    .btn-tambah-tahun i {
        margin-right: 8px;
        transition: all 0.3s ease;
    }

    .btn-tambah-tahun:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 156, 222, 0.5);
    }

    .btn-tambah-tahun:hover i {
        transform: rotate(90deg);
    }

    /* Gaya dasar untuk tabel */
    .tahun-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        margin: 20px 0;
        table-layout: fixed;
    }

    /* Gaya untuk header tabel */
    .tahun-table th {
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        padding: 15px 15px;
        text-align: left;
        font-weight: 600;
        border: none;
        text-transform: uppercase;
        font-size: 13px;
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    .tahun-table th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .tahun-table th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Gaya untuk sel tabel */
    .tahun-table td {
        padding: 15px;
        border: none;
        background: rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
        vertical-align: middle;
    }

    .tahun-table tbody tr {
        transition: all 0.3s ease;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--pln-border);
    }

    .tahun-table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        background: rgba(255, 255, 255, 0.07);
    }

    .tahun-table tbody tr td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .tahun-table tbody tr td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Gaya untuk badge status */
    .status-badge {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: all 0.6s ease;
    }

    .status-badge:hover::before {
        transform: translateX(100%);
    }

    .status-badge i {
        margin-right: 6px;
        transition: transform 0.3s ease;
    }

    .status-badge:hover i {
        transform: rotate(360deg);
    }

    .status-badge.aktif {
        background: linear-gradient(135deg, #4CAF50 0%, #3d9140 100%);
        color: white;
    }

    .status-badge.nonaktif {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
    }

    .status-badge.locked {
        background: linear-gradient(135deg, #dc3545 0%, #b91c1c 100%);
        color: white;
    }

    /* Gaya untuk tombol aksi */
    .btn-action {
        padding: 8px 12px;
        margin-right: 5px;
        margin-bottom: 5px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        font-weight: 600;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }

    .btn-action:hover::before {
        left: 100%;
    }

    .btn-action i {
        margin-right: 6px;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-3px);
    }

    .btn-success {
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(76, 175, 80, 0.2));
        color: #4CAF50;
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .btn-success:hover {
        box-shadow: 0 6px 15px rgba(76, 175, 80, 0.2);
    }

    .btn-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.2));
        color: #e5ac00;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .btn-warning:hover {
        box-shadow: 0 6px 15px rgba(255, 193, 7, 0.2);
    }

    .btn-info {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(23, 162, 184, 0.2));
        color: #17a2b8;
        border: 1px solid rgba(23, 162, 184, 0.3);
    }

    .btn-info:hover {
        box-shadow: 0 6px 15px rgba(23, 162, 184, 0.2);
    }

    .btn-primary {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(0, 123, 255, 0.2));
        color: #0d6efd;
        border: 1px solid rgba(0, 123, 255, 0.3);
    }

    .btn-primary:hover {
        box-shadow: 0 6px 15px rgba(0, 123, 255, 0.2);
    }

    .btn-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.2));
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.2);
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

    .alert-success {
        background-color: rgba(16, 185, 129, 0.1) !important;
        color: var(--success-color) !important;
    }

    .alert-success::before {
        background-color: var(--success-color) !important;
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1) !important;
        color: var(--error-color) !important;
    }

    .alert-danger::before {
        background-color: var(--error-color) !important;
    }

    /* Empty State Animation */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 50px 0;
        animation: fadeIn 0.5s ease-out;
    }

    .empty-state i {
        font-size: 60px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.15);
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pulse 3s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); opacity: 0.8; }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
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

        .tahun-table {
            font-size: 14px;
        }

        .btn-action {
            padding: 6px 10px;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .tahun-table {
            font-size: 12px;
        }

        .tahun-table th, .tahun-table td {
            padding: 10px 8px;
        }

        .btn-action span {
            display: none;
        }

        .btn-action i {
            margin-right: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2 class="tahun-title">Daftar Tahun Penilaian</h2>

    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('tahunPenilaian.create') }}" class="btn-tambah-tahun">
            <i class="fas fa-plus-circle"></i> Tambah Tahun Penilaian
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="tahun-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Tahun</th>
                    <th width="15%">Tipe Periode</th>
                    <th width="15%">Periode</th>
                    <th width="20%">Deskripsi</th>
                    <th width="10%">Status</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tahunPenilaians as $index => $tahun)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $tahun->tahun }}</strong></td>
                        <td>{{ $tahun->getTipePeriodeLabel() }}</td>
                        <td>
                            @if($tahun->tanggal_mulai && $tahun->tanggal_selesai)
                                {{ $tahun->tanggal_mulai->format('d/m/Y') }} - {{ $tahun->tanggal_selesai->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $tahun->deskripsi ?? '-' }}</td>
                        <td>
                            @if($tahun->is_aktif)
                                <span class="status-badge aktif">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            @else
                                <span class="status-badge nonaktif">
                                    <i class="fas fa-times-circle"></i> Non-Aktif
                                </span>
                            @endif

                            @if($tahun->is_locked)
                                <span class="status-badge locked mt-1">
                                    <i class="fas fa-lock"></i> Terkunci
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @if(!$tahun->is_aktif)
                                    <a href="{{ route('tahunPenilaian.activate', $tahun->id) }}" class="btn-action btn-success"
                                       title="Aktifkan" onclick="return confirm('Anda yakin ingin mengaktifkan tahun penilaian ini?')">
                                        <i class="fas fa-check"></i> <span>Aktifkan</span>
                                    </a>
                                @endif

                                @if(!$tahun->is_locked)
                                    <a href="{{ route('tahunPenilaian.lock', $tahun->id) }}" class="btn-action btn-warning"
                                       title="Kunci" onclick="return confirm('Anda yakin ingin mengunci tahun penilaian ini? Data yang terkunci tidak dapat diubah kecuali oleh Master Admin.')">
                                        <i class="fas fa-lock"></i> <span>Kunci</span>
                                    </a>
                                @else
                                    <a href="{{ route('tahunPenilaian.unlock', $tahun->id) }}" class="btn-action btn-info"
                                       title="Buka Kunci" onclick="return confirm('Anda yakin ingin membuka kunci tahun penilaian ini?')">
                                        <i class="fas fa-unlock"></i> <span>Buka</span>
                                    </a>
                                @endif

                                <a href="{{ route('tahunPenilaian.edit', $tahun->id) }}" class="btn-action btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i> <span>Edit</span>
                                </a>

                                @if(!$tahun->is_aktif && !$tahun->is_locked)
                                    <form action="{{ route('tahunPenilaian.destroy', $tahun->id) }}" method="POST" style="display: inline;"
                                          onsubmit="return confirm('Anda yakin ingin menghapus tahun penilaian ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i> <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <p>Belum ada data tahun penilaian</p>
                                <a href="{{ route('tahunPenilaian.create') }}" class="btn-tambah-tahun mt-3">
                                    <i class="fas fa-plus-circle "></i> Tambah Tahun Penilaian
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan efek ripple pada tombol-tombol
        const buttons = document.querySelectorAll('.btn-action, .btn-tambah-tahun');

        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const formSubmit = this.closest('form') && this.type === 'submit';
                if (formSubmit) return;

                e.preventDefault();

                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const circle = document.createElement('span');
                circle.classList.add('ripple');
                circle.style.left = x + 'px';
                circle.style.top = y + 'px';

                this.appendChild(circle);

                setTimeout(() => {
                    circle.remove();

                    // Navigasi ke halaman jika ini adalah link
                    if (this.tagName === 'A' && this.href) {
                        window.location.href = this.href;
                    }
                }, 600);
            });
        });

        // Tambahkan animasi untuk baris tabel saat pertama kali dimuat
        const tableRows = document.querySelectorAll('.tahun-table tbody tr');
        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';

            setTimeout(() => {
                row.style.transition = 'all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 100 + (index * 50));
        });

        // Animate table header
        const tableHeaders = document.querySelectorAll('.tahun-table th');
        tableHeaders.forEach((header, index) => {
            header.style.opacity = '0';
            header.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                header.style.transition = 'all 0.4s ease';
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
            }, 50 + (index * 30));
        });
    });
</script>
@endsection
