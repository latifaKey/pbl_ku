@extends('layouts.app')

@section('title', 'Verifikasi KPI')
@section('page_title', 'VERIFIKASI KPI')

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
    .verifikasi-title {
        margin-bottom: 20px;
        color: var(--pln-text);
        font-weight: 700;
        font-size: 24px;
        position: relative;
        padding-left: 16px;
    }

    .verifikasi-title::before {
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

    /* Panel Filter */
    .filter-panel {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        border: 1px solid var(--pln-border);
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .filter-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-light-blue), var(--pln-blue));
        opacity: 0.7;
    }

    .filter-panel-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--pln-border);
    }

    .filter-panel-title {
        font-weight: 600;
        font-size: 16px;
        color: var(--pln-text);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .filter-panel-title i {
        margin-right: 8px;
        color: var(--pln-light-blue);
    }

    /* Form Control Styling */
    .form-label {
        font-weight: 600;
        color: var(--pln-text);
        margin-bottom: 8px;
        font-size: 14px;
        display: block;
    }

    .form-select, .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--pln-border);
        padding: 10px 15px;
        border-radius: 12px;
        color: var(--pln-text);
        font-size: 14px;
        transition: all 0.3s ease;
        width: 100%;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .form-select:focus, .form-control:focus {
        border-color: var(--pln-light-blue);
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.15), inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
        padding-right: 40px;
    }

    /* Gaya untuk button */
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn i {
        margin-right: 8px;
        transition: transform 0.3s ease;
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

    .btn-outline-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: var(--pln-text-secondary);
        border: 1px solid var(--pln-border);
    }

    .btn-outline-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .btn-success {
        background: linear-gradient(135deg, #4CAF50, #3d9140);
        color: white;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .btn-success:hover {
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.5);
    }

    /* Alert Styling */
    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border-left: 4px solid;
        animation: slideInDown 0.5s ease-out;
    }

    .alert i {
        margin-right: 10px;
        font-size: 18px;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.1), rgba(25, 135, 84, 0.05));
        color: #4CAF50;
        border-color: #4CAF50;
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
        color: #dc3545;
        border-color: #dc3545;
    }

    .alert-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.05));
        color: #e5ac00;
        border-color: #e5ac00;
    }

    .alert-info {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(23, 162, 184, 0.05));
        color: #17a2b8;
        border-color: #17a2b8;
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Gaya untuk tabel */
    .table-container {
        overflow-x: auto;
        border-radius: 16px;
        background: var(--pln-accent-bg);
        padding: 5px;
        border: 1px solid var(--pln-border);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08),
                  inset 0 1px 0 rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }

    .verifikasi-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        font-size: 14px;
        table-layout: fixed;
    }

    .verifikasi-table thead tr {
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        text-align: left;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 156, 222, 0.2);
        position: relative;
        z-index: 2;
    }

    .verifikasi-table th {
        padding: 15px 15px;
        font-weight: 600;
        letter-spacing: 0.5px;
        border: none;
        text-transform: uppercase;
        font-size: 13px;
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    .verifikasi-table th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .verifikasi-table th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .verifikasi-table td {
        padding: 15px;
        border: none;
        background: rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
        vertical-align: middle;
    }

    .verifikasi-table tbody tr {
        transition: all 0.3s ease;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--pln-border);
    }

    .verifikasi-table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        background: rgba(255, 255, 255, 0.07);
    }

    .verifikasi-table tbody tr td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .verifikasi-table tbody tr td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Form check styling */
    .form-check {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        margin: 0;
        cursor: pointer;
        position: relative;
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--pln-border);
        transition: all 0.3s ease;
        appearance: none;
    }

    .form-check-input:checked {
        background: var(--pln-blue);
        border-color: var(--pln-blue);
    }

    .form-check-input:checked::after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 14px;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Tombol aksi tabel */
    .btn-sm {
        padding: 6px 10px;
        font-size: 12px;
        border-radius: 8px;
    }

    .btn-info {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(23, 162, 184, 0.2));
        color: #17a2b8;
        border: 1px solid rgba(23, 162, 184, 0.3);
    }

    .btn-info:hover {
        box-shadow: 0 6px 15px rgba(23, 162, 184, 0.2);
    }

    /* Pagination styling */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
        margin-top: 20px;
        justify-content: center;
    }

    .page-item {
        margin: 0 3px;
    }

    .page-link {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        color: var(--pln-blue);
        background-color: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--pln-border);
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        min-width: 36px;
        height: 36px;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--pln-light-blue), var(--pln-blue));
        color: white;
        border-color: var(--pln-blue);
        box-shadow: 0 4px 15px rgba(0, 156, 222, 0.3);
    }

    .page-item.disabled .page-link {
        color: var(--pln-text-secondary);
        pointer-events: none;
        background-color: rgba(255, 255, 255, 0.01);
        border-color: var(--pln-border);
    }

    .page-link:hover {
        background-color: rgba(0, 156, 222, 0.1);
        transform: translateY(-2px);
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

        .verifikasi-table {
            font-size: 14px;
        }

        .btn {
            padding: 8px 12px;
        }

        .filter-panel {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .verifikasi-table {
            font-size: 12px;
        }

        .verifikasi-table th, .verifikasi-table td {
            padding: 10px 8px;
        }

        .btn i {
            margin-right: 0;
        }

        .btn span {
            display: none;
        }
    }
</style>
@endsection


@section('content')
<div class="container">
    <h2 class="verifikasi-title">Daftar KPI yang Menunggu Verifikasi</h2>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
        </div>
    @endif

    @if(isset($isPeriodeLocked) && $isPeriodeLocked)
        <div class="alert alert-warning">
            <i class="fas fa-lock"></i> <strong>Peringatan!</strong> Periode penilaian tahun {{ $tahun }} sedang terkunci. Anda tidak dapat melakukan verifikasi pada periode ini.
        </div>
    @endif

    <!-- Form Filter -->
    <div class="filter-panel">
        <div class="filter-panel-header">
            <h6 class="filter-panel-title"><i class="fas fa-filter"></i> Filter Data</h6>
        </div>
        <form action="{{ route('verifikasi.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-3 mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <select class="form-select" id="tahun" name="tahun">
                    @php
                        $currentYear = date('Y');
                        $startYear = 2020;
                    @endphp
                    @for($y = $currentYear; $y >= $startYear; $y--)
                        <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="bulan" class="form-label">Bulan</label>
                <select class="form-select" id="bulan" name="bulan">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ sprintf('%02d', $m) == $bulan ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="bidang_id" class="form-label">Bidang</label>
                <select class="form-select" id="bidang_id" name="bidang_id">
                    <option value="">-- Semua Bidang --</option>
                    @foreach($bidangs as $bidang)
                        <option value="{{ $bidang->id }}" {{ $bidangId == $bidang->id ? 'selected' : '' }}>{{ $bidang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> <span>Filter</span>
                </button>
                <a href="{{ route('verifikasi.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-sync"></i> <span>Reset</span>
                </a>
            </div>
        </form>
    </div>

    @if($realisasis->count() > 0)
        <form action="/verifikasi-massal" method="POST" id="form-verifikasi-massal">
            @csrf
            <div class="mb-3">
                <button type="submit" class="btn btn-success" id="btn-verifikasi-massal" disabled>
                    <i class="fas fa-check-double"></i> Verifikasi Terpilih
                </button>
            </div>

            <div class="table-container mb-3">
                <table class="verifikasi-table">
                    <thead>
                        <tr>
                            <th width="5%">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll" {{ isset($isPeriodeLocked) && $isPeriodeLocked ? 'disabled' : '' }}>
                                </div>
                            </th>
                            <th width="10%">KPI</th>
                            <th width="25%">Indikator</th>
                            <th width="15%">Bidang</th>
                            <th width="10%">Periode</th>
                            <th width="10%">Nilai</th>
                            <th width="10%">Status</th>
                            <th width="10%">Uploaded By</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($realisasis as $kpi)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input check-item" type="checkbox" name="nilai_ids[]" value="{{ $kpi->id }}"
                                            {{ isset($isPeriodeLocked) && $isPeriodeLocked ? 'disabled' : '' }}>

                                    </div>
                                </td>
                                <td>{{ $kpi->indikator->kode }}</td>
                                <td>{{ $kpi->indikator->nama }}</td>
                                <td>{{ $kpi->indikator->bidang->nama }}</td>
                                <td>{{ $kpi->tahun }}-{{ $kpi->bulan }}</td>
                                <td>{{ $kpi->nilai }}</td>
                                <td>
                                    <span class="badge bg-{{ $kpi->approval_color }}">
                                        {{ $kpi->approval_status }}
                                    </span>
                                </td>
                                <td>{{ $kpi->user->name }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('verifikasi.show', $kpi->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> <span>Detail</span>
                                        </a>

                                        @if(!isset($isPeriodeLocked) || !$isPeriodeLocked)
                                            <form action="{{ route('verifikasi.update', $kpi->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('Yakin verifikasi KPI ini?')">
                                                    <i class="fas fa-check"></i> <span>Verifikasi</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-4">
            {{ $realisasis->appends(['tahun' => $tahun, 'bulan' => $bulan, 'bidang_id' => $bidangId])->links() }}
        </div>
    @else
        <div class="alert alert-warning">
            Tidak ada data realisasi untuk periode ini.
        </div>
    @endif


</div>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAllBox = document.getElementById('checkAll');
        const checkItems = document.querySelectorAll('.check-item');
        const submitBtn = document.getElementById('btn-verifikasi-massal');
        const form = document.getElementById('form-verifikasi-massal');

        function checkSelected() {
            const anyChecked = Array.from(checkItems).some(cb => cb.checked);
            submitBtn.disabled = !anyChecked;
        }

        // Cek perubahan pada semua checkbox
        checkItems.forEach(cb => {
            cb.addEventListener('change', function () {
                checkSelected();

                // Sinkronisasi status "check all"
                if (checkAllBox) {
                    checkAllBox.checked = Array.from(checkItems).every(cb => cb.checked);
                }
            });
        });

        // Check/uncheck all
        if (checkAllBox) {
            checkAllBox.addEventListener('change', function () {
                checkItems.forEach(cb => cb.checked = checkAllBox.checked);
                checkSelected();
            });
        }

        // Konfirmasi sebelum submit massal
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah submit default

                const selected = Array.from(checkItems).filter(cb => cb.checked);
                if (selected.length === 0) {
                    alert('Silakan pilih setidaknya satu KPI untuk diverifikasi.');
                    return false;
                }

                if (!confirm('Yakin ingin memverifikasi ' + selected.length + ' KPI terpilih?')) {
                    return false;
                }

                // Debug info
                console.log('Form disubmit ke:', form.action);
                console.log('Method:', form.method);
                console.log('Selected IDs:', selected.map(cb => cb.value));

                // Buat form baru dan submit secara manual
                const newForm = document.createElement('form');
                newForm.method = 'POST';
                newForm.action = '/verifikasi-massal';
                newForm.style.display = 'none';

                // Tambahkan CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    newForm.appendChild(csrfInput);
                }

                // Tambahkan nilai IDs yang dipilih
                selected.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'nilai_ids[]';
                    input.value = cb.value;
                    newForm.appendChild(input);
                });

                // Tambahkan form ke body dan submit
                document.body.appendChild(newForm);
                newForm.submit();
            });
        }

        // Ripple effect (optional)
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (button.type !== 'submit' || !button.form) {
                    const x = e.clientX - e.target.getBoundingClientRect().left;
                    const y = e.clientY - e.target.getBoundingClientRect().top;

                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;

                    button.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                }
            });
        });

        // Animasi masuk tabel
        const rows = document.querySelectorAll('.verifikasi-table tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            setTimeout(() => {
                row.style.transition = 'all 0.4s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 100 + (index * 50));
        });

        // Jalankan sekali saat pertama
        checkSelected();
    });
</script>
@endsection

