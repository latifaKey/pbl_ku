@extends('layouts.app')

@section('title', 'Dashboard Kinerja PLN')
@section('page_title', 'DASHBOARD KINERJA')

@section('styles')
  <style>
  .dashboard-content {
    max-width: 1800px;
    margin: 0 auto;
  }

  /* Peningkatan style untuk container meter */
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

  /* Peningkatan style untuk pilar container */
  .pillar-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin: 30px 0;
    gap: 15px;
  }

  .pillar-item {
    flex: 1;
    min-width: 150px;
    text-align: center;
    background: var(--pln-accent-bg);
    border-radius: 16px;
    padding: 20px 15px;
    transition: all 0.3s ease;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
  }

  .pillar-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .pillar-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px var(--pln-shadow);
  }

  .pillar-item:hover::before {
    opacity: 1;
  }

  .pillar-title {
    font-size: 15px;
    margin-bottom: 8px;
    color: var(--pln-text);
    text-align: center;
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  .pillar-value {
    display: block;
    margin-top: 8px;
    font-size: 14px;
    color: var(--pln-light-blue);
    text-align: center;
    font-weight: 700;
    letter-spacing: 0.5px;
  }

  .circle-progress {
    width: 130px;
    height: 130px;
    margin: 0 auto;
    position: relative;
    transition: all 0.3s ease;
  }

  .pillar-item:hover .circle-progress {
    transform: scale(1.05);
  }

  .circle-progress-value {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 24px;
    font-weight: 700;
    color: var(--pln-text);
    transition: all 0.3s ease;
  }

  /* Peningkatan style untuk grid detail */
  .details-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-top: 40px;
    max-height: 800px;
    overflow-y: auto;
  }

  .detail-section {
    background: var(--pln-accent-bg);
    border-radius: 16px;
    padding: 25px;
    transition: all 0.3s ease;
    border: 1px solid var(--pln-border);
    box-shadow: 0 8px 20px var(--pln-shadow);
    position: relative;
    overflow: hidden;
    max-height: 400px;
    overflow-y: auto;
  }

  .detail-section::-webkit-scrollbar {
    width: 8px;
  }

  .detail-section::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }

  .detail-section::-webkit-scrollbar-thumb {
    background: var(--pln-light-blue);
    border-radius: 10px;
  }

  .details-grid::-webkit-scrollbar {
    width: 8px;
  }

  .details-grid::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }

  .details-grid::-webkit-scrollbar-thumb {
    background: var(--pln-light-blue);
    border-radius: 10px;
  }

  .detail-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
  }

  .detail-title {
    font-size: 18px;
    color: var(--pln-light-blue);
    margin-bottom: 20px;
    border-bottom: 1px solid var(--pln-border);
    padding-bottom: 15px;
    font-weight: 600;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
  }

  .detail-title i {
    margin-right: 10px;
    font-size: 16px;
    opacity: 0.8;
  }

  .progress-item {
    margin-bottom: 20px;
    transition: all 0.3s ease;
    padding: 10px;
    border-radius: 10px;
  }

  .progress-item:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(5px);
  }

  .progress-label {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 13px;
  }

  .progress-name {
    color: var(--pln-text);
    opacity: 0.9;
    font-weight: 500;
  }

  .progress-value {
    color: var(--pln-light-blue);
    font-weight: 600;
    display: flex;
    align-items: center;
  }

  .progress-value-of {
    opacity: 0.7;
    font-size: 12px;
    margin-left: 5px;
    color: var(--pln-text-secondary);
  }

  .progress {
    height: 10px;
    background-color: rgba(255,255,255,0.1);
    margin-bottom: 5px;
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

  /* Peningkatan responsif */
  @media (max-width: 1200px) {
    .details-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .pillar-container {
      justify-content: center;
    }
  }

  @media (max-width: 992px) {
    .pillar-item {
      min-width: 130px;
      padding: 15px 10px;
    }

    .circle-progress {
      width: 110px;
      height: 110px;
    }

    .circle-progress-value {
      font-size: 20px;
    }
  }

  @media (max-width: 768px) {
    .details-grid {
      grid-template-columns: 1fr;
    }

    .row.align-items-center {
      flex-direction: column;
    }

    .pillar-container {
      margin-top: 30px;
    }

    .meter-container {
      width: 250px;
      height: 180px;
    }
  }

  /* Dashboard stat card */
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

  @media (max-width: 992px) {
    .dashboard-col {
      min-width: 200px;
    }
  }

  @media (max-width: 768px) {
    .dashboard-col {
      flex: 0 0 100%;
    }
    }
  </style>
@endsection

@section('content')
<div class="dashboard-content">
  <!-- Stat Cards -->
  <div class="dashboard-row">
    <div class="dashboard-col">
      <div class="stat-card">
        <div class="stat-header">
          <h3 class="stat-title">NKO Score</h3>
          <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
      </div>
        </div>
        <div class="stat-value">{{ $data['nko'] }}</div>
        <p class="stat-description">Nilai Kinerja Organisasi</p>
      </div>
    </div>
    <div class="dashboard-col">
      <div class="stat-card">
        <div class="stat-header">
          <h3 class="stat-title">Target</h3>
          <div class="stat-icon">
            <i class="fas fa-bullseye"></i>
          </div>
        </div>
        <div class="stat-value">100</div>
        <p class="stat-description">Target Pencapaian</p>
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
        <div class="stat-value">{{ count($data['pilar']) }}</div>
        <p class="stat-description">Pilar Penilaian</p>
      </div>
    </div>
    <div class="dashboard-col">
      <div class="stat-card">
        <div class="stat-header">
          <h3 class="stat-title">Progress</h3>
          <div class="stat-icon">
            <i class="fas fa-spinner"></i>
          </div>
        </div>
        <div class="stat-value">{{ $data['nko'] }}%</div>
        <p class="stat-description">Persentase Pencapaian</p>
      </div>
    </div>
  </div>

  <!-- NKO Gauge Meter -->
  <div class="row align-items-center">
    <div class="col-md-3">
      <div class="meter-container">
        <canvas id="gaugeChart"></canvas>
        <div class="nko-label">NKO</div>
        <div class="nko-value">{{ $data['nko'] }}</div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="pillar-container">
        @foreach($data['pilar'] as $index => $pilar)
        <div class="pillar-item">
          <div class="pillar-title">{{ $pilar['nama'] }}</div>
          <div class="pillar-value">{{ $pilar['nilai'] }}%</div>
          <div class="circle-progress">
            <canvas id="pilar{{ $index+1 }}Chart"></canvas>
            <div class="circle-progress-value">{{ $pilar['nilai'] }}%</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Detail Indicators -->
  <div class="details-grid">
    @foreach($data['pilar'] as $index => $pilar)
    <div class="detail-section">
      <h3 class="detail-title">
        <i class="fas fa-chart-pie"></i>
        {{ $pilar['nama'] }}
      </h3>

      @foreach($pilar['indikator'] as $indikator)
      <div class="progress-item">
        <div class="progress-label">
          <span class="progress-name">{{ $indikator['nama'] }}</span>
          <span class="progress-value">{{ $indikator['nilai'] }}<span class="progress-value-of"> dari target 100</span></span>
        </div>
        @php
          $progressClass = 'progress-red';
          if ($indikator['nilai'] >= 70) {
            $progressClass = 'progress-green';
          } elseif ($indikator['nilai'] >= 50) {
            $progressClass = 'progress-yellow';
          }
        @endphp
        <div class="progress">
          <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $indikator['nilai'] }}%"></div>
        </div>
      </div>
      @endforeach
    </div>
    @endforeach
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk membuat gauge chart
    function createGaugeChart() {
      const ctx = document.getElementById('gaugeChart').getContext('2d');

      // Nilai NKO dari data
      const nkoValue = {{ $data['nko'] }};

      // Tentukan warna berdasarkan nilai
      let gaugeColor = '#F44336'; // Red for low values
      if (nkoValue >= 70) {
        gaugeColor = '#4CAF50'; // Green for high values
      } else if (nkoValue >= 50) {
        gaugeColor = '#FFC107'; // Yellow for medium values
      }

      // Buat chart
      new Chart(ctx, {
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
    }

    // Fungsi untuk membuat circle chart untuk setiap pilar
    function createPilarCharts() {
      @foreach($data['pilar'] as $index => $pilar)
        const pilar{{ $index+1 }}Ctx = document.getElementById('pilar{{ $index+1 }}Chart').getContext('2d');
        const pilar{{ $index+1 }}Value = {{ $pilar['nilai'] }};

        // Tentukan warna berdasarkan nilai
        let pilar{{ $index+1 }}Color = '#F44336'; // Red for low values
        if (pilar{{ $index+1 }}Value >= 70) {
          pilar{{ $index+1 }}Color = '#4CAF50'; // Green for high values
        } else if (pilar{{ $index+1 }}Value >= 50) {
          pilar{{ $index+1 }}Color = '#FFC107'; // Yellow for medium values
        }

        new Chart(pilar{{ $index+1 }}Ctx, {
          type: 'doughnut',
          data: {
            datasets: [{
              data: [pilar{{ $index+1 }}Value, 100 - pilar{{ $index+1 }}Value],
              backgroundColor: [
                pilar{{ $index+1 }}Color,
                'rgba(200, 200, 200, 0.1)'
              ],
              borderWidth: 0
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                enabled: false
              }
            },
            animation: {
              animateRotate: true,
              animateScale: true
            }
          }
        });
      @endforeach
    }

    // Buat semua chart
    createGaugeChart();
    createPilarCharts();

    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar');
    setTimeout(() => {
      progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
          bar.style.width = width;
        }, 100);
      });
    }, 300);
  });
</script>
@endsection
