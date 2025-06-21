@extends('layouts.app')

@section('title', 'Data Kinerja - Analisis Pilar')

@section('styles')
<style>
    .dashboard-content {
        max-width: 1800px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Dashboard Grid Layout */
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
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
            grid-gap: 15px;
        }
        .grid-span-3, .grid-span-4, .grid-span-6 {
            grid-column: span 1;
        }
    }

    /* Pilar Card Styling */
    .pilar-card {
        background: var(--pln-accent-bg, #ffffff);
        border-radius: 16px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border, #e8e8e8);
        box-shadow: 0 8px 20px var(--pln-shadow, rgba(0,0,0,0.1));
        transition: all 0.3s ease;
        height: 100%;
    }

    .pilar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow, rgba(0,0,0,0.15));
    }

    .pilar-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
    }

    .pilar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .pilar-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--pln-text, #333);
        margin: 0;
    }

    .pilar-code {
        font-size: 14px;
        font-weight: 400;
        color: var(--pln-text-secondary, #6c757d);
    }

    .pilar-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        flex-shrink: 0;
    }

    .pilar-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--pln-text, #333);
        margin: 15px 0 5px;
    }

    .pilar-description {
        font-size: 14px;
        color: var(--pln-text-secondary, #6c757d);
        margin: 10px 0;
        min-height: 40px;
    }

    .pilar-progress {
        height: 8px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        overflow: hidden;
        margin: 15px 0;
    }

    .pilar-progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease-in-out;
    }

    .pilar-indicator-count {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }

    .indicator-stat {
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.03);
        flex: 1;
        margin: 0 5px;
    }

    .indicator-stat:first-child {
        margin-left: 0;
    }

    .indicator-stat:last-child {
        margin-right: 0;
    }

    .indicator-stat-label {
        font-size: 12px;
        color: var(--pln-text-secondary, #6c757d);
        margin-bottom: 5px;
    }

    .indicator-stat-value {
        font-size: 18px;
        font-weight: 600;
        color: var(--pln-text, #333);
    }

    /* Chart Card Styling */
    .chart-card {
        background: var(--pln-accent-bg, #ffffff);
        border-radius: 16px;
        padding: 25px;
        transition: all 0.3s ease;
        border: 1px solid var(--pln-border, #e8e8e8);
        box-shadow: 0 8px 20px var(--pln-shadow, rgba(0,0,0,0.1));
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
        height: 100%;
    }

    .chart-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
    }

    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow, rgba(0,0,0,0.15));
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

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Data Table Styling */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px var(--pln-shadow, rgba(0,0,0,0.1));
    }

    .data-table thead th {
        background: linear-gradient(90deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
        color: #fff;
        font-weight: 600;
        text-align: left;
        padding: 15px;
        font-size: 14px;
        border: none;
    }

    .data-table tbody tr {
        background-color: var(--pln-accent-bg, #ffffff);
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background-color: rgba(0, 156, 222, 0.05);
        transform: translateY(-2px);
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

    /* Loading indicator */
    .loading-chart {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
    }

    .loading-chart i {
        color: var(--pln-blue, #007bff);
        margin-bottom: 10px;
    }

    /* Color Variables for Pilar Cards */
    .pilar-a { --pilar-color: #4e73df; }
    .pilar-b { --pilar-color: #1cc88a; }
    .pilar-c { --pilar-color: #36b9cc; }
    .pilar-d { --pilar-color: #f6c23e; }
    .pilar-e { --pilar-color: #e74a3b; }
    .pilar-f { --pilar-color: #6f42c1; }

    .pilar-a::before { background: var(--pilar-color); }
    .pilar-b::before { background: var(--pilar-color); }
    .pilar-c::before { background: var(--pilar-color); }
    .pilar-d::before { background: var(--pilar-color); }
    .pilar-e::before { background: var(--pilar-color); }
    .pilar-f::before { background: var(--pilar-color); }

    .pilar-a .pilar-icon { background: var(--pilar-color); }
    .pilar-b .pilar-icon { background: var(--pilar-color); }
    .pilar-c .pilar-icon { background: var(--pilar-color); }
    .pilar-d .pilar-icon { background: var(--pilar-color); }
    .pilar-e .pilar-icon { background: var(--pilar-color); }
    .pilar-f .pilar-icon { background: var(--pilar-color); }

    .pilar-a .pilar-progress-bar { background: var(--pilar-color); }
    .pilar-b .pilar-progress-bar { background: var(--pilar-color); }
    .pilar-c .pilar-progress-bar { background: var(--pilar-color); }
    .pilar-d .pilar-progress-bar { background: var(--pilar-color); }
    .pilar-e .pilar-progress-bar { background: var(--pilar-color); }
    .pilar-f .pilar-progress-bar { background: var(--pilar-color); }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Analisis Kinerja Berdasarkan Pilar</h1>
        </div>
        <div class="d-flex">
            <form action="{{ route('dataKinerja.pilar') }}" method="GET" class="d-flex align-items-center">
                <select name="tahun" class="form-control form-control-sm mr-2">
                    @foreach(range(date('Y') - 5, date('Y') + 1) as $year)
                        <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <select name="bulan" class="form-control form-control-sm mr-2">
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ $bulan == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-filter fa-sm"></i> Filter
                </button>
            </form>
        </div>
    </div>

    @include('components.alert')

    <!-- Ringkasan Pilar Chart -->
    <div class="dashboard-grid">
        <div class="grid-span-12">
            <div class="chart-card">
                <h3 class="chart-title"><i class="fas fa-chart-pie"></i> Perbandingan Nilai Pilar</h3>
                <div id="pilarComparisonChart" class="chart-container">
                    <div class="loading-chart">
                        <i class="fas fa-circle-notch fa-spin fa-3x mb-3"></i>
                        <span>Memuat data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pilar Cards -->
    <div class="dashboard-grid">
        @foreach($pilars as $pilar)
        <div class="grid-span-4">
            <div class="pilar-card pilar-{{ strtolower($pilar->kode) }}">
                <div class="pilar-header">
                    <div>
                        <h3 class="pilar-title">{{ $pilar->nama }}</h3>
                        <span class="pilar-code">Pilar {{ $pilar->kode }}</span>
                    </div>
                    <div class="pilar-icon">
                        @switch(strtolower($pilar->kode))
                            @case('a')
                                <i class="fas fa-coins"></i>
                                @break
                            @case('b')
                                <i class="fas fa-lightbulb"></i>
                                @break
                            @case('c')
                                <i class="fas fa-microchip"></i>
                                @break
                            @case('d')
                                <i class="fas fa-chart-line"></i>
                                @break
                            @case('e')
                                <i class="fas fa-users"></i>
                                @break
                            @case('f')
                                <i class="fas fa-balance-scale"></i>
                                @break
                            @default
                                <i class="fas fa-star"></i>
                        @endswitch
                    </div>
                </div>
                <div class="pilar-value">{{ number_format($pilar->nilai, 2) }}%</div>
                <p class="pilar-description">{{ $pilar->deskripsi ?? 'Pilar Strategis PLN' }}</p>
                <div class="pilar-progress">
                    <div class="pilar-progress-bar" style="width: {{ $pilar->nilai }}%"></div>
                </div>
                <div class="pilar-indicator-count">
                    <div class="indicator-stat">
                        <div class="indicator-stat-label">Total Indikator</div>
                        <div class="indicator-stat-value">{{ $pilar->indikators_count }}</div>
                    </div>
                    <div class="indicator-stat">
                        <div class="indicator-stat-label">Tercapai</div>
                        <div class="indicator-stat-value">{{ $pilar->indikators_tercapai }}</div>
                    </div>
                    <div class="indicator-stat">
                        <div class="indicator-stat-label">Belum Tercapai</div>
                        <div class="indicator-stat-value">{{ $pilar->indikators_count - $pilar->indikators_tercapai }}</div>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('dataKinerja.pilar', $pilar->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-search-plus fa-sm"></i> Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tabel Indikator Utama -->
    <div class="dashboard-grid">
        <div class="grid-span-12">
            <div class="chart-card">
                <h3 class="chart-title"><i class="fas fa-list"></i> Indikator Utama</h3>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Indikator</th>
                                <th>Pilar</th>
                                <th>Bidang</th>
                                <th>Target</th>
                                <th>Realisasi</th>
                                <th>Pencapaian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indikatorUtama as $indikator)
                            <tr>
                                <td><strong>{{ $indikator->kode }}</strong></td>
                                <td>{{ $indikator->nama }}</td>
                                <td>{{ $indikator->pilar->nama }}</td>
                                <td>{{ $indikator->bidang->nama }}</td>
                                <td>{{ number_format($indikator->target, 2) }}</td>
                                <td>{{ number_format($indikator->nilai_aktual, 2) }}</td>
                                <td>{{ number_format($indikator->persentase, 2) }}%</td>
                                <td>
                                    @if($indikator->persentase >= 90)
                                        <span class="badge bg-success text-white">Tercapai</span>
                                    @elseif($indikator->persentase >= 70)
                                        <span class="badge bg-warning text-dark">Perlu Perhatian</span>
                                    @else
                                        <span class="badge bg-danger text-white">Tidak Tercapai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
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
        // Data untuk chart
        const pilarData = @json($pilarChartData);

        // Chart Perbandingan Pilar
        if (pilarData && pilarData.length > 0 && typeof ApexCharts !== 'undefined') {
            const pilarOptions = {
                series: [{
                    name: 'Nilai',
                    data: pilarData.map(item => item.nilai)
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1'],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 6,
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    },
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toFixed(1) + "%";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: pilarData.map(item => item.nama),
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: true,
                        rotate: -45,
                        rotateAlways: false,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0) + '%';
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2) + '%';
                        }
                    }
                },
                legend: {
                    show: false
                }
            };

            const pilarChart = new ApexCharts(document.querySelector('#pilarComparisonChart'), pilarOptions);
            pilarChart.render();
            document.querySelector('#pilarComparisonChart .loading-chart').style.display = 'none';
        }
    });
</script>
@endsection
