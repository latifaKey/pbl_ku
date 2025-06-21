@extends('layouts.app')

@section('title', 'Detail Realisasi KPI')
@section('page_title', 'DETAIL REALISASI KPI')

@section('styles')
<style>
    /* Main Container */
    .dashboard-content {
        max-width: 1800px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Page Header - Modern UI */
    .page-header {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .page-header-subtitle {
        margin-top: 5px;
        font-weight: 400;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .page-header-actions {
        display: flex;
        gap: 10px;
    }

    .page-header-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
    }

    .page-header-badge i {
        margin-right: 5px;
    }

    /* Card Styling - Support Dark/Light Mode */
    .detail-card {
        border-radius: 16px;
        box-shadow: 0 8px 20px var(--pln-shadow);
        background-color: var(--pln-surface);
        margin-bottom: 25px;
        overflow: hidden;
        color: var(--pln-text);
    }

    .detail-card .card-header {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        padding: 15px 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: none;
    }

    .detail-card .card-body {
        padding: 20px;
    }

    /* Info Section Styling */
    .info-section {
        margin-bottom: 25px;
    }

    .info-section h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--pln-blue);
        border-bottom: 1px solid var(--pln-border);
        padding-bottom: 10px;
    }

    /* Status Badge */
    .status-badge {
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }

    .status-badge i {
        margin-right: 5px;
    }

    .status-badge.verified {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .status-badge.pending {
        background-color: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    /* Table Styling */
    .info-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        color: var(--pln-text);
    }

    .info-table th, .info-table td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--pln-border);
    }

    .info-table th {
        font-weight: 600;
        color: var(--pln-text-secondary);
        background-color: var(--pln-accent-bg);
        width: 30%;
    }

    /* Progress Bar */
    .progress-visual {
        height: 20px;
        background: var(--pln-accent-bg);
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        margin: 10px 0;
    }

    .progress-bar-custom {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        transition: width 0.5s ease;
    }

    .progress-label {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: bold;
        color: white;
        text-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
        z-index: 2;
    }

    /* Action Buttons */
    .detail-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        justify-content: center;
    }

    .btn-action {
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-action i {
        margin-right: 8px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px var(--pln-shadow);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .page-header-actions {
            width: 100%;
            justify-content: flex-start;
            margin-top: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Modern Page Header -->
    <div class="page-header">
        <div>
            <h2><i class="fas fa-chart-bar me-2"></i>Detail Realisasi KPI</h2>
            <div class="page-header-subtitle">
                Informasi lengkap realisasi untuk periode:
                {{ \Carbon\Carbon::create(null, $nilaiKPI->bulan, 1)->locale('id')->monthName }} {{ $nilaiKPI->tahun }}
                @if($nilaiKPI->periode_tipe == 'mingguan')
                (Minggu {{ $nilaiKPI->minggu }})
                @endif
            </div>
        </div>
        <div class="page-header-actions">
            @if($nilaiKPI->diverifikasi)
                <div class="page-header-badge">
                    <i class="fas fa-check-circle"></i> Sudah Diverifikasi
                </div>
            @else
                <div class="page-header-badge">
                    <i class="fas fa-clock"></i> Menunggu Verifikasi
                </div>
            @endif
            <a href="{{ route('realisasi.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @include('components.alert')

    <div class="detail-card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">{{ $nilaiKPI->indikator->kode }} - {{ $nilaiKPI->indikator->nama }}</h6>
            @if($nilaiKPI->diverifikasi)
                <span class="status-badge verified">
                    <i class="fas fa-check-circle"></i> Sudah Diverifikasi
                </span>
            @else
                <span class="status-badge pending">
                    <i class="fas fa-clock"></i> Menunggu Verifikasi
                </span>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-section">
                        <h4><i class="fas fa-info-circle me-2"></i>Informasi Indikator</h4>
                        <table class="info-table">
                            <tr>
                                <th>Kode</th>
                                <td>{{ $nilaiKPI->indikator->kode }}</td>
                            </tr>
                            <tr>
                                <th>Nama Indikator</th>
                                <td>{{ $nilaiKPI->indikator->nama }}</td>
                            </tr>
                            <tr>
                                <th>Bidang</th>
                                <td>{{ $nilaiKPI->indikator->bidang->nama }}</td>
                            </tr>
                            <tr>
                                <th>Target</th>
                                <td>{{ number_format($nilaiKPI->indikator->target, 2) }}</td>
                            </tr>
                            @if($nilaiKPI->indikator->deskripsi)
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $nilaiKPI->indikator->deskripsi }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-section">
                        <h4><i class="fas fa-chart-line me-2"></i>Informasi Realisasi</h4>
                        <table class="info-table">
                            <tr>
                                <th>Periode</th>
                                <td>
                                    {{ \Carbon\Carbon::create(null, $nilaiKPI->bulan, 1)->locale('id')->monthName }} {{ $nilaiKPI->tahun }}
                                    @if($nilaiKPI->periode_tipe == 'mingguan')
                                    (Minggu {{ $nilaiKPI->minggu }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Realisasi</th>
                                <td>{{ number_format($nilaiKPI->nilai, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Persentase</th>
                                <td>
                                    @php
                                        $percentage = $nilaiKPI->persentase;
                                        $progressClass = 'bg-danger';
                                        if ($percentage >= 90) {
                                            $progressClass = 'bg-success';
                                        } elseif ($percentage >= 70) {
                                            $progressClass = 'bg-warning';
                                        }
                                    @endphp
                                    <div class="progress-visual">
                                        <div class="progress-bar-custom {{ $progressClass }}" style="width: {{ min($percentage, 100) }}%"></div>
                                        <div class="progress-label">{{ number_format($percentage, 2) }}%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($nilaiKPI->diverifikasi)
                                        <span class="status-badge verified">
                                            <i class="fas fa-check-circle"></i> Diverifikasi
                                        </span>
                                    @else
                                        <span class="status-badge pending">
                                            <i class="fas fa-clock"></i> Belum Diverifikasi
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $nilaiKPI->keterangan ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="info-section">
                        <h4><i class="fas fa-history me-2"></i>Riwayat</h4>
                        <table class="info-table">
                            <tr>
                                <th>Diinput Oleh</th>
                                <td>{{ $nilaiKPI->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Input</th>
                                <td>{{ $nilaiKPI->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($nilaiKPI->diverifikasi)
                            <tr>
                                <th>Diverifikasi Oleh</th>
                                <td>{{ $nilaiKPI->verifikator->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Verifikasi</th>
                                <td>{{ $nilaiKPI->verifikasi_pada ? $nilaiKPI->verifikasi_pada->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="detail-actions">
                <a href="{{ route('realisasi.edit', ['indikator' => $nilaiKPI->indikator_id]) }}" class="btn btn-warning btn-action">
                    <i class="fas fa-edit"></i> Edit Realisasi
                </a>
                @if(auth()->user()->isMasterAdmin() && !$nilaiKPI->diverifikasi)
                    <a href="{{ route('realisasi.verify', $nilaiKPI->id) }}" class="btn btn-success btn-action">
                        <i class="fas fa-check-circle"></i> Verifikasi
                    </a>
                @endif
                @if(auth()->user()->isMasterAdmin() && $nilaiKPI->diverifikasi)
                    <a href="{{ route('realisasi.unverify', $nilaiKPI->id) }}" class="btn btn-danger btn-action">
                        <i class="fas fa-times-circle"></i> Batalkan Verifikasi
                    </a>
                @endif
                <a href="{{ route('realisasi.index') }}" class="btn btn-secondary btn-action">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
