@extends('layouts.app')

@section('title', 'Target Kinerja Bidang')
@section('page_title', 'TARGET KINERJA BIDANG')

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

    /* Grid System */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-gap: 20px;
        margin-bottom: 30px;
    }

    .grid-span-3 {
        grid-column: span 3;
    }

    .grid-span-4 {
        grid-column: span 4;
    }

    .grid-span-6 {
        grid-column: span 6;
    }

    .grid-span-8 {
        grid-column: span 8;
    }

    .grid-span-12 {
        grid-column: span 12;
    }

    /* Card Styling - Support Dark/Light Mode */
    .stat-card {
        background: var(--pln-surface);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border);
        box-shadow: 0 8px 20px var(--pln-shadow);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .stat-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--pln-text);
        margin: 0;
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        font-size: 20px;
        box-shadow: 0 5px 15px rgba(0, 156, 222, 0.3);
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--pln-text);
        margin: 15px 0 5px;
    }

    .stat-description {
        font-size: 13px;
        color: var(--pln-text-secondary);
        margin: 0;
    }

    /* Card Pilar - Support Dark/Light Mode */
    .pilar-card {
        background: var(--pln-surface);
        border-radius: 16px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border);
        box-shadow: 0 8px 20px var(--pln-shadow);
        transition: all 0.3s ease;
    }

    .pilar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow);
    }

    .pilar-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    }

    .pilar-card .card-header {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        border: none;
        border-radius: 16px 16px 0 0;
        padding: 15px 20px;
    }

    /* Table Styling - Support Dark/Light Mode */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        color: var(--pln-text);
    }

    .data-table th,
    .data-table td {
        padding: 15px;
        border-bottom: 1px solid var(--pln-border);
    }

    .data-table th {
        background-color: var(--pln-accent-bg);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: var(--pln-text);
    }

    .data-table tbody tr:hover {
        background-color: var(--pln-accent-bg);
    }

    /* Target Status - Support Dark/Light Mode */
    .target-status {
        display: flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 5px;
        white-space: nowrap;
    }

    .target-status.approved {
        background-color: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .target-status.pending {
        background-color: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .target-status.missing {
        background-color: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    .target-status i {
        margin-right: 5px;
    }

    /* Target Button Groups */
    .target-actions {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .target-actions .btn {
        border-radius: 50px;
        padding: 5px 15px;
        font-size: 0.75rem;
        white-space: nowrap;
    }

    /* Tahun Selector - Support Dark/Light Mode */
    .tahun-selector {
        background-color: var(--pln-surface);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 20px var(--pln-shadow);
        margin-bottom: 20px;
        color: var(--pln-text);
        border: 1px solid var(--pln-border);
        position: relative;
        overflow: hidden;
    }

    .tahun-selector::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    }

    .tahun-selector .btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .tahun-selector .btn {
        border-radius: 50px;
        padding: 8px 18px;
    }

    /* Monthly Target Preview */
    .monthly-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 8px;
    overflow-x: auto;       /* scroll horizontal jika penuh */

    }

    .monthly-preview-item {
        width: 22px;
        height: 8px;
        border-radius: 4px;
        background-color: var(--pln-surface-2);
            transition: height 0.2s ease;

    }

    .monthly-preview-item.filled {
        background-color: var(--pln-light-blue);
    }

    .section-divider {
        display: flex;
        align-items: center;
        margin: 30px 0 20px;
        color: var(--pln-light-blue);
    }

    .section-divider h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        color: var(--pln-text);
    }

    .section-divider i {
        margin-right: 10px;
        color: var(--pln-light-blue);
    }

    /* Alert Styles */
    .alert-custom {
        background-color: var(--pln-surface);
        border-left: 4px solid;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 12px var(--pln-shadow);
    }

    .alert-custom .alert-icon {
        font-size: 24px;
        margin-right: 15px;
    }

    .alert-custom.alert-info {
        border-color: var(--pln-blue);
    }

    .alert-custom.alert-info .alert-icon {
        color: var(--pln-blue);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .dashboard-grid {
            grid-template-columns: repeat(6, 1fr);
        }

        .grid-span-3 {
            grid-column: span 3;
        }
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: repeat(1, 1fr);
        }

        .grid-span-3,
        .grid-span-4,
        .grid-span-6,
        .grid-span-8,
        .grid-span-12 {
            grid-column: span 1;
        }

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

    @media (max-width: 576px) {
        .stat-card {
            padding: 15px;
        }

        .tahun-selector .btn {
            font-size: 0.8rem;
            padding: 6px 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Modern Page Header -->
    <div class="page-header">
        <div>
            <h2><i class="fas fa-bullseye me-2"></i>Target Kinerja Bidang</h2>
            <div class="page-header-subtitle">
                Pengelolaan target dan evaluasi kinerja seluruh bidang
            </div>
        </div>
        <div class="page-header-actions">
            @if($tahunPenilaian)
            <div class="page-header-badge">
                <i class="fas fa-chart-pie"></i>
                Total Indikator: {{ $totalIndikators ?? $pilars->sum(function($pilar) { return $pilar->indikators->count(); }) }}
            </div>
            @endif
        </div>
    </div>

    @include('components.alert')

    @if(!$tahunPenilaian)
    <!-- Pesan tidak ada tahun penilaian - Dengan desain yang lebih modern -->
    <div class="alert-custom alert-info">
        <div class="alert-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div>
            <h5 class="font-weight-bold mb-1">Tidak Ada Tahun Penilaian</h5>
            <p class="mb-2">Tidak ada tahun penilaian yang tersedia. Silakan buat tahun penilaian terlebih dahulu untuk melanjutkan.</p>
            <div class="mt-2">
                <a href="{{ route('tahunPenilaian.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle me-1"></i> Buat Tahun Penilaian Baru
                </a>
                <a href="{{ route('tahunPenilaian.index') }}" class="btn btn-outline-secondary btn-sm ms-2">
                    <i class="fas fa-list me-1"></i> Lihat Daftar Tahun Penilaian
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Tahun Selector dengan tampilan yang lebih modern -->
    <div class="tahun-selector">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-0 font-weight-bold"><i class="fas fa-calendar-alt me-2"></i>Tahun Penilaian: {{ $tahunPenilaian->tahun }}</h5>

            @if($tahunPenilaian->is_locked)
            <div class="badge bg-warning p-2 rounded-pill">
                <i class="fas fa-lock me-1"></i> Tahun Terkunci
            </div>
            @endif
        </div>

        <div class="btn-group">
            @foreach(\App\Models\TahunPenilaian::orderBy('tahun', 'desc')->get() as $tp)
                <a href="{{ route('targetKinerja.index', ['tahun_penilaian_id' => $tp->id]) }}"
                   class="btn {{ $tp->id == $tahunPenilaian->id ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $tp->tahun }}
                    @if($tp->is_aktif)
                        <i class="fas fa-star ms-1" data-bs-toggle="tooltip" title="Tahun Aktif"></i>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <!-- Dashboard Stats dengan card yang lebih modern -->
    <div class="dashboard-grid">
        <!-- Total Indikator -->
        <div class="grid-span-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-title">Total Indikator</div>
                <div class="stat-value">{{ $pilars->sum(function($pilar) { return $pilar->indikators->count(); }) }}</div>
                <div class="stat-description">Jumlah indikator yang perlu ditargetkan</div>
            </div>
        </div>

        <!-- Target Disetujui -->
        <div class="grid-span-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-title">Target Disetujui</div>
                <div class="stat-value">
                    @php
                        $totalApproved = 0;
                        foreach($pilars as $pilar) {
                            foreach($pilar->indikators as $indikator) {
                                if(isset($indikator->target_data) && $indikator->target_data->disetujui) {
                                    $totalApproved++;
                                }
                            }
                        }
                        echo $totalApproved;
                    @endphp
                </div>
                <div class="stat-description">Indikator dengan target disetujui</div>
            </div>
        </div>

        <!-- Menunggu Persetujuan -->
        <div class="grid-span-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-title">Menunggu Persetujuan</div>
                <div class="stat-value">
                    @php
                        $totalPending = 0;
                        foreach($pilars as $pilar) {
                            foreach($pilar->indikators as $indikator) {
                                if(isset($indikator->target_data) && !$indikator->target_data->disetujui) {
                                    $totalPending++;
                                }
                            }
                        }
                        echo $totalPending;
                    @endphp
                </div>
                <div class="stat-description">Indikator menunggu persetujuan</div>
            </div>
        </div>

        <!-- Belum Diatur -->
        <div class="grid-span-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-title">Belum Diatur</div>
                <div class="stat-value">
                    @php
                        $totalMissing = 0;
                        foreach($pilars as $pilar) {
                            foreach($pilar->indikators as $indikator) {
                                if(!isset($indikator->target_data)) {
                                    $totalMissing++;
                                }
                            }
                        }
                        echo $totalMissing;
                    @endphp
                </div>
                <div class="stat-description">Indikator tanpa target</div>
            </div>
        </div>
    </div>

    <!-- Accordion Pilar dengan desain yang lebih modern -->
    <div class="section-divider mb-4">
        <h2><i class="fas fa-layer-group"></i> Target Per-Pilar</h2>
    </div>

    <!-- Tampilkan semua pilar secara berurutan dengan desain kartu yang lebih modern -->
    @foreach($pilars as $index => $pilar)
        <div class="pilar-card mb-4" id="pilar-{{ $pilar->kode }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0"><strong>{{ $pilar->kode }}</strong> - {{ $pilar->nama }}
                    <span class="badge bg-light text-dark ms-2">{{ $pilar->indikators->count() }} indikator</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Kode</th>
                                <th width="25%">Indikator</th>
                                <th width="8%">Bobot</th>
                                <th width="15%">Target Tahunan</th>
                                <th width="15%">Target Bulanan</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pilar->indikators as $indIndex => $indikator)
                                <tr>
                                    <td>{{ $indIndex + 1 }}</td>
                                    <td><strong>{{ $indikator->kode }}</strong></td>
                                    <td>
                                        <strong>{{ $indikator->nama }}</strong>
                                        @if($indikator->deskripsi)
                                            <div class="small text-muted">{{ Str::limit($indikator->deskripsi, 60) }}</div>
                                        @endif
                                        <div class="badge bg-info rounded-pill">{{ $indikator->bidang->nama }}</div>
                                        @if(!$indikator->aktif)
                                            <div class="badge bg-warning rounded-pill">Tidak Aktif</div>
                                        @endif
                                    </td>
                                    <td>{{ $indikator->bobot }}%</td>
                                    <td>
                                        @if(isset($indikator->target_data))
                                            <span class="font-weight-bold">{{ number_format($indikator->target_data->target_tahunan, 2) }}</span>
                                        @else
                                            <span class="text-danger">Belum Diatur</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($indikator->target_data) && is_array($indikator->target_data->target_bulanan))
                                            <div class="monthly-preview">
                                                @php
                                                    $bulanan = $indikator->target_data->target_bulanan;
                                                    $max = count($bulanan) > 0 ? max($bulanan) : 0;
                                                @endphp
                                                @foreach($bulanan as $bulan)
                                                    <div class="monthly-preview-item filled" style="height: {{ $max > 0 ? (4 + ($bulan/$max * 8)) : 4 }}px"></div>
                                                @endforeach
                                            </div>
                                            <div class="small text-muted mt-1">
                                                <i class="fas fa-info-circle"></i>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#monthlyModal{{ $indikator->id }}">
                                                    Lihat detail
                                                </a>
                                            </div>

                                            <!-- Modal Target Bulanan -->
                                            <div class="modal fade" id="monthlyModal{{ $indikator->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Target Bulanan: {{ $indikator->kode }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Bulan</th>
                                                                            <th>Target</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($bulanan as $index => $nilai)
                                                                            <tr>
                                                                                <td>{{ \Carbon\Carbon::create(null, $index+1, 1)->locale('id')->monthName }}</td>
                                                                                <td>{{ number_format($nilai, 2) }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="monthly-preview">
                                                @for($i = 0; $i < 12; $i++)
                                                    <div class="monthly-preview-item"></div>
                                                @endfor
                                            </div>
                                            <div class="small text-muted mt-1">
                                                <i class="fas fa-minus-circle"></i> Belum diatur
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($indikator->target_data))
                                            @if($indikator->target_data->disetujui)
                                                <div class="target-status approved">
                                                    <i class="fas fa-check-circle"></i> Disetujui
                                                </div>
                                            @else
                                                <div class="target-status pending">
                                                    <i class="fas fa-clock"></i> Menunggu
                                                </div>
                                            @endif
                                        @else
                                            <div class="target-status missing">
                                                <i class="fas fa-exclamation-circle"></i> Belum Ada
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$tahunPenilaian->is_locked)
                                            <div class="target-actions">
                                                @if(isset($indikator->target_data))
                                                    <a href="{{ route('targetKinerja.edit', $indikator->target_data->id) }}"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    @if(!$indikator->target_data->disetujui)
                                                        <a href="{{ route('targetKinerja.approve', $indikator->target_data->id) }}"
                                                           class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Setujui
                                                        </a>
                                                    @else
                                                        <a href="{{ route('targetKinerja.unapprove', $indikator->target_data->id) }}"
                                                           class="btn btn-sm btn-warning">
                                                            <i class="fas fa-times"></i> Batal
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('targetKinerja.create', ['indikator_id' => $indikator->id, 'tahun_penilaian_id' => $tahunPenilaian->id]) }}"
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-plus"></i> Tambah Target
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="fas fa-lock"></i> Terkunci
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada indikator untuk pilar ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        console.log('Document ready!');

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Tambahkan ID ke setiap pilar card untuk navigasi
        $('.pilar-card').each(function(index) {
            var pilarCode = $(this).find('.card-header strong').text();
            if (pilarCode) {
                $(this).attr('id', 'pilar-' + pilarCode);
            }
        });
    });
</script>
@endsection
