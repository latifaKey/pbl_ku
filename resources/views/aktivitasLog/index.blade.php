@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('styles')
<style>
    /* Layout */
    .dashboard-wrapper {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
    }

    .dashboard-content {
        display: flex;
        flex-direction: column;
        padding: 1.5rem;
        height: calc(100vh - 70px);
        overflow: hidden;
        max-width: 1800px;
        margin: 0 auto;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        height: 100%;
        overflow: hidden;
    }

    @media (min-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: minmax(300px, 30%) 1fr;
        }
    }

    /* Card design - Mendukung tema terang/gelap */
    .card {
        background: var(--pln-surface);
        border-radius: 1rem;
        box-shadow: 0 4px 25px var(--pln-shadow);
        border: 1px solid var(--pln-border);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
        color: var(--pln-text);
        transition: all var(--transition-speed) ease;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--pln-border);
        background-color: var(--pln-accent-bg);
        transition: all var(--transition-speed) ease;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--pln-text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color var(--transition-speed) ease;
    }

    .card-title i {
        color: var(--pln-light-blue);
    }

    .card-body {
        padding: 1.5rem;
        flex: 1;
        overflow-y: auto;
        transition: all var(--transition-speed) ease;
    }

    /* Form & Filters */
    .form-label {
        font-weight: 500;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        color: var(--pln-text);
        transition: color var(--transition-speed) ease;
    }

    .form-control {
        width: 100%;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border: 1px solid var(--pln-border);
        border-radius: 0.5rem;
        transition: all var(--transition-speed) ease;
        background-color: var(--pln-surface);
        color: var(--pln-text);
    }

    .form-control:focus {
        border-color: var(--pln-light-blue);
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.1);
        outline: none;
    }

    .form-filters {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
        cursor: pointer;
        gap: 0.5rem;
        border: none;
    }

    .btn-primary {
        background-color: var(--pln-blue);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--pln-light-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--pln-shadow);
    }

    .btn-secondary {
        background-color: var(--pln-surface-2);
        color: var(--pln-text);
        border: 1px solid var(--pln-border);
    }

    .btn-secondary:hover {
        background-color: var(--pln-accent-bg);
        transform: translateY(-2px);
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }

    .btn-icon {
        padding: 0.5rem;
        width: 2.25rem;
        height: 2.25rem;
    }

    .filter-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        margin-top: 1rem;
    }

    /* Table styles - Mendukung tema terang/gelap */
    .table-container {
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        max-height: calc(100vh - 250px);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        overflow-y: auto;
        flex: 1;
        min-height: 300px;
        scrollbar-width: thin;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }

    /* Custom scrollbar styling */
    .table-responsive::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: var(--pln-accent-bg);
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: var(--pln-light-blue);
        opacity: 0.5;
        border-radius: 3px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: var(--pln-blue);
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.875rem;
        margin-bottom: 0;
        color: var(--pln-text);
    }

    .table th {
        background-color: var(--pln-accent-bg);
        color: var(--pln-text);
        font-weight: 600;
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--pln-border);
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
        transition: all var(--transition-speed) ease;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid var(--pln-border);
        vertical-align: middle;
        transition: all var(--transition-speed) ease;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    .table tr:hover td {
        background-color: var(--pln-accent-bg);
    }

    .table-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--pln-border);
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .badge-info {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .badge-primary {
        background-color: rgba(10, 77, 133, 0.1);
        color: var(--pln-light-blue);
    }

    .badge-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .badge-secondary {
        background-color: rgba(100, 116, 139, 0.1);
        color: var(--pln-text-secondary);
    }

    /* Custom pagination navigation with next/prev buttons */
    .pagination-nav {
        display: flex;
        align-items: center;
    }

    .pagination-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-buttons .btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-info {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        color: var(--pln-text-secondary);
        margin: 0 0.5rem;
        white-space: nowrap;
    }

    /* Items per page selector */
    .per-page-selector {
        display: flex;
        align-items: center;
    }

    .per-page-selector select {
        min-width: 140px;
        font-size: 0.75rem;
        height: 32px;
        padding: 0.25rem 0.5rem;
        background-color: var(--pln-surface);
        color: var(--pln-text);
        border: 1px solid var(--pln-border);
        transition: all var(--transition-speed) ease;
    }

    /* Stats cards - Mendukung tema terang/gelap */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .stat-card {
        padding: 1.25rem;
        border-radius: 0.75rem;
        background-color: var(--pln-surface);
        border: 1px solid var(--pln-border);
        box-shadow: 0 4px 15px var(--pln-shadow);
        display: flex;
        flex-direction: column;
        color: var(--pln-text);
        transition: all var(--transition-speed) ease;
    }

    .stat-title {
        font-size: 0.875rem;
        color: var(--pln-text-secondary);
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--pln-text);
    }

    .cleanup-section {
        padding-top: 1.5rem;
        margin-top: 1rem;
        border-top: 1px solid var(--pln-border);
    }

    .cleanup-title {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--pln-text);
    }

    .cleanup-options {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .cleanup-warning {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.75rem;
        display: block;
    }

    /* User avatar */
    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(0, 156, 222, 0.3);
    }

    /* Info element for empty scroll indicator */
    .scroll-indicator {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: var(--pln-blue);
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.75rem;
        opacity: 0.8;
        z-index: 20;
        display: none;
        animation: fadeOut 2s forwards;
        animation-delay: 3s;
    }

    @keyframes fadeOut {
        from { opacity: 0.8; }
        to { opacity: 0; }
    }

    /* Responsive adjustments for table */
    @media (max-width: 1024px) {
        .dashboard-grid {
            gap: 1rem;
        }

        .table-responsive {
            max-height: 500px;
        }
    }

    /* Responsive fixes */
    @media (max-width: 768px) {
        .form-filters {
            grid-template-columns: 1fr;
        }

        .filter-buttons {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
        }

        .cleanup-options {
            flex-direction: column;
            align-items: flex-start;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .card-header .d-flex {
            width: 100%;
            justify-content: space-between;
        }

        .pagination-buttons {
            flex-wrap: wrap;
        }

        .pagination-info {
            order: -1;
            width: 100%;
            text-align: center;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-content">
        <!-- Stats Section -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Log</div>
                <div class="stat-value">{{ number_format($stats['total']) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Hari Ini</div>
                <div class="stat-value">{{ number_format($stats['today']) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Minggu Ini</div>
                <div class="stat-value">{{ number_format($stats['week']) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Bulan Ini</div>
                <div class="stat-value">{{ number_format($stats['month']) }}</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Filter Column -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-filter"></i>
                        Filter Log Aktivitas
                    </h5>
                </div>

                <div class="card-body">
                    <form method="get" action="{{ route('aktivitasLog.index') }}">
                        <div class="form-filters">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Pengguna</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Semua Pengguna</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tipe" class="form-label">Tipe Aktivitas</label>
                                <select name="tipe" id="tipe" class="form-control">
                                    <option value="">Semua Tipe</option>
                                    @foreach($tipes as $tipe)
                                        <option value="{{ $tipe }}" {{ request('tipe') == $tipe ? 'selected' : '' }}>
                                            {{ ucfirst($tipe) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                            </div>

                            <div class="mb-3">
                                <label for="model_type" class="form-label">Model</label>
                                <select name="model_type" id="model_type" class="form-control">
                                    <option value="">Semua Model</option>
                                    @foreach($modelTypes as $modelType)
                                        <option value="{{ $modelType }}" {{ request('model_type') == $modelType ? 'selected' : '' }}>
                                            {{ class_basename($modelType) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="keyword" class="form-label">Kata Kunci</label>
                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Cari..." value="{{ request('keyword') }}">
                            </div>
                        </div>

                        <div class="filter-buttons">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Filter
                            </button>
                            <a href="{{ route('aktivitasLog.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i>
                                Reset
                            </a>
                            <a href="{{ route('aktivitasLog.eksporCsv', request()->all()) }}" class="btn btn-secondary">
                                <i class="fas fa-file-csv"></i>
                                Ekspor CSV
                            </a>
                        </div>
                    </form>

                    <div class="cleanup-section">
                        <h6 class="cleanup-title">
                            <i class="fas fa-trash-alt"></i>
                            Pembersihan Log
                        </h6>
                        <form method="post" action="{{ route('aktivitasLog.hapusLogLama') }}" class="d-inline" id="deleteOldForm">
                            @csrf
                            <div class="cleanup-options">
                                <select name="periode" class="form-control" required>
                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">12 Bulan</option>
                                </select>
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus log lama? Tindakan ini tidak dapat dibatalkan.')">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus Log Lama
                                </button>
                            </div>
                            <small class="cleanup-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Peringatan: Tindakan ini akan menghapus semua log aktivitas yang lebih lama dari periode yang dipilih
                            </small>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Column -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-history"></i>
                        Riwayat Aktivitas
                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <div class="per-page-selector">
                            <form method="GET" action="{{ route('aktivitasLog.index') }}" id="perPageForm">
                                <select name="per_page" id="per_page" class="form-control form-control-sm" onchange="document.getElementById('perPageForm').submit()">
                                    <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10 per halaman</option>
                                    <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25 per halaman</option>
                                    <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50 per halaman</option>
                                    <option value="100" {{ request('per_page', 15) == 100 ? 'selected' : '' }}>100 per halaman</option>
                                </select>
                                <!-- Preserve all existing query parameters except page -->
                                @foreach(request()->except(['page', 'per_page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                        </div>
                        <span>{{ $logs->total() }} total log</span>
                    </div>
                </div>

                <form id="deleteMultipleForm" method="post" action="{{ route('aktivitasLog.hapusMultiple') }}">
                    @csrf
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="40px">
                                            <input type="checkbox" class="select-all-checkbox">
                                        </th>
                                        <th width="240px">Waktu</th>
                                        <th width="180px">Pengguna</th>
                                        <th width="100px">Tipe</th>
                                        <th>Detail</th>
                                        <th width="100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="log_ids[]" value="{{ $log->id }}" class="select-checkbox">
                                        </td>
                                        <td>{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                                        <td>
                                            @if($log->user)
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="user-avatar">{{ substr($log->user->name, 0, 1) }}</div>
                                                    <span>{{ $log->user->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">Sistem</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $log->getTipeColor() }}">
                                                <i class="fas {{ $log->getTipeIcon() }}"></i>
                                                {{ $log->getTipeLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            <div><strong>{{ $log->judul }}</strong></div>
                                            <div class="text-muted small">{{ $log->deskripsi }}</div>
                                            @if ($log->loggable_type)
                                            <div class="text-muted small">
                                                <i class="fas fa-link"></i>
                                                {{ class_basename($log->loggable_type) }}
                                                @if ($log->getLoggableTitle())
                                                - {{ $log->getLoggableTitle() }}
                                                @endif
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('aktivitasLog.show', $log->id) }}" class="btn btn-primary btn-sm btn-icon" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form method="post" action="{{ route('aktivitasLog.destroy', $log->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus log ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Hapus Log">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                                <h6>Tidak ada log aktivitas ditemukan</h6>
                                                <p class="text-muted">Coba ubah filter atau reset pencarian</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="table-actions">
                            <div>
                                <button type="submit" class="btn btn-danger" id="deleteMultipleBtn" disabled
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus log yang dipilih?')">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus Log Terpilih
                                </button>
                            </div>
                            <div class="pagination-nav">
                                @if ($logs->hasPages())
                                    <div class="pagination-buttons">
                                        <a href="{{ $logs->appends(request()->except('page'))->url(1) }}"
                                           class="btn btn-sm btn-secondary {{ $logs->onFirstPage() ? 'disabled' : '' }}"
                                           {{ $logs->onFirstPage() ? 'disabled' : '' }}>
                                            <i class="fas fa-angle-double-left"></i>
                                        </a>

                                        <a href="{{ $logs->appends(request()->except('page'))->previousPageUrl() }}"
                                           class="btn btn-sm btn-secondary {{ $logs->onFirstPage() ? 'disabled' : '' }}"
                                           {{ $logs->onFirstPage() ? 'disabled' : '' }}>
                                            <i class="fas fa-angle-left"></i>
                                            Sebelumnya
                                        </a>

                                        <span class="pagination-info">
                                            Halaman {{ $logs->currentPage() }} dari {{ $logs->lastPage() }}
                                        </span>

                                        <a href="{{ $logs->appends(request()->except('page'))->nextPageUrl() }}"
                                           class="btn btn-sm btn-secondary {{ !$logs->hasMorePages() ? 'disabled' : '' }}"
                                           {{ !$logs->hasMorePages() ? 'disabled' : '' }}>
                                            Selanjutnya
                                            <i class="fas fa-angle-right"></i>
                                        </a>

                                        <a href="{{ $logs->appends(request()->except('page'))->url($logs->lastPage()) }}"
                                           class="btn btn-sm btn-secondary {{ !$logs->hasMorePages() ? 'disabled' : '' }}"
                                           {{ !$logs->hasMorePages() ? 'disabled' : '' }}>
                                            <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Theme detection and synchronization
        function syncWithSystemTheme() {
            // Deteksi tema dari atribut data-theme pada body
            const currentTheme = document.body.getAttribute('data-theme') || 'dark';

            // Elemen dengan styling kustom yang perlu disesuaikan berdasarkan tema
            const tableRows = document.querySelectorAll('tr');
            const badges = document.querySelectorAll('.badge');
            const cards = document.querySelectorAll('.card');

            // Tambahkan kelas khusus tema jika diperlukan
            document.querySelectorAll('.table').forEach(table => {
                table.classList.remove('table-dark', 'table-light');
                if (currentTheme === 'dark') {
                    table.classList.add('table-dark');
                } else {
                    table.classList.add('table-light');
                }
            });

            // Sesuaikan kontras untuk badge berdasarkan tema
            badges.forEach(badge => {
                if (currentTheme === 'light') {
                    badge.style.fontWeight = '600';
                } else {
                    badge.style.fontWeight = '500';
                }
            });
        }

        // Jalankan sinkronisasi saat halaman dimuat
        syncWithSystemTheme();

        // Tambahkan listener untuk toggle tema
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('change', function() {
                // Beri waktu untuk transisi CSS selesai
                setTimeout(syncWithSystemTheme, 50);
            });
        }

        // Handle select all checkbox
        const selectAllCheckbox = document.querySelector('.select-all-checkbox');
        const checkboxes = document.querySelectorAll('.select-checkbox');
        const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');

        if (selectAllCheckbox && checkboxes.length > 0) {
            selectAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateDeleteButton();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateDeleteButton();
                    updateSelectAllCheckbox();
                });
            });

            function updateDeleteButton() {
                const checkedBoxes = document.querySelectorAll('.select-checkbox:checked');
                deleteMultipleBtn.disabled = checkedBoxes.length === 0;
            }

            function updateSelectAllCheckbox() {
                const checkedBoxes = document.querySelectorAll('.select-checkbox:checked');
                selectAllCheckbox.checked = checkedBoxes.length === checkboxes.length && checkboxes.length > 0;
            }
        }

        // Scroll functionality with theme awareness
        const tableResponsive = document.querySelector('.table-responsive');
        if (tableResponsive) {
            // Create scroll indicator with theme-appropriate styling
            const scrollIndicator = document.createElement('div');
            scrollIndicator.className = 'scroll-indicator';
            scrollIndicator.textContent = 'Scroll untuk melihat lebih banyak';
            tableResponsive.parentNode.appendChild(scrollIndicator);

            // Pastikan indikator scroll mengikuti tema
            const updateScrollIndicatorTheme = () => {
                const currentTheme = document.body.getAttribute('data-theme') || 'dark';
                if (currentTheme === 'light') {
                    scrollIndicator.style.opacity = '0.9';
                } else {
                    scrollIndicator.style.opacity = '0.8';
                }
            };

            updateScrollIndicatorTheme();

            // Check if scroll is needed
            function checkScrollNeeded() {
                if (tableResponsive.scrollHeight > tableResponsive.clientHeight) {
                    scrollIndicator.style.display = 'block';

                    // Hide indicator after user has scrolled
                    tableResponsive.addEventListener('scroll', function() {
                        if (tableResponsive.scrollTop > 20) {
                            scrollIndicator.style.display = 'none';
                        }
                    }, { once: true });
                } else {
                    scrollIndicator.style.display = 'none';
                }
            }

            // Check on load and on resize
            checkScrollNeeded();
            window.addEventListener('resize', checkScrollNeeded);

            // Ensure table header remains visible during scroll with theme consideration
            tableResponsive.addEventListener('scroll', function() {
                const headers = tableResponsive.querySelectorAll('th');
                const scrollTop = tableResponsive.scrollTop;
                const currentTheme = document.body.getAttribute('data-theme') || 'dark';

                headers.forEach(header => {
                    header.style.transform = `translateY(${scrollTop}px)`;
                    // Ensure header remains visible with proper z-index and shadow
                    if (scrollTop > 5) {
                        header.style.boxShadow = currentTheme === 'dark'
                            ? '0 4px 6px rgba(0, 0, 0, 0.3)'
                            : '0 4px 6px rgba(0, 0, 0, 0.1)';
                    } else {
                        header.style.boxShadow = 'none';
                    }
                });
            });

            // Listen for theme changes to update scroll indicator
            if (themeToggle) {
                themeToggle.addEventListener('change', updateScrollIndicatorTheme);
            }
        }
    });
</script>
@endsection
