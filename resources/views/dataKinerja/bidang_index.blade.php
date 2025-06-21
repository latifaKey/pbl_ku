@extends('layouts.app')

@section('title', 'Data Kinerja - Analisis Bidang')

@section('styles')
<style>
    .dashboard-content {
        max-width: 1800px;
        margin: 0 auto;
    }

    /* Dashboard Grid Layout */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    /* Bidang Card Styling */
    .bidang-card {
        background: var(--pln-accent-bg, #ffffff);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border, #e8e8e8);
        box-shadow: 0 8px 20px var(--pln-shadow, rgba(0,0,0,0.1));
        transition: all 0.3s ease;
    }

    .bidang-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px var(--pln-shadow, rgba(0,0,0,0.15));
    }

    .bidang-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
    }

    .bidang-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .bidang-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--pln-text, #333);
        margin: 0;
    }

    .bidang-code {
        font-size: 14px;
        font-weight: 400;
        color: var(--pln-text-secondary, #6c757d);
    }

    .bidang-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
        color: white;
        font-size: 22px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .bidang-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--pln-text, #333);
        margin: 15px 0 5px;
    }

    .bidang-description {
        font-size: 14px;
        color: var(--pln-text-secondary, #6c757d);
        margin: 10px 0;
    }

    .bidang-progress {
        height: 8px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        overflow: hidden;
        margin: 15px 0;
    }

    .bidang-progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease-in-out;
        background: linear-gradient(90deg, var(--pln-blue, #007bff), var(--pln-light-blue, #00c6ff));
    }

    .bidang-indicator-count {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }

    .indicator-stat {
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.03);
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

    /* Responsive */
    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid dashboard-content">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Analisis Kinerja Berdasarkan Bidang</h1>
        <div class="d-flex">
            <form action="{{ route('dataKinerja.bidang') }}" method="GET" class="d-flex align-items-center">
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

    <!-- Ringkasan Bidang Chart -->
    <div class="chart-card">
        <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Perbandingan Nilai Bidang</h3>
        <div id="bidangComparisonChart" class="chart-container">
            <div class="loading-chart">
                <i class="fas fa-circle-notch fa-spin fa-3x mb-3"></i>
                <span>Memuat data...</span>
            </div>
        </div>
    </div>

    <!-- Bidang Cards -->
    <div class="dashboard-grid">
        @foreach($bidangs as $bidang)
        <div class="bidang-card">
            <div class="bidang-header">
                <div>
                    <h3 class="bidang-title">{{ $bidang->nama }}</h3>
                    <span class="bidang-code">{{ $bidang->kode }}</span>
                </div>
                <div class="bidang-icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <div class="bidang-value">{{ number_format($bidang->nilai, 2) }}%</div>
            <p class="bidang-description">{{ $bidang->deskripsi ?? 'Bidang Fungsional PLN' }}</p>
            <div class="bidang-progress">
                <div class="bidang-progress-bar" style="width: {{ $bidang->nilai }}%"></div>
            </div>
            <div class="bidang-indicator-count">
                <div class="indicator-stat">
                    <div class="indicator-stat-label">Indikator</div>
                    <div class="indicator-stat-value">{{ $bidang->indikators_count }}</div>
                </div>
                <div class="indicator-stat">
                    <div class="indicator-stat-label">Status</div>
                    <div class="indicator-stat-value">
                        @if($bidang->nilai >= 90)
                            <span class="badge bg-success text-white">Baik</span>
                        @elseif($bidang->nilai >= 70)
                            <span class="badge bg-warning text-dark">Cukup</span>
                        @else
                            <span class="badge bg-danger text-white">Kurang</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('dataKinerja.bidang.detail', $bidang->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-search-plus fa-sm"></i> Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tabel Bidang -->
    <div class="chart-card">
        <h3 class="chart-title"><i class="fas fa-list"></i> Daftar Kinerja Bidang</h3>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Bidang</th>
                        <th>PIC</th>
                        <th>Jumlah Indikator</th>
                        <th>Nilai Kinerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bidangs as $bidang)
                    <tr>
                        <td><strong>{{ $bidang->kode }}</strong></td>
                        <td>{{ $bidang->nama }}</td>
                        <td>{{ $bidang->pic_name ?? '-' }}</td>
                        <td>{{ $bidang->indikators_count }}</td>
                        <td>{{ number_format($bidang->nilai, 2) }}%</td>
                        <td>
                            @if($bidang->nilai >= 90)
                                <span class="badge bg-success text-white">Baik</span>
                            @elseif($bidang->nilai >= 70)
                                <span class="badge bg-warning text-dark">Cukup</span>
                            @else
                                <span class="badge bg-danger text-white">Kurang</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('dataKinerja.bidang.detail', $bidang->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-search-plus fa-sm"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk chart
        const bidangData = @json($bidangChartData);

        // Chart Perbandingan Bidang
        if (bidangData && bidangData.length > 0 && typeof ApexCharts !== 'undefined') {
            const bidangOptions = {
                series: [{
                    name: 'Nilai',
                    data: bidangData.map(item => item.nilai)
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#36b9cc'],
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
                    categories: bidangData.map(item => item.nama),
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
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 4
                }
            };

            const bidangChart = new ApexCharts(document.querySelector('#bidangComparisonChart'), bidangOptions);
            bidangChart.render();
            document.querySelector('#bidangComparisonChart .loading-chart').style.display = 'none';
        }
    });
</script>
@endsection
