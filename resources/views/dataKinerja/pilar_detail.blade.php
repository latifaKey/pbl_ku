@extends('layouts.app')

@section('title', 'Detail Pilar - ' . $pilar->nama)

@section('styles')
<style>
    .dashboard-content {
        max-width: 1800px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Dashboard Layout */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-gap: 20px;
        margin-bottom: 30px;
    }

    .grid-span-6 {
        grid-column: span 6;
    }

    .grid-span-12 {
        grid-column: span 12;
    }

    @media (max-width: 1200px) {
        .grid-span-6 {
            grid-column: span 12;
        }
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
            grid-gap: 15px;
        }
    }

    /* Pilar Header Card */
    .pilar-header-card {
        background: var(--pln-accent-bg, #ffffff);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border, #e8e8e8);
        box-shadow: 0 8px 20px var(--pln-shadow, rgba(0,0,0,0.1));
        display: flex;
        align-items: center;
    }

    .pilar-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--pilar-color, #4e73df);
    }

    .pilar-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--pilar-color, #4e73df);
        color: white;
        font-size: 32px;
        margin-right: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        flex-shrink: 0;
    }

    .pilar-info {
        flex: 1;
    }

    .pilar-name {
        font-size: 24px;
        font-weight: 700;
        color: var(--pln-text, #333);
        margin: 0 0 5px;
    }

    .pilar-code {
        font-size: 16px;
        color: var(--pln-text-secondary, #6c757d);
        margin-bottom: 10px;
    }

    .pilar-description {
        font-size: 15px;
        color: var(--pln-text-secondary, #6c757d);
        margin-bottom: 15px;
    }

    .pilar-value-large {
        font-size: 36px;
        font-weight: 700;
        color: var(--pilar-color, #4e73df);
    }

    .pilar-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .pilar-stat-item {
        text-align: center;
        min-width: 100px;
    }

    .pilar-stat-value {
        font-size: 20px;
        font-weight: 600;
        color: var(--pln-text, #333);
    }

    .pilar-stat-label {
        font-size: 13px;
        color: var(--pln-text-secondary, #6c757d);
    }

    /* Chart Card */
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
        background: var(--pilar-color, #4e73df);
    }

    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow, rgba(0,0,0,0.15));
    }

    .chart-title {
        font-size: 18px;
        color: var(--pilar-color, #4e73df);
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

    /* Indikator Cards */
    .indikator-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .indikator-card {
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

    .indikator-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow, rgba(0,0,0,0.15));
    }

    .indikator-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .indikator-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--pln-text, #333);
        margin: 0 0 5px;
    }

    .indikator-code {
        font-size: 14px;
        font-weight: 500;
        color: var(--pln-text-secondary, #6c757d);
        padding: 3px 8px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
    }

    .indikator-badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-weight: 500;
        font-size: 12px;
        color: white;
    }

    .indikator-bidang {
        font-size: 14px;
        color: var(--pln-text-secondary, #6c757d);
        margin-bottom: 15px;
    }

    .indikator-progress {
        height: 10px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
        margin: 15px 0;
    }

    .indikator-progress-bar {
        height: 100%;
        border-radius: 5px;
        transition: width 0.5s ease-in-out;
    }

    .indikator-values {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .indikator-value-item {
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.03);
        flex: 1;
        min-width: 80px;
    }

    .indikator-value-label {
        font-size: 12px;
        color: var(--pln-text-secondary, #6c757d);
        margin-bottom: 5px;
    }

    .indikator-value-number {
        font-size: 16px;
        font-weight: 600;
        color: var(--pln-text, #333);
    }

    .indikator-actions {
        margin-top: 15px;
        text-align: right;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .pilar-header-card {
            flex-direction: column;
            text-align: center;
        }

        .pilar-icon-large {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .pilar-stats {
            justify-content: center;
        }

        .indikator-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .indikator-grid {
            grid-template-columns: 1fr;
        }

        .indikator-values {
            flex-direction: column;
        }

        .indikator-value-item {
            margin: 5px 0;
        }
    }

    /* Color Variables based on Pilar Code */
    .pilar-a { --pilar-color: #4e73df; }
    .pilar-b { --pilar-color: #1cc88a; }
    .pilar-c { --pilar-color: #36b9cc; }
    .pilar-d { --pilar-color: #f6c23e; }
    .pilar-e { --pilar-color: #e74a3b; }
    .pilar-f { --pilar-color: #6f42c1; }

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
        color: var(--pilar-color, #4e73df);
        margin-bottom: 10px;
    }

    .loading-chart span {
        font-size: 14px;
        color: var(--pln-text-secondary, #6c757d);
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('dataKinerja.pilar') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="h3 mb-0 text-gray-800">Detail Pilar {{ $pilar->nama }}</h1>
        </div>
        <div class="d-flex">
            <form action="{{ route('dataKinerja.pilar', $pilar->id) }}" method="GET" class="d-flex align-items-center">
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

    <!-- Pilar Header -->
    <div class="pilar-header-card pilar-{{ strtolower($pilar->kode) }}">
        <div class="pilar-icon-large">
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
        <div class="pilar-info">
            <h1 class="pilar-name">{{ $pilar->nama }}</h1>
            <div class="pilar-code">Pilar {{ $pilar->kode }}</div>
            <p class="pilar-description">{{ $pilar->deskripsi ?? 'Pilar Strategis PLN' }}</p>
            <div class="pilar-stats">
                <div class="pilar-stat-item">
                    <div class="pilar-value-large">{{ number_format($pilar->nilai, 2) }}%</div>
                    <div class="pilar-stat-label">Nilai Kinerja</div>
                </div>
                <div class="pilar-stat-item">
                    <div class="pilar-stat-value">{{ $pilar->indikators_count }}</div>
                    <div class="pilar-stat-label">Total Indikator</div>
                </div>
                <div class="pilar-stat-item">
                    <div class="pilar-stat-value">{{ $pilar->indikators_tercapai }}</div>
                    <div class="pilar-stat-label">Indikator Tercapai</div>
                </div>
                <div class="pilar-stat-item">
                    <div class="pilar-stat-value">{{ $pilar->indikators_count - $pilar->indikators_tercapai }}</div>
                    <div class="pilar-stat-label">Indikator Belum Tercapai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Perbandingan Indikator -->
    <div class="dashboard-grid">
        <div class="grid-span-6">
            <!-- Grafik Perbandingan Nilai Indikator -->
            <div class="chart-card">
                <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Perbandingan Nilai Indikator</h3>
                <div id="indikatorComparisonChart" class="chart-container">
                    <div class="loading-chart">
                        <i class="fas fa-circle-notch fa-spin fa-3x"></i>
                        <span>Memuat data...</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-span-6">
            <!-- Grafik Trend Bulanan -->
            <div class="chart-card">
                <h3 class="chart-title"><i class="fas fa-chart-line"></i> Trend Bulanan {{ $tahun }}</h3>
                <div id="trendBulananChart" class="chart-container">
                    <div class="loading-chart">
                        <i class="fas fa-circle-notch fa-spin fa-3x"></i>
                        <span>Memuat data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Indikator -->
    <div class="grid-span-12">
        <h3 class="mb-4"><i class="fas fa-list-alt mr-2 pilar-{{ strtolower($pilar->kode) }}"></i> Daftar Indikator</h3>
    </div>

    <div class="indikator-grid">
        @foreach($indikators as $indikator)
        <div class="indikator-card">
            <div class="indikator-header">
                <h3 class="indikator-title">{{ $indikator->nama }}</h3>
                <span class="indikator-code">{{ $indikator->kode }}</span>
            </div>
            <div class="indikator-bidang">
                <i class="fas fa-building mr-1"></i> {{ $indikator->bidang->nama }}
            </div>

            <div class="indikator-progress">
                <div class="indikator-progress-bar" style="width: {{ $indikator->persentase }}%; background-color: {{ $indikator->persentase >= 90 ? '#1cc88a' : ($indikator->persentase >= 70 ? '#f6c23e' : '#e74a3b') }}"></div>
            </div>

            <div class="indikator-values">
                <div class="indikator-value-item">
                    <div class="indikator-value-label">Target</div>
                    <div class="indikator-value-number">{{ number_format($indikator->target, 2) }}</div>
                </div>
                <div class="indikator-value-item">
                    <div class="indikator-value-label">Realisasi</div>
                    <div class="indikator-value-number">{{ number_format($indikator->nilai_aktual, 2) }}</div>
                </div>
                <div class="indikator-value-item">
                    <div class="indikator-value-label">Pencapaian</div>
                    <div class="indikator-value-number">{{ number_format($indikator->persentase, 2) }}%</div>
                </div>
            </div>
            <div class="indikator-actions">
                <a href="{{ route('dataKinerja.indikator', $indikator->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-search-plus fa-sm"></i> Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk chart
        const indikatorData = @json($indikatorChartData);
        const trendData = @json($trendBulanan);

        // Chart Perbandingan Indikator
        if (indikatorData && indikatorData.length > 0 && typeof ApexCharts !== 'undefined') {
            const indikatorOptions = {
                series: [{
                    name: 'Pencapaian',
                    data: indikatorData.map(item => item.persentase)
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['var(--pilar-color)'],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 6,
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
                    categories: indikatorData.map(item => item.kode),
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: true,
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
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 4
                }
            };

            const indikatorChart = new ApexCharts(document.querySelector('#indikatorComparisonChart'), indikatorOptions);
            indikatorChart.render();
            document.querySelector('#indikatorComparisonChart .loading-chart').style.display = 'none';
        }

        // Chart Trend Bulanan
        if (trendData && trendData.length > 0 && typeof ApexCharts !== 'undefined') {
            const trendOptions = {
                series: [{
                    name: 'Nilai Pilar',
                    data: trendData.map(item => item.nilai)
                }],
                chart: {
                    type: 'line',
                    height: 300,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['var(--pilar-color)'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: trendData.map(item => item.bulan),
                    labels: {
                        rotate: -45,
                        rotateAlways: false,
                        style: {
                            fontSize: '10px'
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
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                markers: {
                    size: 5,
                    colors: ['#fff'],
                    strokeColors: 'var(--pilar-color)',
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.3,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 100]
                    }
                }
            };

            const trendChart = new ApexCharts(document.querySelector('#trendBulananChart'), trendOptions);
            trendChart.render();
            document.querySelector('#trendBulananChart .loading-chart').style.display = 'none';
        }
    });
</script>
@endsection
