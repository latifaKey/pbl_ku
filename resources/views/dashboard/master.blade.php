{{-- resources/views/dashboard/master.blade.php --}}
@extends('layouts.app')

@section('title', 'Master Admin Dashboard')

@section('styles')
<style>
  /* Dashboard Layout System */
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

  /* Card Styling yang Konsisten untuk tema terang dan gelap */
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

  /* Stat Card Styling */
  .stat-card {
    padding: 20px;
    border-radius: 12px;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }

  .stat-title {
    font-size: 1rem;
    font-weight: 500;
    color: var(--pln-text-secondary);
    margin: 0;
  }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    transition: all 0.5s ease;
  }

  [data-theme="light"] .stat-icon {
    background: rgba(0, 120, 176, 0.1);
    color: #0078b0;
  }

  [data-theme="dark"] .stat-icon {
    background: rgba(0, 156, 222, 0.15);
    color: #4db5ff;
  }

  .stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin: 5px 0;
    color: var(--pln-text);
    transition: color 0.5s ease;
  }

  .stat-description {
    font-size: 0.85rem;
    color: var(--pln-text-secondary);
    margin: 0;
    transition: color 0.5s ease;
  }

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

  .chart-container.medium {
    height: 300px;
  }

  .chart-container.large {
    height: 400px;
  }

  /* Gauge Center Text */
  #gauge-center-text h3 {
    transition: color 0.5s ease;
  }

  #gauge-center-text p {
    transition: color 0.5s ease;
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

  /* Table Styling */
  .table-responsive {
    overflow-x: auto;
    border-radius: 8px;
  }

  .data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .data-table thead th {
    text-align: left;
    padding: 12px 15px;
    font-size: 0.9rem;
    font-weight: 600;
    border-bottom: 2px solid var(--pln-border);
    transition: all 0.5s ease;
  }

  [data-theme="light"] .data-table thead th {
    background: #f8f9fa;
    color: #333333;
  }

  [data-theme="dark"] .data-table thead th {
    background: var(--pln-surface-2);
    color: var(--pln-text);
  }

  .data-table tbody td {
    padding: 12px 15px;
    border-bottom: 1px solid var(--pln-border);
    font-size: 0.9rem;
    color: var(--pln-text);
    vertical-align: middle;
    transition: all 0.5s ease;
  }

  .data-table tbody tr:hover {
    background: var(--pln-accent-bg);
  }

  /* Pengaturan untuk tabel di Bootstrap */
  .table-hover tbody tr:hover {
    background-color: var(--pln-accent-bg);
  }

  .table thead th {
    color: var(--pln-text);
    border-bottom-color: var(--pln-border);
    transition: all 0.5s ease;
  }

  .table tbody td {
    color: var(--pln-text);
    border-color: var(--pln-border);
    transition: all 0.5s ease;
  }

  .table-responsive {
    margin-bottom: 1rem;
  }

  .thead-light th {
    background-color: var(--pln-surface-2);
    color: var(--pln-text);
    border-color: var(--pln-border);
    transition: all 0.5s ease;
  }

  /* Empty State */
  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 30px;
    color: var(--pln-text-secondary);
    transition: color 0.5s ease;
  }

  /* Text colors yang kontras dan terlihat untuk light dan dark */
  [data-theme="light"] .text-success {
    color: #1e7e34 !important;
    font-weight: 600;
  }

  [data-theme="light"] .text-warning {
    color: #d39e00 !important;
    font-weight: 600;
  }

  [data-theme="light"] .text-primary {
    color: #0078b0 !important;
    font-weight: 600;
  }

  [data-theme="light"] .text-muted {
    color: #6c757d !important;
  }

  [data-theme="dark"] .text-success {
    color: #34eb52 !important;
    font-weight: 600;
  }

  [data-theme="dark"] .text-warning {
    color: #ffdf4f !important;
    font-weight: 600;
  }

  [data-theme="dark"] .text-primary {
    color: #4db5ff !important;
    font-weight: 600;
  }

  [data-theme="dark"] .text-muted {
    color: rgba(248, 250, 252, 0.7) !important;
  }

  /* Indikator performa untuk tema light dan dark */
  .performance-indicator {
    display: inline-flex;
    align-items: center;
    padding: 3px 8px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    margin-left: 8px;
    transition: all 0.5s ease;
  }

  .performance-indicator i {
    margin-right: 5px;
  }

  [data-theme="light"] .performance-indicator.high {
    color: #1e7e34;
    background-color: rgba(40, 167, 69, 0.15);
    border: 1px solid rgba(40, 167, 69, 0.3);
  }

  [data-theme="light"] .performance-indicator.medium {
    color: #d39e00;
    background-color: rgba(255, 193, 7, 0.15);
    border: 1px solid rgba(255, 193, 7, 0.3);
  }

  [data-theme="light"] .performance-indicator.low {
    color: #bd2130;
    background-color: rgba(220, 53, 69, 0.15);
    border: 1px solid rgba(220, 53, 69, 0.3);
  }

  [data-theme="dark"] .performance-indicator.high {
    color: #34eb52;
    background-color: rgba(40, 167, 69, 0.15);
    border: 1px solid rgba(40, 167, 69, 0.3);
  }

  [data-theme="dark"] .performance-indicator.medium {
    color: #ffdf4f;
    background-color: rgba(255, 193, 7, 0.15);
    border: 1px solid rgba(255, 193, 7, 0.3);
  }

  [data-theme="dark"] .performance-indicator.low {
    color: #ff5a6a;
    background-color: rgba(220, 53, 69, 0.15);
    border: 1px solid rgba(220, 53, 69, 0.3);
  }

  /* Form styling yang terintegrasi untuk light dan dark mode */
  .form-select,
  .form-control {
    transition: all 0.5s ease;
  }

  [data-theme="light"] .form-select,
  [data-theme="light"] .form-control {
    background-color: #ffffff;
    border-color: #dee2e6;
    color: #333333;
  }

  [data-theme="light"] .form-select:focus,
  [data-theme="light"] .form-control:focus {
    background-color: #ffffff;
    border-color: #0078b0;
    color: #333333;
    box-shadow: 0 0 0 0.25rem rgba(0, 120, 176, 0.25);
  }

  [data-theme="light"] .form-label {
    color: #333333;
    font-weight: 500;
    transition: color 0.5s ease;
  }

  [data-theme="dark"] .form-select,
  [data-theme="dark"] .form-control {
    background-color: #1e293b;
    border-color: rgba(248, 250, 252, 0.1);
    color: #f8fafc;
  }

  [data-theme="dark"] .form-select:focus,
  [data-theme="dark"] .form-control:focus {
    background-color: #1e293b;
    border-color: #0091d1;
    color: #f8fafc;
    box-shadow: 0 0 0 0.25rem rgba(0, 156, 222, 0.25);
  }

  [data-theme="dark"] .form-label {
    color: #f8fafc;
    font-weight: 500;
    transition: color 0.5s ease;
  }

  /* Variabel untuk dark/light mode chart */
  :root {
    --chart-grid-color: rgba(0, 0, 0, 0.1);
    --chart-text-color: #333333;
    --chart-success-color: rgba(40, 167, 69, 0.7);
    --chart-success-border: #28a745;
    --chart-warning-color: rgba(255, 193, 7, 0.7);
    --chart-warning-border: #ffc107;
    --chart-primary-color: rgba(0, 120, 176, 0.3);
    --chart-primary-border: #0078b0;
    --chart-background: rgba(255, 255, 255, 0.9);
    --chart-tooltip-bg: rgba(255, 255, 255, 0.95);
    --chart-tooltip-text: #333333;
    --chart-tooltip-border: #dee2e6;
    --chart-legend-text: #333333;
    --transition-speed: 0.5s;
  }

  [data-theme="dark"] {
    --chart-grid-color: rgba(255, 255, 255, 0.1);
    --chart-text-color: #f8fafc;
    --chart-success-color: rgba(40, 167, 69, 0.7);
    --chart-success-border: #34eb52;
    --chart-warning-color: rgba(255, 193, 7, 0.7);
    --chart-warning-border: #ffdf4f;
    --chart-primary-color: rgba(0, 156, 222, 0.3);
    --chart-primary-border: #4db5ff;
    --chart-background: rgba(0, 0, 0, 0.05);
    --chart-tooltip-bg: rgba(30, 41, 59, 0.95);
    --chart-tooltip-text: #f8fafc;
    --chart-tooltip-border: #334155;
    --chart-legend-text: #f8fafc;
    --transition-speed: 0.5s;
  }

  /* Transisi global untuk perubahan tema */
  * {
    transition-property: color, background-color, border-color, box-shadow;
    transition-duration: var(--transition-speed);
    transition-timing-function: ease;
  }

  /* Button dan form styling dipindahkan ke variabel tema */
  .btn-primary {
    color: #fff;
    transition: all 0.5s ease;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
  }

  [data-theme="light"] .btn-primary {
    background-color: #0078b0;
    border-color: #0078b0;
  }

  [data-theme="light"] .btn-primary:hover {
    background-color: #005d8a;
    border-color: #005d8a;
  }

  [data-theme="dark"] .btn-primary {
    background-color: #0091d1;
    border-color: #0091d1;
  }

  [data-theme="dark"] .btn-primary:hover {
    background-color: #00a7f5;
    border-color: #00a7f5;
  }

  /* Tab styling yang lebih konsisten */
  .nav-tabs {
    border-bottom: 2px solid rgba(0, 156, 222, 0.1);
    margin-bottom: 25px;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    transition: border-color 0.5s ease;
  }

  .nav-tabs .nav-item {
    margin-bottom: -2px;
  }

  .nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    background: transparent;
    color: var(--pln-text-secondary);
    font-weight: 500;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    transition: all 0.5s ease;
    font-size: 15px;
    position: relative;
    cursor: pointer;
  }

  .nav-tabs .nav-link:hover {
    color: var(--pln-light-blue);
    border-color: rgba(0, 156, 222, 0.5);
    background: var(--pln-accent-bg);
  }

  .nav-tabs .nav-link.active {
    color: var(--pln-light-blue);
    border-color: var(--pln-light-blue);
    background: var(--pln-accent-bg);
    font-weight: 600;
  }

  .nav-tabs .nav-link .badge {
    padding: 5px 8px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 11px;
    transition: all 0.5s ease;
    margin-left: 8px;
    box-shadow: 0 2px 5px var(--pln-shadow);
  }

  .tab-content > .tab-pane {
    display: none;
  }

  .tab-content > .active {
    display: block;
    animation: fadeIn 0.5s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Badge styling untuk light dan dark mode */
  .badge {
    padding: 5px 10px;
    border-radius: 30px;
    font-weight: 500;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.5s ease;
  }

  .badge i {
    margin-right: 3px;
  }

  /* Light mode badges */
  [data-theme="light"] .badge-secondary {
    background-color: #6c757d;
    color: #fff;
  }

  [data-theme="light"] .badge-success {
    background-color: #28a745;
    color: #fff;
  }

  [data-theme="light"] .badge-primary {
    background-color: #0078b0;
    color: #fff;
  }

  [data-theme="light"] .badge-warning {
    background-color: #ffc107;
    color: #212529; /* Warna teks gelap untuk kontras dengan background kuning */
  }

  /* Dark mode badges */
  [data-theme="dark"] .badge-warning {
    background-color: #ffc107;
    color: #212529; /* Tetap gelap agar terlihat kontras */
  }

  [data-theme="dark"] .badge-success {
    background-color: #28a745;
    color: #fff;
  }

  [data-theme="dark"] .badge-secondary {
    background-color: #6c757d;
    color: #fff;
  }

  [data-theme="dark"] .badge-primary {
    background-color: #0078b0;
    color: #fff;
  }

  /* Responsive design untuk mobile */
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
  }

  /* Kinerja Tertinggi Card */
  .top-performer-card {
    border-left: 4px solid #28a745;
    margin-bottom: 15px;
    padding: 15px;
    border-radius: 8px;
    background-color: rgba(40, 167, 69, 0.05);
    transition: all 0.3s ease;
  }

  .top-performer-card:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .top-performer-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
  }

  .top-performer-title {
    font-weight: 600;
    color: var(--pln-text);
    font-size: 1rem;
    margin: 0;
  }

  .top-performer-value {
    font-weight: 700;
    color: #28a745;
    font-size: 1.1rem;
  }

  .top-performer-info {
    font-size: 0.85rem;
    color: var(--pln-text-secondary);
  }

  /* Task Overview Styling */
  .task-overview {
    margin-top: 20px;
  }

  .task-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--pln-border);
  }

  .task-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
  }

  .task-icon.pending {
    background-color: rgba(255, 193, 7, 0.2);
    color: #ffc107;
  }

  .task-icon.completed {
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
  }

  .task-icon.urgent {
    background-color: rgba(220, 53, 69, 0.2);
    color: #dc3545;
  }

  .task-content {
    flex: 1;
  }

  .task-title {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--pln-text);
    margin: 0 0 5px 0;
  }

  .task-meta {
    display: flex;
    font-size: 0.8rem;
    color: var(--pln-text-secondary);
  }

  .task-meta span {
    margin-right: 15px;
    display: flex;
    align-items: center;
  }

  .task-meta i {
    margin-right: 5px;
    font-size: 0.75rem;
  }

  .task-status {
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
  }

  .task-status.pending {
    background-color: rgba(255, 193, 7, 0.2);
    color: #ffc107;
  }

  .task-status.completed {
    background-color: rgba(40, 167, 69, 0.2);
    color: #28a745;
  }

  .task-status.urgent {
    background-color: rgba(220, 53, 69, 0.2);
    color: #dc3545;
  }
</style>
@endsection

@section('content')
<div class="container-xl px-4 py-4">
  <div class="row mb-4">
    <div class="col-12">
      <div class="section-divider">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard Master Admin</h2>
      </div>
      <p class="text-muted">Selamat datang di dashboard master admin. Silahkan pilih tab untuk melihat data.</p>
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
          <form action="{{ route('dashboard.master') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
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
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistik Ringkasan -->
  <div class="dashboard-grid">
    <div class="grid-span-3">
      <div class="card stat-card">
        <div class="stat-header">
          <h3 class="stat-title">NKO Score</h3>
          <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
          </div>
        </div>
        <div class="stat-value">{{ $data['nko'] ?? 0 }}%</div>
        <p class="stat-description">Nilai Kinerja Organisasi</p>
      </div>
    </div>

    <div class="grid-span-3">
      <div class="card stat-card">
        <div class="stat-header">
          <h3 class="stat-title">Pilar</h3>
          <div class="stat-icon">
            <i class="fas fa-layer-group"></i>
          </div>
        </div>
        <div class="stat-value">{{ count($data['pilar'] ?? []) }}</div>
        <p class="stat-description">Total Pilar Kinerja</p>
      </div>
    </div>

    <div class="grid-span-3">
      <div class="card stat-card">
        <div class="stat-header">
          <h3 class="stat-title">Kinerja Tinggi</h3>
          <div class="stat-icon">
            <i class="fas fa-arrow-up"></i>
          </div>
        </div>
        <div class="stat-value">{{ collect($data['pilar'] ?? [])->where('nilai', '>=', 80)->count() }}</div>
        <p class="stat-description">Pilar dengan Kinerja ≥ 80%</p>
      </div>
    </div>

    <div class="grid-span-3">
      <div class="card stat-card">
        <div class="stat-header">
          <h3 class="stat-title">Perlu Perhatian</h3>
          <div class="stat-icon">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
        </div>
        <div class="stat-value">{{ collect($data['pilar'] ?? [])->where('nilai', '<', 70)->count() }}</div>
        <p class="stat-description">Pilar dengan Kinerja < 70%</p>
      </div>
    </div>
  </div>

  <!-- Dashboard Overview -->
  <div class="dashboard-grid">
    <div class="grid-span-6">
      <div class="card chart-card">
        <h3 class="chart-title"><i class="fas fa-chart-pie"></i> Gauge NKO</h3>
        <div class="d-flex flex-column align-items-center justify-content-center">
          <div style="position: relative; height: 200px; width: 300px;">
            <canvas id="gaugeChart"></canvas>
            <div id="gauge-center-text" style="position: absolute; top: 60%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
              <h3 class="mb-0 fw-bold">{{ $data['nko'] }}%</h3>
              <p class="mb-0 small text-muted">NKO Score</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid-span-6">
      <div class="card chart-card">
        <h3 class="chart-title"><i class="fas fa-chart-line"></i> Trend Kinerja {{ $tahun }}</h3>
        <div class="chart-container medium">
          <canvas id="trendChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Tab Navigation -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua" type="button" role="tab" aria-controls="semua" aria-selected="true">
        <i class="fas fa-table me-2"></i>Semua Pilar
        <span class="badge badge-secondary">{{ count($data['pilar'] ?? []) }}</span>
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tinggi-tab" data-bs-toggle="tab" data-bs-target="#kinerja-tinggi" type="button" role="tab" aria-controls="kinerja-tinggi" aria-selected="false">
        <i class="fas fa-arrow-up me-2"></i>Kinerja Tinggi
        <span class="badge badge-success">{{ collect($data['pilar'] ?? [])->where('nilai', '>=', 80)->count() }}</span>
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="rendah-tab" data-bs-toggle="tab" data-bs-target="#kinerja-rendah" type="button" role="tab" aria-controls="kinerja-rendah" aria-selected="false">
        <i class="fas fa-arrow-down me-2"></i>Perlu Perhatian
        <span class="badge badge-warning">{{ collect($data['pilar'] ?? [])->where('nilai', '<', 70)->count() }}</span>
      </button>
    </li>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content" id="myTabContent">
    <!-- Tab Semua Pilar -->
    <div class="tab-pane fade show active" id="semua" role="tabpanel" aria-labelledby="semua-tab">
      <div class="dashboard-grid">
        <div class="grid-span-6">
          <div class="card chart-card">
            <h3 class="chart-title"><i class="fas fa-chart-radar"></i> Perbandingan Antar Pilar</h3>
            <div class="chart-container medium">
              <canvas id="radarChart"></canvas>
            </div>
          </div>
        </div>

        <div class="grid-span-6">
          <div class="card chart-card">
            <h3 class="chart-title"><i class="fas fa-table"></i> Daftar Semua Pilar</h3>
            <div class="table-responsive">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Nama Pilar</th>
                    <th>Nilai (%)</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($data['pilar'] ?? [] as $index => $pilar)
                    <tr class="data-row">
                      <td>{{ $pilar['nama'] }}</td>
                      <td>
                        @if($pilar['nilai'] >= 80)
                          <strong class="text-success">{{ $pilar['nilai'] }}%</strong>
                          <span class="performance-indicator high">
                            <i class="fas fa-arrow-up"></i> {{ $pilar['nilai'] }}
                          </span>
                        @elseif($pilar['nilai'] >= 70)
                          <strong class="text-primary">{{ $pilar['nilai'] }}%</strong>
                          <span class="performance-indicator medium">
                            <i class="fas fa-minus"></i> {{ $pilar['nilai'] }}
                          </span>
                        @else
                          <strong class="text-warning">{{ $pilar['nilai'] }}%</strong>
                          <span class="performance-indicator low">
                            <i class="fas fa-arrow-down"></i> {{ $pilar['nilai'] }}
                          </span>
                        @endif
                      </td>
                      <td>
                        @if($pilar['nilai'] >= 80)
                          <span class="badge badge-success">
                            <i class="fas fa-check-circle mr-1"></i> Kinerja Tinggi
                          </span>
                        @elseif($pilar['nilai'] >= 70)
                          <span class="badge badge-primary">
                            <i class="fas fa-info-circle mr-1"></i> Kinerja Baik
                          </span>
                        @else
                          <span class="badge badge-warning">
                            <i class="fas fa-exclamation-circle mr-1"></i> Perlu Perhatian
                          </span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('dataKinerja.pilar', $index + 1) }}" class="btn btn-sm btn-primary">
                          <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center py-4">
                        <div class="empty-state">
                          <i class="fas fa-database text-muted mb-3" style="font-size: 2.5rem;"></i>
                          <p class="text-muted">Tidak ada data pilar untuk ditampilkan.</p>
                        </div>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab Kinerja Tinggi -->
    <div class="tab-pane fade" id="kinerja-tinggi" role="tabpanel" aria-labelledby="tinggi-tab">
      <div class="dashboard-grid">
        <div class="grid-span-12">
          <div class="card chart-card">
            <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Pilar dengan Kinerja Tinggi</h3>
            <div class="chart-container medium">
              <canvas id="highPerformanceChart"></canvas>
            </div>
            <div class="table-responsive mt-4">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Nama Pilar</th>
                    <th>Nilai (%)</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(collect($data['pilar'] ?? [])->where('nilai', '>=', 80) as $index => $pilar)
                  <tr class="data-row">
                    <td>{{ $pilar['nama'] }}</td>
                    <td>
                      <strong class="text-success">{{ $pilar['nilai'] }}%</strong>
                      <span class="performance-indicator high">
                        <i class="fas fa-arrow-up"></i> {{ $pilar['nilai'] }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-success">
                        <i class="fas fa-check-circle mr-1"></i> Kinerja Tinggi
                      </span>
                    </td>
                    <td>
                      @php
                        $pilarId = collect($data['pilar'] ?? [])->search(function($p) use ($pilar) {
                          return $p['nama'] == $pilar['nama'];
                        });
                        $pilarId = $pilarId !== false ? $pilarId + 1 : 1;
                      @endphp
                      <a href="{{ route('dataKinerja.pilar', $pilarId) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye mr-1"></i> Detail
                      </a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-4">
                      <div class="empty-state">
                        <i class="fas fa-chart-line text-muted mb-3" style="font-size: 2.5rem;"></i>
                        <p class="text-muted">Tidak ada pilar dengan kinerja tinggi saat ini.</p>
                      </div>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab Perlu Perhatian -->
    <div class="tab-pane fade" id="kinerja-rendah" role="tabpanel" aria-labelledby="rendah-tab">
      <div class="dashboard-grid">
        <div class="grid-span-12">
          <div class="card chart-card">
            <h3 class="chart-title"><i class="fas fa-exclamation-triangle"></i> Pilar yang Perlu Perhatian</h3>
            <div class="chart-container medium">
              <canvas id="lowPerformanceChart"></canvas>
            </div>
            <div class="table-responsive mt-4">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Nama Pilar</th>
                    <th>Nilai (%)</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(collect($data['pilar'] ?? [])->where('nilai', '<', 70) as $index => $pilar)
                  <tr class="data-row">
                    <td>{{ $pilar['nama'] }}</td>
                    <td>
                      <strong class="text-warning">{{ $pilar['nilai'] }}%</strong>
                      <span class="performance-indicator low">
                        <i class="fas fa-arrow-down"></i> {{ $pilar['nilai'] }}
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-warning">
                        <i class="fas fa-exclamation-circle mr-1"></i> Perlu Perhatian
                      </span>
                    </td>
                    <td>
                      @php
                        $pilarId = collect($data['pilar'] ?? [])->search(function($p) use ($pilar) {
                          return $p['nama'] == $pilar['nama'];
                        });
                        $pilarId = $pilarId !== false ? $pilarId + 1 : 1;
                      @endphp
                      <a href="{{ route('dataKinerja.pilar', $pilarId) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye mr-1"></i> Detail
                      </a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-4">
                      <div class="empty-state">
                        <i class="fas fa-check-circle text-muted mb-3" style="font-size: 2.5rem;"></i>
                        <p class="text-muted">Tidak ada pilar yang perlu perhatian saat ini.</p>
                      </div>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section: Kinerja Tertinggi dan Overview Tugas -->
  <div class="dashboard-grid">
    <div class="grid-span-8">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title"><i class="fas fa-trophy"></i> Kinerja Tertinggi</h5>
          <div>
            <button class="btn btn-sm btn-light" id="refreshTopPerformers">
              <i class="fas fa-sync-alt"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            @if(isset($poorPerformers) && count($poorPerformers) > 0)
              @foreach($poorPerformers as $performer)
                <div class="col-md-6">
                  <div class="top-performer-card">
                    <div class="top-performer-header">
                      <h6 class="top-performer-title">{{ $performer->indikator->nama }}</h6>
                      <span class="top-performer-value">{{ $performer->persentase }}%</span>
                    </div>
                    <div class="top-performer-info">
                      <span class="badge bg-info">{{ $performer->indikator->bidang->nama }}</span>
                      <span class="text-muted ml-2">Kode: {{ $performer->indikator->kode }}</span>
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="col-12">
                <div class="alert alert-info">
                  Tidak ada data kinerja tertinggi yang tersedia.
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="grid-span-4">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="card-title"><i class="fas fa-tasks"></i> Overview Tugas</h5>
        </div>
        <div class="card-body">
          <div class="task-overview">
            @if(isset($needVerification) && count($needVerification) > 0)
              @foreach($needVerification as $task)
                <div class="task-item">
                  <div class="task-icon pending">
                    <i class="fas fa-clock"></i>
                  </div>
                  <div class="task-content">
                    <h6 class="task-title">{{ $task->indikator->nama }}</h6>
                    <div class="task-meta">
                      <span><i class="fas fa-user"></i> {{ $task->user->name }}</span>
                      <span><i class="fas fa-calendar"></i> {{ $task->created_at->format('d M Y') }}</span>
                    </div>
                  </div>
                  <span class="task-status pending">Menunggu</span>
                </div>
              @endforeach
            @else
              <div class="alert alert-success">
                <i class="fas fa-check-circle mr-2"></i> Tidak ada tugas yang perlu ditindaklanjuti.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Helper function untuk mengambil variabel CSS
  function getCSSVariable(variable, fallback) {
    const computedStyle = getComputedStyle(document.documentElement);
    return computedStyle.getPropertyValue(variable).trim() || fallback;
  }

  // Chart configuration yang support dark/light mode
  function getChartConfig() {
    return {
      gridColor: getCSSVariable('--chart-grid-color', 'rgba(255, 255, 255, 0.1)'),
      textColor: getCSSVariable('--chart-text-color', '#f8fafc'),
      successColor: getCSSVariable('--chart-success-color', 'rgba(40, 167, 69, 0.7)'),
      successBorder: getCSSVariable('--chart-success-border', '#28a745'),
      warningColor: getCSSVariable('--chart-warning-color', 'rgba(255, 193, 7, 0.7)'),
      warningBorder: getCSSVariable('--chart-warning-border', '#ffc107'),
      primaryColor: getCSSVariable('--chart-primary-color', 'rgba(0, 156, 222, 0.3)'),
      primaryBorder: getCSSVariable('--chart-primary-border', '#0078b0'),
      background: getCSSVariable('--chart-background', 'rgba(255, 255, 255, 0.9)'),
      tooltipBg: getCSSVariable('--chart-tooltip-bg', 'rgba(255, 255, 255, 0.95)'),
      tooltipText: getCSSVariable('--chart-tooltip-text', '#333333'),
      tooltipBorder: getCSSVariable('--chart-tooltip-border', '#dee2e6'),
      legendText: getCSSVariable('--chart-legend-text', '#333333')
    };
  }

  // Objek untuk menyimpan instance chart
  const chartInstances = {
    gaugeChart: null,
    trendChart: null,
    radarChart: null,
    highPerformanceChart: null,
    lowPerformanceChart: null
  };

  // Fungsi untuk update semua chart ketika tema berubah
  function updateChartsForTheme() {
    console.log('Updating charts for theme change');

    // Dapatkan konfigurasi baru berdasarkan tema saat ini
    const chartConfig = getChartConfig();

    // Reinisialisasi semua chart dengan konfigurasi baru
    initGaugeChart(chartConfig);
    initTrendChart(chartConfig);

    // Reinisialisasi chart pada tab yang aktif
    const activeTab = document.querySelector('.tab-pane.active');
    if (activeTab) {
      const tabId = activeTab.id;

      if (tabId === 'semua') {
        initRadarChart(chartConfig);
      } else if (tabId === 'kinerja-tinggi') {
        initHighPerformanceChart(chartConfig);
      } else if (tabId === 'kinerja-rendah') {
        initLowPerformanceChart(chartConfig);
      }
    }

    // Update warna teks di gauge chart
    const gaugeText = document.getElementById('gauge-center-text');
    if (gaugeText) {
      const scoreElement = gaugeText.querySelector('h3');
      const labelElement = gaugeText.querySelector('p');

      if (scoreElement) {
        scoreElement.style.color = chartConfig.textColor;
      }

      if (labelElement) {
        labelElement.style.color = chartConfig.textColor;
        labelElement.style.opacity = '0.7';
      }
    }

    // Update warna teks pada tabel
    document.querySelectorAll('.data-table').forEach(table => {
      // Force reflow untuk memastikan transisi warna yang halus
      table.style.display = 'none';
      table.offsetHeight; // Trigger reflow
      table.style.display = '';
    });

    // Update badge colors
    document.querySelectorAll('.badge').forEach(badge => {
      // Force reflow untuk memastikan transisi warna yang halus
      badge.style.display = 'inline-flex';
      badge.offsetHeight; // Trigger reflow
      badge.style.display = 'inline-flex';
    });
  }

  // Inisialisasi chart
  document.addEventListener('DOMContentLoaded', function() {

    // Setup default Chart.js global options
    setupChartDefaults();

    // Tab handlers untuk Bootstrap 5
    const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');

    tabs.forEach(tab => {
      tab.addEventListener('shown.bs.tab', function(event) {
        console.log('Tab activated:', event.target.getAttribute('data-bs-target'));
        const tabId = event.target.getAttribute('data-bs-target').replace('#', '');
        const chartConfig = getChartConfig();

        // Render chart berdasarkan tab yang aktif
        if (tabId === 'kinerja-tinggi') {
          initHighPerformanceChart(chartConfig);
        }
        else if (tabId === 'kinerja-rendah') {
          initLowPerformanceChart(chartConfig);
        }
        else if (tabId === 'semua') {
          initRadarChart(chartConfig);
        }

        // Trigger resize event untuk memastikan chart ditampilkan dengan benar
        setTimeout(() => {
          window.dispatchEvent(new Event('resize'));
        }, 50);
      });
    });

    // Inisialisasi chart untuk tab yang aktif saat halaman dimuat
    initAllCharts();

    // Pre-render charts untuk tab lain agar siap ketika tab diaktifkan
    setTimeout(() => {
      const chartConfig = getChartConfig();
      initHighPerformanceChart(chartConfig);
      initLowPerformanceChart(chartConfig);
    }, 100);
  });

  // Setup default Chart.js global options
  function setupChartDefaults() {
    const chartConfig = getChartConfig();

    Chart.defaults.color = chartConfig.textColor;
    Chart.defaults.borderColor = chartConfig.gridColor;
    Chart.defaults.font.family = "'Poppins', 'Helvetica', 'Arial', sans-serif";

    // Default tooltip style
    Chart.defaults.plugins.tooltip.backgroundColor = chartConfig.tooltipBg;
    Chart.defaults.plugins.tooltip.titleColor = chartConfig.tooltipText;
    Chart.defaults.plugins.tooltip.bodyColor = chartConfig.tooltipText;
    Chart.defaults.plugins.tooltip.borderColor = chartConfig.tooltipBorder;
    Chart.defaults.plugins.tooltip.borderWidth = 1;
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
    Chart.defaults.plugins.tooltip.displayColors = true;
    Chart.defaults.plugins.tooltip.boxPadding = 4;

    // Default legend style
    Chart.defaults.plugins.legend.labels.color = chartConfig.legendText;
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.pointStyleWidth = 10;

    // Animation defaults
    Chart.defaults.animation.duration = 1000;
    Chart.defaults.animation.easing = 'easeOutQuart';
  }

  // Fungsi untuk menginisialisasi semua chart
  function initAllCharts() {
    const chartConfig = getChartConfig();

    // Gauge Chart
    initGaugeChart(chartConfig);

    // Trend Chart
    initTrendChart(chartConfig);

    // Radar Chart untuk perbandingan antar pilar
    initRadarChart(chartConfig);
  }

  // Gauge Chart
  function initGaugeChart(chartConfig = getChartConfig()) {
    const gaugeCtx = document.getElementById('gaugeChart');
    if (!gaugeCtx) return;

    const ctx = gaugeCtx.getContext('2d');
    const nkoValue = {{ $data['nko'] }};

    // Determine color based on value
    let gaugeColor = '#F44336'; // Red for low values
    if (nkoValue >= 70) {
      gaugeColor = chartConfig.successBorder; // Green for high values
    } else if (nkoValue >= 50) {
      gaugeColor = chartConfig.warningBorder; // Yellow for medium values
    }

    // Destroy existing chart if exists
    if (chartInstances.gaugeChart) {
      chartInstances.gaugeChart.destroy();
    }

    chartInstances.gaugeChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [nkoValue, 100 - nkoValue],
          backgroundColor: [
            gaugeColor,
            'rgba(200, 200, 200, 0.1)'
          ],
          borderWidth: 0,
          circumference: 180,
          rotation: 270,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            enabled: false
          }
        }
      }
    });

    // Update center text with current theme colors
    const gaugeText = document.getElementById('gauge-center-text');
    if (gaugeText) {
      const scoreElement = gaugeText.querySelector('h3');
      const labelElement = gaugeText.querySelector('p');

      if (scoreElement) {
        scoreElement.style.color = chartConfig.textColor;
        scoreElement.style.fontSize = '2rem';
        scoreElement.style.fontWeight = '700';
      }

      if (labelElement) {
        labelElement.style.color = chartConfig.textColor;
        labelElement.style.opacity = '0.7';
        labelElement.style.fontSize = '0.85rem';
      }
    }
  }

  // Trend Chart
  function initTrendChart(chartConfig = getChartConfig()) {
    const trendCtx = document.getElementById('trendChart');
    if (!trendCtx) return;

    const ctx = trendCtx.getContext('2d');
    // Simulasikan data tren (ini dapat diganti dengan data aktual)
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const currentMonth = {{ $bulan }};
    const trendData = [];

    // Generate trend data up to current month
    for (let i = 1; i <= 12; i++) {
      if (i <= currentMonth) {
        // Generate random values within ±10% of final NKO value for past months
        const min = Math.max({{ $data['nko'] }} - 10, 0);
        const max = Math.min({{ $data['nko'] }} + 5, 100);
        const randomValue = (i < currentMonth)
          ? (Math.random() * (max - min) + min).toFixed(1)
          : {{ $data['nko'] }};
        trendData.push(randomValue);
      } else {
        trendData.push(null); // Future months have null values
      }
    }

    // Destroy existing chart if exists
    if (chartInstances.trendChart) {
      chartInstances.trendChart.destroy();
    }

    chartInstances.trendChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: months,
        datasets: [{
          label: 'Nilai Kinerja',
          data: trendData,
          backgroundColor: chartConfig.primaryColor,
          borderColor: chartConfig.primaryBorder,
          borderWidth: 2,
          pointBackgroundColor: chartConfig.primaryBorder,
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointRadius: 5,
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
            backgroundColor: chartConfig.tooltipBg,
            titleColor: chartConfig.tooltipText,
            bodyColor: chartConfig.tooltipText,
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 13
            },
            padding: 12,
            displayColors: false,
            borderColor: chartConfig.tooltipBorder,
            borderWidth: 1
          }
        },
        scales: {
          x: {
            grid: {
              color: chartConfig.gridColor
            },
            ticks: {
              color: chartConfig.textColor
            }
          },
          y: {
            beginAtZero: true,
            max: 100,
            grid: {
              color: chartConfig.gridColor
            },
            ticks: {
              color: chartConfig.textColor,
              callback: function(value) {
                return value + '%';
              }
            }
          }
        }
      }
    });
  }

  // Radar Chart untuk perbandingan antar pilar
  function initRadarChart(chartConfig = getChartConfig()) {
    const radarCtx = document.getElementById('radarChart');
    if (!radarCtx) return;

    const pilars = @json($data['pilar']);

    if (pilars.length > 0) {
      const labels = pilars.map(pilar => pilar.nama);
      const values = pilars.map(pilar => pilar.nilai);

      // Destroy existing chart if exists
      if (chartInstances.radarChart) {
        chartInstances.radarChart.destroy();
      }

      // Data untuk radar chart
      chartInstances.radarChart = new Chart(radarCtx.getContext('2d'), {
        type: 'radar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Nilai Kinerja (%)',
            data: values,
            backgroundColor: chartConfig.primaryColor,
            borderColor: chartConfig.primaryBorder,
            borderWidth: 2,
            pointBackgroundColor: chartConfig.primaryBorder,
            pointBorderColor: '#fff',
            pointRadius: 5,
            pointHoverRadius: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              beginAtZero: true,
              max: 100,
              ticks: {
                stepSize: 20,
                backdropColor: 'transparent',
                color: chartConfig.textColor
              },
              grid: {
                color: chartConfig.gridColor
              },
              angleLines: {
                color: chartConfig.gridColor
              },
              pointLabels: {
                color: chartConfig.textColor,
                font: {
                  size: 12
                }
              }
            }
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              backgroundColor: chartConfig.tooltipBg,
              titleColor: chartConfig.tooltipText,
              bodyColor: chartConfig.tooltipText,
              titleFont: {
                size: 14,
                weight: 'bold'
              },
              bodyFont: {
                size: 13
              },
              padding: 12,
              borderColor: chartConfig.tooltipBorder,
              borderWidth: 1
            }
          },
          elements: {
            line: {
              tension: 0.1
            }
          }
        }
      });
    } else {
      // Jika tidak ada data, tampilkan pesan kosong
      const noDataDiv = document.createElement('div');
      noDataDiv.className = 'empty-state';
      noDataDiv.innerHTML = `
        <i class="fas fa-chart-pie text-muted mb-3" style="font-size: 2.5rem;"></i>
        <p class="text-muted">Tidak ada data pilar untuk ditampilkan.</p>
      `;
      radarCtx.parentNode.replaceChild(noDataDiv, radarCtx);
    }
  }

  // Kinerja Tinggi Chart - Bar Chart
  function initHighPerformanceChart(chartConfig = getChartConfig()) {
    const highPerformanceCtx = document.getElementById('highPerformanceChart');
    if (!highPerformanceCtx) return;

    const highPilar = @json(collect($data['pilar'] ?? [])->where('nilai', '>=', 80)->values()->all());

    if (highPilar.length > 0) {
      const labels = highPilar.map(pilar => pilar.nama);
      const values = highPilar.map(pilar => pilar.nilai);
      const targetValues = highPilar.map(() => 80); // Target 80%

      // Destroy existing chart if exists
      if (chartInstances.highPerformanceChart) {
        chartInstances.highPerformanceChart.destroy();
      }

      chartInstances.highPerformanceChart = new Chart(highPerformanceCtx.getContext('2d'), {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Nilai Kinerja (%)',
              data: values,
              backgroundColor: chartConfig.successColor,
              borderColor: chartConfig.successBorder,
              borderWidth: 1,
              borderRadius: 5,
              barPercentage: 0.6,
              categoryPercentage: 0.7
            },
            {
              label: 'Target Minimum Kinerja Tinggi',
              data: targetValues,
              type: 'line',
              backgroundColor: 'transparent',
              borderColor: 'rgba(0, 0, 0, 0.2)',
              borderWidth: 2,
              borderDash: [5, 5],
              pointStyle: false
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              max: 100,
              grid: {
                color: chartConfig.gridColor
              },
              ticks: {
                color: chartConfig.textColor,
                callback: function(value) {
                  return value + '%';
                }
              }
            },
            x: {
              grid: {
                display: false
              },
              ticks: {
                color: chartConfig.textColor
              }
            }
          },
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: chartConfig.legendText,
                usePointStyle: true,
                padding: 20,
                font: {
                  size: 12
                }
              }
            },
            tooltip: {
              backgroundColor: chartConfig.tooltipBg,
              titleColor: chartConfig.tooltipText,
              bodyColor: chartConfig.tooltipText,
              padding: 12,
              mode: 'index',
              intersect: false,
              borderColor: chartConfig.tooltipBorder,
              borderWidth: 1
            }
          }
        }
      });
    } else {
      // Jika tidak ada data, tampilkan pesan kosong
      const chartContainer = highPerformanceCtx.parentNode;
      const existingEmptyState = chartContainer.querySelector('.empty-state');

      if (!existingEmptyState) {
        const noDataDiv = document.createElement('div');
        noDataDiv.className = 'empty-state';
        noDataDiv.innerHTML = `
          <i class="fas fa-chart-bar text-muted mb-3" style="font-size: 2.5rem;"></i>
          <p class="text-muted">Tidak ada data kinerja tinggi untuk ditampilkan.</p>
        `;
        chartContainer.replaceChild(noDataDiv, highPerformanceCtx);
      }
    }
  }

  // Perlu Perhatian Chart - Horizontal Bar Chart
  function initLowPerformanceChart(chartConfig = getChartConfig()) {
    const lowPerformanceCtx = document.getElementById('lowPerformanceChart');
    if (!lowPerformanceCtx) return;

    const lowPilar = @json(collect($data['pilar'] ?? [])->where('nilai', '<', 70)->values()->all());

    if (lowPilar.length > 0) {
      const labels = lowPilar.map(pilar => pilar.nama);
      const values = lowPilar.map(pilar => pilar.nilai);
      const targetValues = lowPilar.map(() => 70); // Target 70%

      // Destroy existing chart if exists
      if (chartInstances.lowPerformanceChart) {
        chartInstances.lowPerformanceChart.destroy();
      }

      chartInstances.lowPerformanceChart = new Chart(lowPerformanceCtx.getContext('2d'), {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Nilai Kinerja (%)',
              data: values,
              backgroundColor: chartConfig.warningColor,
              borderColor: chartConfig.warningBorder,
              borderWidth: 1,
              borderRadius: 5,
              barPercentage: 0.6,
              categoryPercentage: 0.7
            },
            {
              label: 'Target Minimum',
              data: targetValues,
              type: 'line',
              backgroundColor: 'transparent',
              borderColor: 'rgba(0, 0, 0, 0.2)',
              borderWidth: 2,
              borderDash: [5, 5],
              pointStyle: false
            }
          ]
        },
        options: {
          indexAxis: 'y', // Horizontal bar
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true,
              max: 100,
              grid: {
                color: chartConfig.gridColor
              },
              ticks: {
                color: chartConfig.textColor,
                callback: function(value) {
                  return value + '%';
                }
              }
            },
            y: {
              grid: {
                display: false
              },
              ticks: {
                color: chartConfig.textColor
              }
            }
          },
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: chartConfig.legendText,
                usePointStyle: true,
                padding: 20,
                font: {
                  size: 12
                }
              }
            },
            tooltip: {
              backgroundColor: chartConfig.tooltipBg,
              titleColor: chartConfig.tooltipText,
              bodyColor: chartConfig.tooltipText,
              padding: 12,
              mode: 'index',
              intersect: false,
              borderColor: chartConfig.tooltipBorder,
              borderWidth: 1
            }
          }
        }
      });
    } else {
      // Jika tidak ada data, tampilkan pesan kosong
      const chartContainer = lowPerformanceCtx.parentNode;
      const existingEmptyState = chartContainer.querySelector('.empty-state');

      if (!existingEmptyState) {
        const noDataDiv = document.createElement('div');
        noDataDiv.className = 'empty-state';
        noDataDiv.innerHTML = `
          <i class="fas fa-check-circle text-muted mb-3" style="font-size: 2.5rem;"></i>
          <p class="text-muted">Tidak ada pilar yang perlu perhatian saat ini.</p>
        `;
        chartContainer.replaceChild(noDataDiv, lowPerformanceCtx);
      }
    }
  }
</script>
@endsection
