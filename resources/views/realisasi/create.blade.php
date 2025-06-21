@extends('layouts.app')

@section('title', 'Input Realisasi KPI')
@section('page_title', 'INPUT REALISASI KPI')

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

    /* Responsive */
    @media (max-width: 768px) {
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
</style>
@endsection


@section('content')
<div class="dashboard-content">
    <!-- Modern Page Header -->
    <div class="page-header">
        <div>
            <h2><i class="fas fa-plus-circle me-2"></i>Input Realisasi KPI</h2>
            <div class="page-header-subtitle">
                Masukkan data realisasi harian kinerja indikator
            </div>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('realisasi.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    @include('components.alert')

    <div class="form-card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">Form Input Realisasi Harian</h6>
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
                            <div class="info-label">Target:</div>
                            <div class="info-value">{{ number_format($indikator->target, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">Bidang:</div>
                            <div class="info-value">{{ $indikator->bidang->nama }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tipe:</div>
                            <div class="info-value">Harian</div>
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

            <!-- FORM -->
            <form id="formRealisasi" method="POST" action="{{ route('realisasi.store', $indikator->id) }}">
                @csrf

                <input type="hidden" name="indikator_id" value="{{ $indikator->id }}">

                <!-- Tanggal -->
                <div class="form-group mb-4">
                    <label for="tanggal">Tanggal Realisasi <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                           id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-calendar-alt me-1"></i> Pilih tanggal realisasi KPI.
                    </small>
                </div>

                <!-- Nilai -->
                <div class="form-group mb-4">
                    <label for="nilai">Nilai Realisasi <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('nilai') is-invalid @enderror"
                           id="nilai" name="nilai" value="{{ old('nilai') }}" required>
                    @error('nilai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i> Masukkan nilai realisasi pencapaian.
                    </small>
                </div>

                <!-- Visual Progress (opsional, bisa aktifkan via JS jika ingin) -->
                <div id="targetVisualContainer" class="mb-4" style="display: none;">
                    <div class="target-visual">
                        <div class="target-progress" id="targetProgress" style="width: 0%"></div>
                        <div class="target-value" id="targetValue">0%</div>
                    </div>
                    <div class="text-center text-muted small">
                        <i class="fas fa-info-circle me-1"></i> Persentase pencapaian terhadap target.
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group mb-4">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                              id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        <i class="fas fa-edit me-1"></i> Tambahkan keterangan, kendala, atau catatan tambahan.
                    </small>
                </div>

                <!-- Tombol -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-action" id="btnSubmit">
                        <i class="fas fa-save"></i> Simpan Realisasi
                    </button>
                    <a href="{{ route('realisasi.index') }}" class="btn btn-secondary btn-action">
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
document.addEventListener('DOMContentLoaded', function() {
    // Menangani submit form untuk mencegah multiple submission
    const form = document.getElementById('formRealisasi');
    const submitBtn = document.getElementById('btnSubmit');
    const nilaiInput = document.getElementById('nilai');
    const targetProgress = document.getElementById('targetProgress');
    const targetValue = document.getElementById('targetValue');
    const targetVisual = document.getElementById('targetVisualContainer');
    const target = {{ $indikator->target }};

    // Update progress bar saat nilai berubah
    nilaiInput.addEventListener('input', function() {
        const nilai = parseFloat(this.value) || 0;
        const percentage = Math.min((nilai / target) * 100, 100);

        // Update visual jika input valid
        if (nilai >= 0) {
            targetVisual.style.display = 'block';
            targetProgress.style.width = percentage + '%';
            targetValue.textContent = percentage.toFixed(1) + '%';

            // Warna progress bar berdasarkan persentase
            if (percentage >= 90) {
                targetProgress.style.background = 'linear-gradient(90deg, #28a745, #75c94e)';
            } else if (percentage >= 70) {
                targetProgress.style.background = 'linear-gradient(90deg, #ffc107, #ffda65)';
            } else {
                targetProgress.style.background = 'linear-gradient(90deg, #dc3545, #ef7783)';
            }
        }
    });

    // Trigger event untuk render progress bar jika ada nilai awal
    if (nilaiInput.value) {
        nilaiInput.dispatchEvent(new Event('input'));
    }

    form.addEventListener('submit', function(e) {
        // Disable the submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

        // Continue with form submission
        return true;
    });
});
</script>
@endsection
