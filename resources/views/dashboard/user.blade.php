{{-- resources/views/dashboard/user.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Kinerja - Karyawan')
@section('page_title', 'DASHBOARD KARYAWAN')

@section('styles')
<style>
    /* Main Container */
    .dashboard-content {
        max-width: 1800px;
        margin: 0 auto;
        padding: 0 15px;
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

    @media (max-width: 1200px) {
        .grid-span-3 {
            grid-column: span 6;
        }
        .grid-span-4 {
            grid-column: span 6;
        }
        .grid-span-6 {
            grid-column: span 12;
        }
        .grid-span-8 {
            grid-column: span 12;
        }
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
        .grid-span-3, .grid-span-4, .grid-span-6, .grid-span-8, .grid-span-12 {
            grid-column: span 1;
        }
    }

    /* Section Divider */
    .section-divider {
        display: flex;
        align-items: center;
        margin: 40px 0 20px;
        position: relative;
    }

    .section-divider h2 {
        font-size: 18px;
        font-weight: 600;
        color: var(--pln-text, #333);
        margin: 0;
        padding-right: 15px;
        background: #f8f9fc;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
    }

    .section-divider h2 i {
        margin-right: 10px;
        color: var(--pln-light-blue, #00c6ff);
    }

    .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e3e6f0;
    }

    /* Card Components */
    .card {
        background: var(--pln-accent-bg, #ffffff);
        border-radius: 16px;
        border: 1px solid var(--pln-border, #e8e8e8);
        box-shadow: 0 8px 20px var(--pln-shadow, rgba(0,0,0,0.1));
        position: relative;
        overflow: hidden;
        height: 100%;
        transition: all 0.3s ease;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow, rgba(0,0,0,0.15));
    }

    /* Stat Card */
    .stat-card {
        padding: 20px;
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
        color: var(--pln-text, #333);
        margin: 0;
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
        color: white;
        font-size: 20px;
        box-shadow: 0 5px 15px rgba(0, 156, 222, 0.3);
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--pln-text, #333);
        margin: 15px 0 5px;
    }

    .stat-description {
        font-size: 13px;
        color: var(--pln-text-secondary, #6c757d);
        margin: 0;
    }

    /* Chart Card */
    .chart-card {
        padding: 25px;
    }

    .chart-title {
        font-size: 18px;
        color: var(--pln-light-blue, #00c6ff);
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .chart-title i {
        margin-right: 10px;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .chart-container.large {
        height: 450px;
    }

    .chart-container.medium {
        height: 400px;
    }

    .chart-container.small {
        height: 300px;
    }

    .loading-chart {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        color: var(--pln-text-secondary, #6c757d);
        padding: 20px;
    }

    /* Table Styling */
    .data-table-container {
        padding: 0;
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }

    .data-table thead th {
        background: linear-gradient(90deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
        color: #fff;
        font-weight: 600;
        text-align: left;
        padding: 15px;
        font-size: 14px;
        border: none;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .data-table tbody tr {
        background-color: var(--pln-accent-bg, #ffffff);
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background-color: rgba(0, 156, 222, 0.05);
    }

    .data-table td {
        padding: 12px 15px;
        border-top: 1px solid var(--pln-border, #e8e8e8);
        font-size: 14px;
        vertical-align: middle;
    }

    .data-table .badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-weight: 500;
        font-size: 12px;
    }

    /* Progress Bar */
    .progress {
        height: 8px;
        background-color: var(--pln-surface, #f0f0f0);
        border-radius: 4px;
        overflow: hidden;
        margin: 10px 0;
    }

    .progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease-in-out;
    }

    /* Filter Bar */
    .filter-bar {
        background: var(--pln-accent-bg, #ffffff);
        border-radius: 16px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid var(--pln-border, #e8e8e8);
        box-shadow: 0 4px 15px var(--pln-shadow, rgba(0,0,0,0.1));
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .export-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        background: linear-gradient(45deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
        color: white;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 156, 222, 0.3);
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 156, 222, 0.4);
    }

    .export-btn i {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('dashboard') }}" method="get" class="form-inline">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <label for="tahun" class="mr-2">Tahun:</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 5;
                                        $endYear = $currentYear;
                                    @endphp

                                    @for($year = $endYear; $year >= $startYear; $year--)
                                        <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-4 mb-2 mb-md-0">
                                <label for="bulan" class="mr-2">Bulan:</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    @php
                                        $namaBulan = [
                                            1 => 'Januari',
                                            2 => 'Februari',
                                            3 => 'Maret',
                                            4 => 'April',
                                            5 => 'Mei',
                                            6 => 'Juni',
                                            7 => 'Juli',
                                            8 => 'Agustus',
                                            9 => 'September',
                                            10 => 'Oktober',
                                            11 => 'November',
                                            12 => 'Desember'
                                        ];
                                    @endphp

                                    @foreach($namaBulan as $value => $nama)
                                        <option value="{{ $value }}" {{ $bulan == $value ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary ml-2">
                                    <i class="fas fa-sync-alt mr-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Bulan: <strong>{{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</strong></h5>
                        <a href="{{ route('eksporPdf.index') }}" class="export-btn">
                            <i class="fas fa-file-pdf"></i> Ekspor PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.alert')

    <!-- Ringkasan Statistik -->
    <div class="dashboard-grid">
        <div class="grid-span-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">NKO Score</h3>
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $nilaiNKO }}</div>
                <p class="stat-description">Nilai Kinerja Organisasi</p>
            </div>
        </div>

        <div class="grid-span-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Indikator</h3>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $totalIndikatorTercapai }}/{{ $totalIndikator }}</div>
                <p class="stat-description">Total Indikator Tercapai</p>
            </div>
        </div>

        <div class="grid-span-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Persentase</h3>
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $persenTercapai }}%</div>
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $persenTercapai }}%"></div>
                </div>
                <p class="stat-description">Pencapaian KPI</p>
            </div>
        </div>

        <div class="grid-span-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">Target {{ $tahun }}</h3>
                    <div class="stat-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                </div>
                <div class="stat-value">100%</div>
                <p class="stat-description">Target Kinerja</p>
            </div>
        </div>
    </div>

    <!-- Chart Tren NKO -->
    <div class="grid-span-12">
        <div class="card chart-card">
            <h3 class="chart-title"><i class="fas fa-chart-line"></i> Tren NKO {{ $tahun }}</h3>
            <div id="nkoTrendChart" class="chart-container large">
                <div class="loading-chart">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Analisis Per-Pilar -->
    <div class="section-divider">
        <h2><i class="fas fa-layer-group"></i>Analisis Per-Pilar</h2>
    </div>

    <div class="dashboard-grid">
        <div class="grid-span-12">
            <div class="card chart-card">
                <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Kinerja Per-Pilar</h3>
                <div id="pilarChart" class="chart-container medium">
                    <div class="loading-chart">
                        <i class="fas fa-circle-notch fa-spin fa-3x mb-3"></i>
                        <span>Memuat data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Analisis Per-Bidang -->
    <div class="section-divider">
        <h2><i class="fas fa-building"></i>Analisis Per-Bidang</h2>
    </div>

    <div class="dashboard-grid">
        <div class="grid-span-12">
            <div class="card chart-card">
                <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Kinerja Per-Bidang</h3>
                <div id="bidangChart" class="chart-container medium">
                    <div class="loading-chart">
                        <i class="fas fa-circle-notch fa-spin fa-3x mb-3"></i>
                        <span>Memuat data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Top & Bottom Indikator -->
    <div class="section-divider">
        <h2><i class="fas fa-sort-amount-down"></i>Indikator Tertinggi & Terendah</h2>
    </div>

    <div class="dashboard-grid">
        <div class="grid-span-6">
            <div class="card chart-card">
                <h3 class="chart-title"><i class="fas fa-arrow-up"></i> Indikator Tertinggi</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Indikator</th>
                                <th>Bidang</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($analisisData['tertinggi']) && is_array($analisisData['tertinggi']))
                                @foreach($analisisData['tertinggi'] as $indikator)
                                <tr>
                                    <td>{{ $indikator['kode'] ?? '-' }}</td>
                                    <td>{{ $indikator['nama'] ?? '-' }}</td>
                                    <td>{{ $indikator['bidang'] ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-success text-white">{{ $indikator['nilai'] ?? 0 }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid-span-6">
            <div class="card chart-card">
                <h3 class="chart-title"><i class="fas fa-arrow-down"></i> Indikator Terendah</h3>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Indikator</th>
                                <th>Bidang</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($analisisData['terendah']) && is_array($analisisData['terendah']))
                                @foreach($analisisData['terendah'] as $indikator)
                                <tr>
                                    <td>{{ $indikator['kode'] ?? '-' }}</td>
                                    <td>{{ $indikator['nama'] ?? '-' }}</td>
                                    <td>{{ $indikator['bidang'] ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-danger text-white">{{ $indikator['nilai'] ?? 0 }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Chart Tren NKO
    initNkoTrendChart();

    // Inisialisasi Chart Per-Pilar
    initPilarChart();

    // Inisialisasi Chart Per-Bidang
    initBidangChart();
});

function initNkoTrendChart() {
    const ctx = document.getElementById('nkoTrendChart');
    const chartData = @json($analisisData['perkembangan'] ?? []);

    // Validasi data
    if (!ctx || !chartData || !Array.isArray(chartData) || chartData.length === 0) {
        if (ctx && ctx.querySelector('.loading-chart')) {
            ctx.querySelector('.loading-chart').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>Tidak ada data tren NKO yang tersedia.</p>
                </div>
            `;
        }
        return;
    }

    // Hapus loading indicator
    if (ctx.querySelector('.loading-chart')) {
        ctx.querySelector('.loading-chart').remove();
    }

    // Siapkan data untuk chart
    const labels = chartData.map(item => item.bulan);
    const values = chartData.map(item => item.nko);

    // Buat chart baru
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nilai NKO',
                data: values,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
}

function initPilarChart() {
    const ctx = document.getElementById('pilarChart');
    const pilarData = @json($pilarData ?? []);

    // Validasi data
    if (!ctx || !pilarData || !Array.isArray(pilarData) || pilarData.length === 0) {
        if (ctx && ctx.querySelector('.loading-chart')) {
            ctx.querySelector('.loading-chart').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>Tidak ada data pilar yang tersedia.</p>
                </div>
            `;
        }
        return;
    }

    // Hapus loading indicator
    if (ctx.querySelector('.loading-chart')) {
        ctx.querySelector('.loading-chart').remove();
    }

    // Buat chart baru
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: pilarData.map(item => item.nama),
            datasets: [{
                label: 'Nilai Pilar',
                data: pilarData.map(item => item.nilai),
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)',
                    'rgba(111, 66, 193, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

function initBidangChart() {
    const ctx = document.getElementById('bidangChart');
    const bidangData = @json($bidangData ?? []);

    // Validasi data
    if (!ctx || !bidangData || !Array.isArray(bidangData) || bidangData.length === 0) {
        if (ctx && ctx.querySelector('.loading-chart')) {
            ctx.querySelector('.loading-chart').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>Tidak ada data bidang yang tersedia.</p>
                </div>
            `;
        }
        return;
    }

    // Hapus loading indicator
    if (ctx.querySelector('.loading-chart')) {
        ctx.querySelector('.loading-chart').remove();
    }

    // Buat chart baru
    new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: bidangData.map(item => item.nama),
            datasets: [{
                label: 'Nilai Bidang',
                data: bidangData.map(item => item.nilai),
                backgroundColor: 'rgba(54, 185, 204, 0.8)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>
@endsection

