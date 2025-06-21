@extends('layouts.app')

@section('title', 'Realisasi KPI')
@section('page_title', 'REALISASI KPI')

@section('styles')
<style>
    /* --- Styles mirip sebelumnya --- */
    .dashboard-content {
        max-width: 1800px;
        margin: 0 auto;
        padding: 0 15px;
    }
    .page-header {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,123,255,0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-header h2 { font-size: 1.5rem; font-weight: 600; margin: 0; }
    .page-header-subtitle { margin-top: 5px; font-weight: 400; font-size: 0.9rem; opacity: 0.9; }
    .page-header-actions { display: flex; gap: 10px; }
    .page-header-badge {
        background: rgba(255,255,255,0.2);
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        display: flex; align-items: center;
    }
    .page-header-badge i { margin-right: 5px; }
    .filter-card, .table-card {
        background: var(--pln-surface);
        border-radius: 16px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border);
        box-shadow: 0 8px 20px var(--pln-shadow);
        padding: 20px;
    }
    .filter-card::before, .table-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    }
    .table-card .card-header {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        border: none;
        border-radius: 16px 16px 0 0;
        padding: 15px 20px;
        margin: -20px -20px 15px -20px;
        font-weight: 600;
        font-size: 1rem;
    }
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        color: var(--pln-text);
    }
    .data-table th, .data-table td {
        padding: 15px;
        border-bottom: 1px solid var(--pln-border);
        vertical-align: middle;
    }
    .data-table th {
        background-color: var(--pln-accent-bg);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    .data-table tbody tr:hover {
        background-color: var(--pln-accent-bg);
    }
    .progress-wrapper { display: flex; flex-direction: column; gap: 5px; }
    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: var(--pln-accent-bg);
        overflow: hidden;
    }
    .progress-bar.bg-danger { background-color: #dc3545; }
    .progress-bar.bg-warning { background-color: #ffc107; }
    .progress-bar.bg-success { background-color: #28a745; }
    .progress-value {
        font-weight: 600;
        font-size: 0.9rem;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-badge i { margin-right: 5px; }
    .status-badge.verified {
        background-color: rgba(40,167,69,0.15);
        color: #28a745;
    }
    .status-badge.pending {
        background-color: rgba(255,193,7,0.15);
        color: #ffc107;
    }
    .status-badge.not-input {
        background-color: rgba(220,53,69,0.15);
        color: #dc3545;
    }
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    .action-buttons .btn {
        border-radius: 50px;
        padding: 5px 15px;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding-left: 0;
        gap: 6px;
        margin-top: 1rem;
    }

    .pagination li {
        display: inline;
    }

    .pagination a,
    .pagination span {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        text-decoration: none;
        font-size: 14px;
        color: #0d6efd;
        transition: background-color 0.2s, color 0.2s;
    }

    .pagination a:hover {
        background-color: #e9ecef;
        color: #0a58ca;
    }

    .pagination .current {
        background-color: #0d6efd;
        color: #fff;
        font-weight: bold;
        border-color: #0d6efd;
    }

    .pagination .disabled {
        color: #6c757d;
        cursor: not-allowed;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .pagination .dots {
        color: #6c757d;
        background-color: transparent;
        border: none;
        padding: 6px 12px;
    }

    .pagination .prev,
    .pagination .next {
        font-weight: bold;
    }
    @media (max-width: 992px) {
        .filter-group { flex-direction: column; }
    }
    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .page-header-actions { width: 100%; justify-content: flex-start; margin-top: 10px; }
    }

</style>
@endsection



@section('content')
<div class="dashboard-content">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h2><i class="fas fa-chart-line me-2"></i>Realisasi KPI</h2>
            <div class="page-header-subtitle">
                Pengelolaan data realisasi kinerja {{ $isMaster ? 'per pilar' : 'per bidang' }}
            </div>
        </div>
    </div>

    @include('components.alert')

    <!-- Filter Form -->
    <div class="filter-card">
        <h5><i class="fas fa-filter me-2"></i>Filter Data Realisasi</h5>
        <form method="GET" action="{{ route('realisasi.index') }}" class="mb-3">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="tanggal" class="col-form-label">Pilih Tanggal</label>
                </div>
                <div class="col-auto">
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $tanggal }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Tabel -->
    @foreach($grouped as $kode => $group)
        <div class="table-card mt-4">
            <div class="card-header">
                {{ $isMaster ? 'Pilar' : 'Bidang' }} {{ $kode }} - {{ $group['nama'] }}
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Indikator</th>
                                @if($isMaster)
                                    <th>Bidang</th>
                                @endif
                                <th>Target</th>
                                <th>Realisasi</th>
                                <th>Capaian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group['indikators'] as $index => $indikator)
                                @php
                                    $realisasi = $indikator->firstRealisasi;
                                    $nilai = $realisasi?->nilai;
                                    $target = $indikator->target_nilai;
                                    $persentase = $indikator->persentase ?? 0;
                                    $progressClass = $persentase >= 90 ? 'bg-success' : ($persentase >= 70 ? 'bg-warning' : 'bg-danger');
                                    $query = ['tanggal' => $tanggal];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $indikator->kode }}</td>
                                    <td>{{ $indikator->nama }}</td>
                                    @if($isMaster)
                                        <td>{{ $indikator->bidang->nama ?? '-' }}</td>
                                    @endif
                                    <td>{{ number_format($target, 2) }}</td>
                                    <td>{{ $nilai !== null ? number_format($nilai, 2) : '-' }}</td>
                                    <td>
                                        <div class="progress-wrapper">
                                            <div class="progress">
                                                <div class="progress-bar {{ $progressClass }}" style="width: {{ $persentase }}%;"></div>
                                            </div>
                                            <div class="progress-value">{{ number_format($persentase, 2) }}%</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($indikator->firstRealisasi?->diverifikasi)
                                            <span class="badge bg-success">Terverifikasi</span>
                                            <div class="small text-muted">
                                                oleh: {{ optional(App\Models\User::find($indikator->verifikasi_oleh))->name }}<br>
                                                {{ \Carbon\Carbon::parse($indikator->verifikasi_pada)->format('d M Y H:i') }}
                                            </div>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if($realisasi)
                                                <a href="{{ route('realisasi.edit', array_merge(['indikator' => $indikator->id], $query)) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @else
                                                <a href="{{ route('realisasi.create', array_merge(['indikator' => $indikator->id], $query)) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Input
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection





