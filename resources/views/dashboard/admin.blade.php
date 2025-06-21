@extends('layouts.app')

@section('title', 'Dashboard Kinerja - Admin')
@section('page_title', 'DASHBOARD KINERJA ' . strtoupper($bidang->nama))

@section('styles')
<style>
  .dashboard-content {
    max-width: 1800px;
    margin: 0 auto;
  }

  /* Dashboard Grid System seperti di master.blade.php */
  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 20px;
    margin-bottom: 25px;
    width: 100%;
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

  /* Section Divider */
  .section-divider {
    margin: 30px 0 20px;
    border-bottom: 1px solid var(--pln-border);
    padding-bottom: 10px;
    transition: border-color 0.5s ease;
  }

  .section-divider h2 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--pln-text);
    margin: 0;
    display: flex;
    align-items: center;
    transition: color 0.5s ease;
  }

  .section-divider h2 i {
    margin-right: 10px;
    transition: color 0.5s ease;
  }

  [data-theme="light"] .section-divider h2 i {
    color: #0078b0;
  }

  [data-theme="dark"] .section-divider h2 i {
    color: #4db5ff;
  }

  /* Stat Cards */
  .dashboard-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -12px;
  }

  .dashboard-col {
    flex: 1;
    padding: 0 12px;
    min-width: 250px;
  }

  /* Card styling yang konsisten */
  .card {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.5s ease;
    box-shadow: 0 4px 15px var(--pln-shadow);
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px var(--pln-shadow);
  }

  [data-theme="light"] .card {
    background: #ffffff;
    border: 1px solid #dee2e6;
  }

  [data-theme="dark"] .card {
    background: var(--pln-surface);
    border: 1px solid var(--pln-border);
  }

  .card-header {
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  [data-theme="light"] .card-header {
    border-bottom: 1px solid #dee2e6;
  }

  [data-theme="dark"] .card-header {
    border-bottom: 1px solid var(--pln-border);
  }

  .card-body {
    padding: 20px;
  }

  .card-header.bg-success {
    background: linear-gradient(45deg, #28a745, #20c997);
  }

  .card-header.bg-warning {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
    color: #212529 !important; /* Warna teks yang lebih gelap untuk kontras dengan background kuning */
  }

  .card-header.bg-primary {
    background: linear-gradient(45deg, var(--pln-blue), var(--pln-light-blue));
  }

  .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
  }

  .card-title i {
    margin-right: 8px;
    font-size: 0.9em;
  }

  /* Stat Card */
  .stat-card {
    padding: 20px;
    border-radius: 12px;
    height: 100%;
    display: flex;
    flex-direction: column;
    background: var(--pln-accent-bg);
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
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

  /* Progress Gauge */
  .meter-container {
    position: relative;
    width: 300px;
    height: 200px;
    margin: 0 auto 20px;
    transition: all 0.3s ease;
  }

  .meter-container:hover {
    transform: translateY(-5px);
  }

  .nko-value {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    color: var(--pln-text);
    text-shadow: 0 2px 5px var(--pln-shadow);
    transition: all 0.3s ease;
  }

  .nko-label {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 22px;
    font-weight: 600;
    color: var(--pln-light-blue);
    text-shadow: 0 2px 5px var(--pln-shadow);
    letter-spacing: 1px;
  }

  /* Indikator Grid dan Tab */
  .indikator-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-top: 0;
  }

  .indikator-card {
    background: var(--pln-accent-bg);
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s ease;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
    height: 100%;
  }

  .indikator-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px var(--pln-shadow);
  }

  .indikator-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .indikator-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--pln-light-blue);
    margin: 0;
  }

  .indikator-code {
    font-size: 12px;
    font-weight: 500;
    color: var(--pln-text-secondary);
    background: var(--pln-surface);
    padding: 5px 10px;
    border-radius: 8px;
  }

  .indikator-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--pln-text);
    margin: 15px 0;
  }

  .indikator-target {
    font-size: 14px;
    color: var(--pln-text-secondary);
    margin-bottom: 15px;
  }

  .progress {
    height: 10px;
    background-color: rgba(255,255,255,0.1);
    margin: 15px 0;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
  }

  [data-theme="light"] .progress {
    background-color: rgba(0,0,0,0.1);
  }

  .progress-bar {
    height: 100%;
    border-radius: 5px;
    transition: width 1s ease-in-out;
    background-size: 15px 15px;
    background-image: linear-gradient(
      45deg,
      rgba(255, 255, 255, 0.15) 25%,
      transparent 25%,
      transparent 50%,
      rgba(255, 255, 255, 0.15) 50%,
      rgba(255, 255, 255, 0.15) 75%,
      transparent 75%,
      transparent
    );
    animation: progress-animation 2s linear infinite;
  }

  @keyframes progress-animation {
    0% {
      background-position: 0 0;
    }
    100% {
      background-position: 30px 0;
    }
  }

  .progress-red {
    background-color: #F44336;
  }

  .progress-yellow {
    background-color: #FFC107;
  }

  .progress-green {
    background-color: #4CAF50;
  }

  /* Missing Inputs Alert */
  .missing-inputs-card {
    background: var(--pln-accent-bg);
    border-radius: 12px;
    padding: 20px;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
    height: 100%;
  }

  .missing-inputs-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }

  .missing-inputs-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--pln-text);
    margin: 0;
    display: flex;
    align-items: center;
  }

  .missing-inputs-title i {
    margin-right: 10px;
    color: #FFC107;
  }

  .missing-inputs-list {
    max-height: 250px;
    overflow-y: auto;
    padding-right: 10px;
  }

  .missing-inputs-item {
    padding: 12px 15px;
    border-radius: 8px;
    background: var(--pln-surface);
    margin-bottom: 10px;
    border-left: 3px solid #FFC107;
    transition: all 0.3s ease;
  }

  .missing-inputs-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .missing-inputs-item-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--pln-text);
    margin: 0 0 5px 0;
  }

  .missing-inputs-item-code {
    font-size: 12px;
    color: var(--pln-text-secondary);
    display: inline-block;
    padding: 2px 8px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 4px;
    margin-right: 10px;
  }

  .missing-inputs-action {
    margin-top: 15px;
    text-align: center;
  }

  /* Tren Kinerja Card */
  /* Chart Card Styling */
  .chart-card {
    padding: 20px;
    height: 100%;
  }

  .chart-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0 15px 0;
    color: var(--pln-text);
    display: flex;
    align-items: center;
    transition: color 0.5s ease;
  }

  .chart-title i {
    margin-right: 8px;
    transition: color 0.5s ease;
  }

  [data-theme="light"] .chart-title i {
    color: #0078b0;
  }

  [data-theme="dark"] .chart-title i {
    color: #4db5ff;
  }

  .chart-container {
    position: relative;
    height: 300px;
    margin: 0 auto;
    transition: all 0.5s ease;
  }

  /* Trend Card (using chart-card now) */
  .trend-card {
    background: var(--pln-accent-bg);
    border-radius: 12px;
    padding: 20px;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
    height: 100%;
  }

  .trend-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .trend-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--pln-text);
    margin: 0;
    display: flex;
    align-items: center;
  }

  .trend-title i {
    margin-right: 10px;
    color: var(--pln-light-blue);
  }

  .trend-chart-container {
    height: 300px;
    position: relative;
  }

  .trend-chart-loading {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: rgba(255, 255, 255, 0.8);
    z-index: 10;
  }

  .trend-chart-loading span {
    margin-top: 10px;
    font-size: 14px;
    color: var(--pln-text-secondary);
  }

  .trend-legend {
    display: flex;
    justify-content: center;
    margin-top: 15px;
    flex-wrap: wrap;
  }

  .trend-legend-item {
    display: flex;
    align-items: center;
    margin: 0 15px 5px 0;
  }

  .trend-legend-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 5px;
  }

  .trend-legend-label {
    font-size: 12px;
    color: var(--pln-text-secondary);
  }

  .dashboard-card {
    background: var(--pln-surface);
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--pln-border);
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
  }

  .card-header {
    padding: 15px 20px;
    background: rgba(0, 0, 0, 0.05);
    border-bottom: 1px solid var(--pln-border);
  }

  .card-header h5 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
  }

  .card-header h5 i {
    margin-right: 10px;
    color: var(--pln-light-blue);
  }

  .card-body {
    padding: 20px;
  }

  .approval-stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .approval-stat-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.03);
    width: calc(25% - 15px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }

  .approval-stat-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  }

  .approval-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
  }

  .approval-icon i {
    color: white;
    font-size: 16px;
  }

  .approval-details h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
  }

  .approval-details p {
    margin: 0;
    font-size: 12px;
    color: var(--pln-text-secondary);
  }

  .bg-warning {
    background-color: #ffa502;
  }

  .bg-primary {
    background-color: #1e90ff;
  }

  .bg-info {
    background-color: #2e86de;
  }

  .bg-success {
    background-color: #20bf6b;
  }

  .approval-progress .progress {
    border-radius: 10px;
    overflow: hidden;
    background: rgba(0, 0, 0, 0.05);
  }

  .approval-progress .progress-bar {
    transition: width 1s ease;
  }

    /* Animation for cards and elements */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .fade-in {
    animation: fadeIn 0.6s ease forwards;
  }

  .delay-1 {
    animation-delay: 0.1s;
  }

  .delay-2 {
    animation-delay: 0.2s;
  }

  .delay-3 {
    animation-delay: 0.3s;
  }

  .delay-4 {
    animation-delay: 0.4s;
  }

  /* Pulse animation for important elements */
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }

  .pulse {
    animation: pulse 2s infinite;
  }

  /* Better card hover effects */
  .card {
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  }

  .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
  }

  /* Improved scrollbar for lists */
  .missing-inputs-list::-webkit-scrollbar {
    width: 6px;
  }

  .missing-inputs-list::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
  }

  .missing-inputs-list::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
  }

  .missing-inputs-list::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.3);
  }

  /* Responsive design for mobile */
  @media (max-width: 768px) {
    .dashboard-grid {
      grid-template-columns: 1fr;
    }

    .grid-span-3,
    .grid-span-4,
    .grid-span-6,
    .grid-span-8,
    .grid-span-12 {
      grid-column: span 1;
    }

    .chart-container {
      height: 250px;
    }

    .stat-card {
      margin-bottom: 15px;
    }

    .approval-stat-item {
      width: calc(50% - 10px);
      margin-bottom: 10px;
    }

    .indikator-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 576px) {
    .approval-stat-item {
      width: 100%;
      margin-bottom: 10px;
    }
  }
</style>
@endsection

@section('content')
<div class="container-xl px-4 py-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="section-divider">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard {{ $bidang->nama }}</h2>
      </div>
      <p class="text-muted">Selamat datang di dashboard admin bidang. Silahkan kelola data kinerja bidang Anda.</p>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title mb-0">
            <i class="fas fa-filter mr-2"></i> Filter Data
          </h5>
        </div>
        <div class="card-body">
          <form action="{{ route('dashboard.admin') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
            <div class="form-group mb-0 mr-2">
              <label for="tahun" class="form-label small mb-1">Tahun:</label>
              <select name="tahun" id="tahun" class="form-select form-select-sm">
                @foreach(range(date('Y') - 5, date('Y') + 1) as $year)
                  <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group mb-0 mr-2">
              <label for="bulan" class="form-label small mb-1">Bulan:</label>
              <select name="bulan" id="bulan" class="form-select form-select-sm">
                @foreach(range(1, 12) as $month)
                  <option value="{{ $month }}" {{ $bulan == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="form-label opacity-0 d-block small mb-1">Action:</label>
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter fa-sm mr-1"></i> Filter
              </button>
              <a href="{{ route('realisasi.index') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus-circle mr-1"></i> Input Realisasi
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @include('components.alert')

  <!-- Ringkasan Statistik -->
  <div class="dashboard-grid">
    <div class="grid-span-3">
      <div class="stat-card fade-in delay-1">
        <div class="stat-header">
          <h3 class="stat-title">Nilai Rata-Rata</h3>
          <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
          </div>
        </div>
        <div class="stat-value">{{ $rataRata }}</div>
        <div class="progress">
          <div class="progress-bar {{ $rataRata >= 90 ? 'progress-green' : ($rataRata >= 70 ? 'progress-yellow' : 'progress-red') }}" role="progressbar" style="width: 0%"></div>
        </div>
        <p class="stat-description">Rata-rata nilai indikator bidang</p>
      </div>
    </div>

    <div class="grid-span-3">
      <div class="stat-card fade-in delay-2">
        <div class="stat-header">
          <h3 class="stat-title">Indikator</h3>
          <div class="stat-icon">
            <i class="fas fa-tasks"></i>
          </div>
        </div>
        <div class="stat-value">{{ $indikators->count() }}</div>
        <p class="stat-description">Total indikator dalam bidang</p>
      </div>
    </div>

    <div class="grid-span-3">
      <div class="stat-card fade-in delay-3 {{ $missingInputs->count() > 0 ? 'pulse' : '' }}">
        <div class="stat-header">
          <h3 class="stat-title">Belum Diinput</h3>
          <div class="stat-icon">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
        </div>
        <div class="stat-value">{{ $missingInputs->count() }}</div>
        <p class="stat-description">Indikator yang belum diinput</p>
      </div>
    </div>

    <div class="grid-span-3">
      <div class="stat-card fade-in delay-4">
        <div class="stat-header">
          <h3 class="stat-title">Terverifikasi</h3>
          <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
          </div>
        </div>
        <div class="stat-value">{{ $indikators->where('diverifikasi', true)->count() }}</div>
        <p class="stat-description">Indikator yang sudah diverifikasi</p>
      </div>
    </div>
  </div>

  <!-- Tren Kinerja dan KPI yang belum diinput -->
  <div class="dashboard-grid">
    <div class="grid-span-8">
      <div class="card fade-in delay-1">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title"><i class="fas fa-chart-line"></i> Tren Kinerja {{ $tahun }}</h5>
          <button class="btn btn-sm btn-light" id="refreshTrendChart">
            <i class="fas fa-sync-alt"></i> Refresh
          </button>
        </div>
        <div class="card-body chart-card">
          <div class="chart-container">
            <div class="trend-chart-loading" id="trendChartLoading">
              <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <span>Memuat data...</span>
            </div>
            <canvas id="trendChart"></canvas>
          </div>
          <div class="trend-legend mt-3">
            <div class="trend-legend-item">
              <div class="trend-legend-color" style="background-color: #4e73df;"></div>
              <div class="trend-legend-label">Nilai Rata-rata</div>
            </div>
            <div class="trend-legend-item">
              <div class="trend-legend-color" style="background-color: #1cc88a;"></div>
              <div class="trend-legend-label">Target</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid-span-4">
      <div class="card fade-in delay-2 {{ $missingInputs->count() > 0 ? 'pulse' : '' }}">
        <div class="card-header bg-warning">
          <h5 class="card-title"><i class="fas fa-exclamation-circle"></i> KPI Belum Diinput</h5>
          <span class="badge bg-light text-dark">{{ $missingInputs->count() }} item</span>
        </div>
        <div class="card-body">
          <div class="missing-inputs-list" style="max-height: 300px; overflow-y: auto;">
            @if($missingInputs->count() > 0)
              @foreach($missingInputs as $indikator)
                <div class="missing-inputs-item fade-in" style="animation-delay: {{ 0.1 * $loop->iteration }}s">
                  <h4 class="missing-inputs-item-title">{{ $indikator->nama }}</h4>
                  <span class="missing-inputs-item-code">{{ $indikator->kode }}</span>
                  <a href="{{ route('realisasi.create', ['indikator' => $indikator->id]) }}" class="btn btn-sm btn-primary float-right">
                    <i class="fas fa-plus-circle"></i> Input
                  </a>
                </div>
              @endforeach
            @else
              <div class="alert alert-success">
                <i class="fas fa-check-circle mr-2"></i> Semua KPI sudah diinput untuk periode ini.
              </div>
            @endif
          </div>

          @if($missingInputs->count() > 0)
            <div class="missing-inputs-action mt-3 text-center">
              <a href="{{ route('realisasi.index') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle mr-1"></i> Input Semua KPI
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

      <!-- Daftar Indikator -->
  <div class="dashboard-grid">
    <div class="grid-span-12">
      <div class="card fade-in delay-4">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title"><i class="fas fa-list-ul"></i> Daftar Indikator</h5>
          <div>
            <a href="{{ route('realisasi.index') }}" class="btn btn-sm btn-light">
              <i class="fas fa-plus-circle"></i> Tambah
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="indikator-grid">
            @foreach($indikators as $indikator)
              <div class="indikator-card fade-in" style="animation-delay: {{ 0.1 * $loop->iteration }}s">
                <div class="indikator-header">
                  <h3 class="indikator-title">{{ $indikator->nama }}</h3>
                  <span class="indikator-code">{{ $indikator->kode }}</span>
                </div>

                <div class="indikator-value">{{ $indikator->nilai_persentase }}%</div>

                <div class="indikator-target">
                  <i class="fas fa-bullseye mr-1"></i> Target: {{ $indikator->target ?? 'Belum ditetapkan' }}
                </div>

                <div class="progress">
                  <div class="progress-bar {{ $indikator->nilai_persentase >= 90 ? 'progress-green' : ($indikator->nilai_persentase >= 70 ? 'progress-yellow' : 'progress-red') }}" role="progressbar" style="width: 0%" data-width="{{ $indikator->nilai_persentase }}%"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                  <div>
                    @if($indikator->diverifikasi)
                      <span class="badge bg-success text-white">Terverifikasi</span>
                    @else
                      <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                    @endif
                  </div>

                  <div>
                    <a href="{{ route('realisasi.edit', ['indikator' => $indikator->id]) }}" class="btn btn-sm btn-primary">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('dataKinerja.indikator', ['id' => $indikator->id]) }}" class="btn btn-sm btn-info">
                      <i class="fas fa-eye"></i>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

      <!-- KPI Status Card -->
  <div class="dashboard-grid">
    <div class="grid-span-12">
      <div class="card fade-in delay-3">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title"><i class="fas fa-clipboard-check"></i> Status Approval KPI</h5>
        </div>
        <div class="card-body">
          @php
            $totalKPI = $indikators->count();
            $belumDisetujui = $indikators->filter(function($indikator) use ($tahun, $bulan) {
              $realisasi = App\Models\Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();
              return !$realisasi || $realisasi->getCurrentApprovalLevel() === 0;
            })->count();

            $disetujuiPIC = $indikators->filter(function($indikator) use ($tahun, $bulan) {
              $realisasi = App\Models\Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();
              return $realisasi && $realisasi->getCurrentApprovalLevel() === 1;
            })->count();

            $disetujuiManager = $indikators->filter(function($indikator) use ($tahun, $bulan) {
              $realisasi = App\Models\Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();
              return $realisasi && $realisasi->getCurrentApprovalLevel() === 2;
            })->count();

            $terverifikasi = $indikators->filter(function($indikator) use ($tahun, $bulan) {
              $realisasi = App\Models\Realisasi::where('indikator_id', $indikator->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();
              return $realisasi && $realisasi->getCurrentApprovalLevel() === 3;
            })->count();
          @endphp

          <div class="approval-stats">
            <div class="approval-stat-item fade-in" style="animation-delay: 0.5s">
              <div class="approval-icon bg-warning">
                <i class="fas fa-hourglass-start"></i>
              </div>
              <div class="approval-details">
                <h3>{{ $belumDisetujui }}</h3>
                <p>Belum Disetujui</p>
              </div>
            </div>
            <div class="approval-stat-item fade-in" style="animation-delay: 0.6s">
              <div class="approval-icon bg-primary">
                <i class="fas fa-check"></i>
              </div>
              <div class="approval-details">
                <h3>{{ $disetujuiPIC }}</h3>
                <p>Disetujui PIC</p>
              </div>
            </div>
            <div class="approval-stat-item fade-in" style="animation-delay: 0.7s">
              <div class="approval-icon bg-info">
                <i class="fas fa-check-double"></i>
              </div>
              <div class="approval-details">
                <h3>{{ $disetujuiManager }}</h3>
                <p>Disetujui Manager</p>
              </div>
            </div>
            <div class="approval-stat-item fade-in" style="animation-delay: 0.8s">
              <div class="approval-icon bg-success">
                <i class="fas fa-check-circle"></i>
              </div>
              <div class="approval-details">
                <h3>{{ $terverifikasi }}</h3>
                <p>Terverifikasi</p>
              </div>
            </div>
          </div>

          <div class="approval-progress mt-3 fade-in" style="animation-delay: 0.9s">
            <div class="progress" style="height: 20px;">
              @php
                $belumDisetujuiPercent = $totalKPI > 0 ? ($belumDisetujui / $totalKPI) * 100 : 0;
                $disetujuiPICPercent = $totalKPI > 0 ? ($disetujuiPIC / $totalKPI) * 100 : 0;
                $disetujuiManagerPercent = $totalKPI > 0 ? ($disetujuiManager / $totalKPI) * 100 : 0;
                $terverifikasiPercent = $totalKPI > 0 ? ($terverifikasi / $totalKPI) * 100 : 0;
              @endphp
              <div class="progress-bar bg-warning progress-bar-animated progress-bar-striped" role="progressbar" style="width: 0%" data-width="{{ $belumDisetujuiPercent }}%" title="Belum Disetujui: {{ $belumDisetujui }}"></div>
              <div class="progress-bar bg-primary progress-bar-animated progress-bar-striped" role="progressbar" style="width: 0%" data-width="{{ $disetujuiPICPercent }}%" title="Disetujui PIC: {{ $disetujuiPIC }}"></div>
              <div class="progress-bar bg-info progress-bar-animated progress-bar-striped" role="progressbar" style="width: 0%" data-width="{{ $disetujuiManagerPercent }}%" title="Disetujui Manager: {{ $disetujuiManager }}"></div>
              <div class="progress-bar bg-success progress-bar-animated progress-bar-striped" role="progressbar" style="width: 0%" data-width="{{ $terverifikasiPercent }}%" title="Terverifikasi: {{ $terverifikasi }}"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Inisialisasi Chart Tren Kinerja
  initTrendChart();

  // Animasi progress bar
  animateProgressBars();

  // Refresh Chart ketika tombol refresh diklik
  document.getElementById('refreshTrendChart').addEventListener('click', function() {
    document.getElementById('trendChartLoading').style.display = 'flex';
    setTimeout(function() {
      initTrendChart();
    }, 500);
  });

  function animateProgressBars() {
    // Animasi untuk progress bar pada statistik
    setTimeout(function() {
      const statProgressBar = document.querySelector('.stat-card .progress-bar');
      if (statProgressBar) {
        const targetWidth = parseFloat(statProgressBar.getAttribute('class').includes('progress-green') ? 90 :
                                      statProgressBar.getAttribute('class').includes('progress-yellow') ? 70 : 50);
        statProgressBar.style.width = targetWidth + '%';
      }
    }, 500);

    // Animasi untuk progress bar pada indikator
    const indikatorProgressBars = document.querySelectorAll('.indikator-card .progress-bar');
    indikatorProgressBars.forEach(function(bar, index) {
      setTimeout(function() {
        const targetWidth = bar.getAttribute('data-width');
        bar.style.width = targetWidth;
      }, 800 + (index * 100));
    });

    // Animasi untuk progress bar pada approval status
    const approvalProgressBars = document.querySelectorAll('.approval-progress .progress-bar');
    approvalProgressBars.forEach(function(bar, index) {
      setTimeout(function() {
        const targetWidth = bar.getAttribute('data-width');
        bar.style.width = targetWidth;
      }, 1000 + (index * 200));
    });
  }

  function initTrendChart() {
    const ctx = document.getElementById('trendChart').getContext('2d');
    const historiData = @json($historiData);

    // Validasi data
    if (!historiData || !Array.isArray(historiData) || historiData.length === 0) {
      console.error('Invalid or empty historical data');
      document.getElementById('trendChartLoading').innerHTML = `
        <div class="text-center">
          <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
          <p>Tidak ada data tren yang tersedia.</p>
        </div>
      `;
      return;
    }

    // Siapkan data untuk chart
    const labels = historiData.map(item => item.bulan);
    const values = historiData.map(item => item.nilai);

    // Buat array target (misalnya 80% untuk semua bulan)
    const targets = Array(labels.length).fill(80);

    // Buat chart dengan animasi
    const trendChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Nilai Rata-rata',
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
          },
          {
            label: 'Target',
            data: targets,
            borderColor: '#1cc88a',
            borderWidth: 2,
            borderDash: [5, 5],
            pointRadius: 0,
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 2000,
          easing: 'easeOutQuart'
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#fff',
            bodyColor: '#fff',
            titleFont: {
              family: "'Poppins', sans-serif",
              size: 14
            },
            bodyFont: {
              family: "'Poppins', sans-serif",
              size: 13
            },
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
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
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

    // Sembunyikan loading indicator
    document.getElementById('trendChartLoading').style.display = 'none';
  }

  // Tambahkan efek hover pada card
  const cards = document.querySelectorAll('.card');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-8px)';
      this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.1)';
    });

    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
      this.style.boxShadow = '0 4px 15px var(--pln-shadow)';
    });
  });
});
</script>
@endsection
