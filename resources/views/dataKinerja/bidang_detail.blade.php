@extends('layouts.app')

@section('title', 'Detail Bidang')

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
        .grid-span-4, .grid-span-6 {
            grid-column: span 1;
        }
    }

    /* Card Styling */
    .info-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid #e8e8e8;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        height: 100%;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .info-card.primary::before {
        background: #4e73df;
    }

    .info-card.success::before {
        background: #1cc88a;
    }

    .info-card.info::before {
        background: #36b9cc;
    }

    .info-card-body {
        display: flex;
        align-items: center;
    }

    .info-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .info-card.primary .info-card-icon {
        background: #4e73df;
    }

    .info-card.success .info-card-icon {
        background: #1cc88a;
    }

    .info-card.info .info-card-icon {
        background: #36b9cc;
    }

    .info-card-content {
        flex: 1;
    }

    .info-card-label {
        font-size: 14px;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .info-card-value {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    /* Chart Card */
    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        transition: all 0.3s ease;
        border: 1px solid #e8e8e8;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
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
        background: #1cc88a;
    }

    .chart-title {
        font-size: 18px;
        color: #1cc88a;
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
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
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('dataKinerja.bidang') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="h3 mb-0 text-gray-800">Detail Bidang: {{ $bidang->nama }}</h1>
        </div>
        <div class="d-flex">
            <form action="{{ route('dataKinerja.bidang', $bidang->id) }}" method="GET" class="d-flex align-items-center">
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

    <!-- Info Cards -->
    <div class="dashboard-grid">
        <div class="grid-span-4">
            <div class="info-card primary">
                <div class="info-card-body">
                    <div class="info-card-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="info-card-content">
                        <div class="info-card-label">Kode Bidang</div>
                        <div class="info-card-value">{{ $bidang->kode }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-span-4">
            <div class="info-card success">
                <div class="info-card-body">
                    <div class="info-card-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="info-card-content">
                        <div class="info-card-label">Jumlah Indikator</div>
                        <div class="info-card-value">{{ $bidang->indikators->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-span-4">
            <div class="info-card info">
                <div class="info-card-body">
                    <div class="info-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="info-card-content">
                        <div class="info-card-label">Nilai Rata-rata</div>
                        <div class="info-card-value">{{ number_format($bidang->getNilaiRata($tahun, $bulan), 2) }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Card -->
    <div class="dashboard-grid">
        <div class="grid-span-12">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="chart-title mb-0">
                        <i class="fas fa-chart-line mr-2"></i> Trend Bulanan Tahun {{ $tahun }}
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Pilih Tahun:</div>
                            @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <a class="dropdown-item" href="{{ route('dataKinerja.bidang', ['id' => $bidang->id, 'tahun' => $i]) }}">{{ $i }}</a>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="loading-chart">
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div id="trendChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indikator Table -->
    <div class="dashboard-grid">
        <div class="grid-span-12">
            <div class="chart-card">
                <div class="chart-title">
                    <i class="fas fa-table mr-2"></i> Daftar Indikator
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Indikator</th>
                                <th>Pilar</th>
                                <th>Target</th>
                                <th>Realisasi</th>
                                <th>Pencapaian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bidang->indikators as $indikator)
                                <tr>
                                    <td>{{ $indikator->kode }}</td>
                                    <td>{{ $indikator->nama }}</td>
                                    <td>{{ $indikator->pilar->nama }}</td>
                                    <td>{{ number_format($indikator->target, 2) }} {{ $indikator->satuan }}</td>
                                    <td>{{ number_format($indikator->nilai ?? 0, 2) }} {{ $indikator->satuan }}</td>
                                    <td>{{ number_format($indikator->nilai ?? 0, 2) }}%</td>
                                    <td>
                                        @if (($indikator->nilai ?? 0) >= 90)
                                            <span class="badge badge-success">Tercapai</span>
                                        @elseif (($indikator->nilai ?? 0) >= 70)
                                            <span class="badge badge-warning">Perlu Perhatian</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Tercapai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('dataKinerja.indikator', $indikator->id) }}" class="btn btn-sm btn-primary">
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
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk chart
        const trendData = @json($trendBidang);

        if (trendData && trendData.length > 0 && typeof ApexCharts !== 'undefined') {
            const options = {
                series: [{
                    name: 'Nilai Bidang',
                    data: trendData.map(item => item.nilai)
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#1cc88a'],
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + '%';
                    }
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
                    strokeColors: '#1cc88a',
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

            const chart = new ApexCharts(document.querySelector('#trendChart'), options);
            chart.render();
            document.querySelector('.loading-chart').style.display = 'none';
        }

        // Inisialisasi DataTable
        if ($.fn.dataTable) {
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });
        }
    });
</script>
@endsection
