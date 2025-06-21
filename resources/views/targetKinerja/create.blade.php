@extends('layouts.app')

@section('title', 'Tambah Target Kinerja')
@section('page_title', 'TAMBAH TARGET KINERJA')

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

    /* Card Styling - Support Dark/Light Mode */
    .form-card {
        border-radius: 16px;
        box-shadow: 0 8px 20px var(--pln-shadow);
        background-color: var(--pln-surface);
        margin-bottom: 25px;
        overflow: hidden;
        color: var(--pln-text);
    }

    .form-card .card-header {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        padding: 15px 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: none;
    }

    .form-card .card-body {
        padding: 20px;
    }

    /* Info Box - Support Dark/Light Mode */
    .info-box {
        background-color: var(--pln-accent-bg);
        border-left: 4px solid var(--pln-light-blue);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .info-box h6 {
        color: var(--pln-blue);
        margin-bottom: 15px;
        font-weight: 600;
    }

    .info-row {
        display: flex;
        margin-bottom: 10px;
    }

    .info-label {
        font-weight: 600;
        min-width: 120px;
        color: var(--pln-text-secondary);
    }

    .info-value {
        flex: 1;
        color: var(--pln-text);
    }

    /* Form Styling - Support Dark/Light Mode */
    .form-group label {
        font-weight: 600;
        color: var(--pln-text);
        margin-bottom: 10px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid var(--pln-border);
        padding: 12px 15px;
        font-size: 0.875rem;
        background-color: var(--pln-surface);
        color: var(--pln-text);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: var(--pln-light-blue);
        box-shadow: 0 0 0 0.25rem rgba(0, 156, 222, 0.25);
        background-color: var(--pln-surface);
        color: var(--pln-text);
    }

    /* Monthly Target Grid */
    .monthly-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .monthly-input {
        position: relative;
    }

    .monthly-input label {
        display: block;
        font-weight: 500;
        font-size: 0.8rem;
        margin-bottom: 5px;
        color: var(--pln-text-secondary);
    }

    /* Action Buttons */
    .form-actions {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .btn-action {
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-action i {
        margin-right: 8px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px var(--pln-shadow);
    }

    /* Target Graphic - Support Dark/Light Mode */
    .target-visual {
        height: 50px;
        background: var(--pln-accent-bg);
        border-radius: 8px;
        position: relative;
        margin-bottom: 25px;
        border: 1px solid var(--pln-border);
        overflow: hidden;
    }

    .target-progress {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
        transition: width 0.5s ease;
    }

    .target-value {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: bold;
        color: var(--pln-text);
        z-index: 2;
    }

    /* Alert Styles - Support Dark/Light Mode */
    .alert-custom {
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-left: 4px solid;
        display: flex;
        align-items: flex-start;
    }

    .alert-custom i {
        margin-right: 10px;
        font-size: 1.1rem;
        margin-top: 2px;
    }

    .alert-custom.alert-warning {
        background-color: rgba(255, 193, 7, 0.15);
        border-color: #ffc107;
        color: var(--pln-text);
    }

    .alert-custom.alert-info {
        background-color: rgba(23, 162, 184, 0.15);
        border-color: #17a2b8;
        color: var(--pln-text);
    }

    /* Text-muted - Support Dark/Light Mode */
    .text-muted {
        color: var(--pln-text-secondary) !important;
    }

    /* Form control help text */
    .form-text {
        margin-top: 5px;
        font-size: 0.8rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .monthly-grid {
            grid-template-columns: repeat(2, 1fr);
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

    @media (max-width: 480px) {
        .monthly-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <!-- Modern Page Header -->
    <div class="page-header">
        <div>
            <h2><i class="fas fa-plus-circle me-2"></i>Tambah Target Kinerja</h2>
            <div class="page-header-subtitle">
                Tentukan target tahunan dan bulanan untuk indikator kinerja
            </div>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('targetKinerja.index', ['tahun_penilaian_id' => $tahunPenilaian->id]) }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @include('components.alert')

    <div class="form-card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">Form Target Kinerja Baru</h6>
        </div>
        <div class="card-body">
            <div class="info-box mb-4">
                <h6><i class="fas fa-info-circle me-2"></i>Informasi Indikator</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Kode:</div>
                            <div class="info-value">{{ $indikator->kode }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Nama:</div>
                            <div class="info-value">{{ $indikator->nama }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Bobot:</div>
                            <div class="info-value">{{ $indikator->bobot }}%</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Pilar:</div>
                            <div class="info-value">{{ $indikator->pilar->nama }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Bidang:</div>
                            <div class="info-value">{{ $indikator->bidang->nama }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tahun Penilaian:</div>
                            <div class="info-value">{{ $tahunPenilaian->tahun }}</div>
                        </div>
                    </div>
                </div>
                @if($indikator->deskripsi)
                    <div class="info-row mt-2">
                        <div class="info-label">Deskripsi:</div>
                        <div class="info-value">{{ $indikator->deskripsi }}</div>
                    </div>
                @endif
            </div>

            <form action="{{ route('targetKinerja.store') }}" method="POST">
                @csrf
                <input type="hidden" name="indikator_id" value="{{ $indikator->id }}">
                <input type="hidden" name="tahun_penilaian_id" value="{{ $tahunPenilaian->id }}">

                <div class="form-group">
                    <label for="target_tahunan">Target Tahunan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('target_tahunan') is-invalid @enderror"
                           id="target_tahunan" name="target_tahunan" step="0.01"
                           value="{{ old('target_tahunan', $indikator->target) }}" required>
                    @error('target_tahunan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i> Masukkan target tahunan untuk indikator ini.
                    </small>
                </div>

                <div class="target-visual">
                    <div class="target-progress" id="targetProgress" style="width: 0%"></div>
                    <div class="target-value" id="targetValue">0.00</div>
                </div>

                <div class="form-group">
                    <label>Target Bulanan</label>
                    <div class="alert-custom alert-info">
                        <i class="fas fa-info-circle"></i>
                        <div>Jika target bulanan tidak diisi, maka target tahunan akan dibagi rata ke 12 bulan.</div>
                    </div>

                    <div class="monthly-grid">
                        @for($i = 1; $i <= 12; $i++)
                            <div class="monthly-input">
                                <label>{{ \Carbon\Carbon::create(null, $i, 1)->locale('id')->monthName }}</label>
                                <div class="input-group">
                                    <input type="number" class="form-control monthly-target"
                                           name="target_bulanan[{{ $i-1 }}]"
                                           id="bulan_{{ $i-1 }}"
                                           step="0.01"
                                           value="{{ old('target_bulanan.'.$i-1, round($indikator->target/12, 2)) }}">
                                </div>
                            </div>
                        @endfor
                    </div>

                    @error('target_bulanan')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @error('target_bulanan.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-edit me-1"></i> Tambahkan keterangan jika diperlukan.
                    </small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-action">
                        <i class="fas fa-save"></i> Simpan Target
                    </button>
                    <a href="{{ route('targetKinerja.index', ['tahun_penilaian_id' => $tahunPenilaian->id]) }}" class="btn btn-secondary btn-action">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fungsi untuk memperbarui visualisasi target
    function updateTargetVisual() {
        const targetTahunan = parseFloat(document.getElementById('target_tahunan').value) || 0;
        const targetProgress = document.getElementById('targetProgress');
        const targetValue = document.getElementById('targetValue');

        // Maksimum untuk visualisasi (100%)
        const maxVisualization = targetTahunan * 1.2;

        // Update progress bar dan nilai
        targetProgress.style.width = (targetTahunan / maxVisualization * 100) + '%';
        targetValue.textContent = targetTahunan.toFixed(2);
    }

    // Inisialisasi visualisasi target
    updateTargetVisual();

    // Jika target tahunan berubah, update semua target bulanan dan visualisasi
    document.getElementById('target_tahunan').addEventListener('input', function() {
        const targetTahunan = parseFloat(this.value) || 0;
        const targetBulanan = targetTahunan / 12;

        // Update semua input target bulanan
        const bulananInputs = document.querySelectorAll('.monthly-target');
        bulananInputs.forEach(input => {
            input.value = targetBulanan.toFixed(2);
        });

        // Update visualisasi
        updateTargetVisual();
    });

    // Event listener untuk input bulanan
    document.querySelectorAll('.monthly-target').forEach(function(input) {
        input.addEventListener('input', function() {
            // Validasi nilai tidak negatif
            if (parseFloat(this.value) < 0) {
                this.value = 0;
            }
        });
    });
</script>
@endsection
