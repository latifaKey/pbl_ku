@extends('layouts.app')

@section('title', 'Dashboard Kinerja - Admin')
@section('page_title', 'DASHBOARD KINERJA ' . strtoupper($bidang->nama))

@section('styles')
<style>
  .dashboard-content {
    max-width: 1800px;
    margin: 0 auto;
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

  .stat-card {
    background: var(--pln-accent-bg);
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
    border-radius: 16px;
    padding: 20px;
    transition: all 0.3s ease;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
    height: 100%;
  }

  .indikator-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
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
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 25px;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
  }

  .missing-inputs-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #FFC107, #FF9800);
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
  .trend-card {
    background: var(--pln-accent-bg);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 25px;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
  }

  .trend-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
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

  @media (max-width: 768px) {
    .approval-stat-item {
      width: calc(50% - 10px);
      margin-bottom: 10px;
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
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="m-0">Data Bulan: <strong>{{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</strong></h5>
            <div>
              <a href="{{ route('realisasi.index') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle mr-1"></i> Input Realisasi
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('components.alert')

  <!-- Ringkasan Statistik -->
  <div class="dashboard-row">
    <div class="dashboard-col">
      <div class="stat-card">
        <div class="stat-header">
          <h3 class="stat-title">Nilai Rata-Rata</h3>
          <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
          </div>
        </div>
        <div class="stat-value">{{ $rataRata }}</div>
        <div class="progress">
          <div class="progress-bar {{ $rataRata >= 90 ? 'progress-green' : ($rataRata >= 70 ? 'progress-yellow' : 'progress-red') }}" role="progressbar" style="width: {{ $rataRata }}%"></div>
        </div>
        <p class="stat-description">Rata-rata nilai indikator bidang</p>
      </div>
    </div>

    <div class="dashboard-col">
      <div class="stat-card">
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

    <div class="dashboard-col">
      <div class="stat-card">
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

    <div class="dashboard-col">
      <div class="stat-card">
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
  <div class="row">
    <div class="col-md-8">
      <div class="trend-card">
        <div class="trend-header">
          <h3 class="trend-title"><i class="fas fa-chart-line"></i> Tren Kinerja {{ $tahun }}</h3>
          <button class="btn btn-sm btn-outline-primary" id="refreshTrendChart">
            <i class="fas fa-sync-alt"></i> Refresh
          </button>
        </div>
        <div class="trend-chart-container">
          <div class="trend-chart-loading" id="trendChartLoading">
            <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <span>Memuat data...</span>
          </div>
          <canvas id="trendChart"></canvas>
        </div>
        <div class="trend-legend">
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

    <div class="col-md-4">
      <div class="missing-inputs-card">
        <div class="missing-inputs-header">
          <h3 class="missing-inputs-title"><i class="fas fa-exclamation-circle"></i> KPI Belum Diinput</h3>
          <span class="badge bg-warning text-dark">{{ $missingInputs->count() }} item</span>
        </div>

        <div class="missing-inputs-list">
          @if($missingInputs->count() > 0)
            @foreach($missingInputs as $indikator)
              <div class="missing-inputs-item">
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
          <div class="missing-inputs-action">
            <a href="{{ route('realisasi.index') }}" class="btn btn-primary">
              <i class="fas fa-plus-circle mr-1"></i> Input Semua KPI
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Daftar Indikator -->
  <h4 class="mb-4"><i class="fas fa-list-ul mr-2 text-primary"></i> Daftar Indikator</h4>

  <div class="indikator-grid">
    @foreach($indikators as $indikator)
      <div class="indikator-card">
        <div class="indikator-header">
          <h3 class="indikator-title">{{ $indikator->nama }}</h3>
          <span class="indikator-code">{{ $indikator->kode }}</span>
        </div>

        <div class="indikator-value">{{ $indikator->nilai_persentase }}%</div>

        <div class="indikator-target">
          <i class="fas fa-bullseye mr-1"></i> Target: {{ $indikator->target ?? 'Belum ditetapkan' }}
        </div>

        <div class="progress">
          <div class="progress-bar {{ $indikator->nilai_persentase >= 90 ? 'progress-green' : ($indikator->nilai_persentase >= 70 ? 'progress-yellow' : 'progress-red') }}" role="progressbar" style="width: {{ $indikator->nilai_persentase }}%"></div>
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

  <!-- KPI Status Card -->
  <div class="card dashboard-card mb-4 fade-in" style="animation-delay: 0.2s">
    <div class="card-header">
      <h5><i class="fas fa-clipboard-check"></i> Status Approval KPI</h5>
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
        <div class="approval-stat-item">
          <div class="approval-icon bg-warning">
            <i class="fas fa-hourglass-start"></i>
          </div>
          <div class="approval-details">
            <h3>{{ $belumDisetujui }}</h3>
            <p>Belum Disetujui</p>
          </div>
        </div>
        <div class="approval-stat-item">
          <div class="approval-icon bg-primary">
            <i class="fas fa-check"></i>
          </div>
          <div class="approval-details">
            <h3>{{ $disetujuiPIC }}</h3>
            <p>Disetujui PIC</p>
          </div>
        </div>
        <div class="approval-stat-item">
          <div class="approval-icon bg-info">
            <i class="fas fa-check-double"></i>
          </div>
          <div class="approval-details">
            <h3>{{ $disetujuiManager }}</h3>
            <p>Disetujui Manager</p>
          </div>
        </div>
        <div class="approval-stat-item">
          <div class="approval-icon bg-success">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="approval-details">
            <h3>{{ $terverifikasi }}</h3>
            <p>Terverifikasi</p>
          </div>
        </div>
      </div>

      <div class="approval-progress mt-3">
        <div class="progress" style="height: 20px;">
          @php
            $belumDisetujuiPercent = $totalKPI > 0 ? ($belumDisetujui / $totalKPI) * 100 : 0;
            $disetujuiPICPercent = $totalKPI > 0 ? ($disetujuiPIC / $totalKPI) * 100 : 0;
            $disetujuiManagerPercent = $totalKPI > 0 ? ($disetujuiManager / $totalKPI) * 100 : 0;
            $terverifikasiPercent = $totalKPI > 0 ? ($terverifikasi / $totalKPI) * 100 : 0;
          @endphp
          <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $belumDisetujuiPercent }}%" title="Belum Disetujui: {{ $belumDisetujui }}"></div>
          <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $disetujuiPICPercent }}%" title="Disetujui PIC: {{ $disetujuiPIC }}"></div>
          <div class="progress-bar bg-info" role="progressbar" style="width: {{ $disetujuiManagerPercent }}%" title="Disetujui Manager: {{ $disetujuiManager }}"></div>
          <div class="progress-bar bg-success" role="progressbar" style="width: {{ $terverifikasiPercent }}%" title="Terverifikasi: {{ $terverifikasi }}"></div>
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

  // Refresh Chart ketika tombol refresh diklik
  document.getElementById('refreshTrendChart').addEventListener('click', function() {
    document.getElementById('trendChartLoading').style.display = 'flex';
    setTimeout(function() {
      initTrendChart();
    }, 500);
  });

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

    // Buat chart
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
});
</script>
@endsection
