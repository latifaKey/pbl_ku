@extends('layouts.app')

@section('title', 'Detail Verifikasi KPI')
@section('page_title', 'DETAIL VERIFIKASI KPI')

@section('styles')
<style>
    /* Gaya dasar untuk container */
    .container {
        padding: 30px;
        margin: 20px auto;
        background: var(--pln-accent-bg);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1),
                    0 5px 15px rgba(0, 123, 255, 0.1),
                    inset 0 -2px 2px rgba(255, 255, 255, 0.08);
        border: 1px solid var(--pln-border);
        transition: all 0.4s ease;
        overflow: hidden;
        position: relative;
    }

    /* Glassmorphism effect dengan highlight gradient */
    .container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue), var(--pln-blue));
        background-size: 200% 100%;
        animation: gradientShift 8s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Efek ripple untuk tombol */
    .ripple {
        position: absolute;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Gaya untuk judul */
    .detail-title {
        margin-bottom: 20px;
        color: var(--pln-text);
        font-weight: 700;
        font-size: 24px;
        position: relative;
        padding-left: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 80%;
        background: linear-gradient(to bottom, var(--pln-blue), var(--pln-light-blue));
        border-radius: 4px;
    }

    /* Tombol kembali */
    .btn-kembali {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.1), rgba(108, 117, 125, 0.2));
        color: var(--pln-text-secondary);
        border: 1px solid rgba(108, 117, 125, 0.3);
        padding: 8px 15px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .btn-kembali i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .btn-kembali:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(108, 117, 125, 0.2);
    }

    /* Panel info */
    .info-panel {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        border: 1px solid var(--pln-border);
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .info-panel:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .info-panel-header {
        padding: 15px 20px;
        font-size: 16px;
        font-weight: 700;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        display: flex;
        align-items: center;
    }

    .info-panel-header i {
        margin-right: 10px;
    }

    .info-panel-header.primary-header {
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
    }

    .info-panel-header.info-header {
        background: linear-gradient(90deg, #17a2b8, #20c9d6);
        color: white;
    }

    .info-panel-header.secondary-header {
        background: linear-gradient(90deg, #6c757d, #868e96);
        color: white;
    }

    .info-panel-body {
        padding: 20px;
    }

    /* Tabel dalam panel */
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--pln-border);
    }

    .info-table tr:last-child {
        border-bottom: none;
    }

    .info-table tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .info-table th, .info-table td {
        padding: 12px 15px;
        text-align: left;
    }

    .info-table th {
        font-weight: 600;
        color: var(--pln-text);
        background: rgba(0, 0, 0, 0.03);
        width: 30%;
    }

    .info-table td {
        color: var(--pln-text);
    }

    /* Progress bar */
    .progress {
        height: 8px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 5px;
    }

    .progress-bar {
        height: 100%;
        border-radius: 10px;
        background-size: 30px 30px;
        background-image: linear-gradient(
            135deg,
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
        0% { background-position: 0 0; }
        100% { background-position: 60px 0; }
    }

    .progress-bar.bg-success {
        background-color: #4CAF50;
    }

    .progress-bar.bg-warning {
        background-color: #FFC107;
    }

    .progress-bar.bg-danger {
        background-color: #dc3545;
    }

    /* Textarea dan form control */
    .bukti-box {
        padding: 15px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        border: 1px solid var(--pln-border);
        margin-top: 10px;
    }

    .form-keterangan {
        padding: 15px;
        border-radius: 12px;
        border: 1px solid var(--pln-border);
        background: rgba(255, 255, 255, 0.03);
        color: var(--pln-text);
    }

    /* Bukti file */
    .bukti-file {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        border: 1px solid var(--pln-border);
        transition: all 0.3s ease;
    }

    .bukti-file:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .bukti-file i {
        font-size: 20px;
        margin-right: 15px;
        color: var(--pln-light-blue);
    }

    .btn-unduh {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(0, 123, 255, 0.2));
        color: #007bff;
        border: 1px solid rgba(0, 123, 255, 0.3);
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .btn-unduh i {
        margin-right: 8px;
        font-size: 14px;
        color: #007bff;
    }

    .btn-unduh:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 123, 255, 0.2);
    }

    /* Tombol aksi */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn i {
        margin-right: 8px;
        transition: transform 0.3s ease;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn:hover {
        transform: translateY(-3px);
    }

    .btn-success {
        background: linear-gradient(135deg, #4CAF50, #3d9140);
        color: white;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .btn-success:hover {
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.5);
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.5);
    }

    /* Alert Styling */
    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border-left: 4px solid;
        animation: slideInDown 0.5s ease-out;
    }

    .alert i {
        margin-right: 10px;
        font-size: 18px;
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
        color: #dc3545;
        border-color: #dc3545;
    }

    .alert-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.05));
        color: #e5ac00;
        border-color: #e5ac00;
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Modal styling */
    .modal-content {
        background: var(--pln-accent-bg);
        border-radius: 20px;
        border: 1px solid var(--pln-border);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-bottom: 1px solid var(--pln-border);
        background: linear-gradient(to right, rgba(0, 123, 255, 0.1), transparent);
        border-radius: 20px 20px 0 0;
    }

    .modal-footer {
        border-top: 1px solid var(--pln-border);
        background: linear-gradient(to right, rgba(0, 123, 255, 0.05), transparent);
        border-radius: 0 0 20px 20px;
    }

    .modal-body {
        padding: 20px;
    }

    .form-label {
        font-weight: 600;
        color: var(--pln-text);
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--pln-border);
        padding: 10px 15px;
        border-radius: 12px;
        color: var(--pln-text);
        font-size: 14px;
        transition: all 0.3s ease;
        width: 100%;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        border-color: var(--pln-light-blue);
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.15), inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    /* Animasi fade in untuk panel */
    .fade-in {
        animation: fadeIn 0.6s ease forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="detail-title">
        <h2>Detail KPI</h2>
        <a href="{{ route('verifikasi.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    @if(isset($isPeriodeLocked) && $isPeriodeLocked)
        <div class="alert alert-warning">
            <i class="fas fa-lock"></i> <strong>Peringatan!</strong> Periode penilaian tahun {{ $realisasi->tahun }} sedang terkunci. Anda tidak dapat melakukan verifikasi pada periode ini.
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6 fade-in" style="animation-delay: 0.1s">
            <div class="info-panel">
                <div class="info-panel-header primary-header">
                    <i class="fas fa-chart-bar"></i> Informasi Indikator
                </div>
                <div class="info-panel-body">
                    <table class="info-table">
                        <tr>
                            <th>Kode KPI</th>
                            <td>{{ $realisasi->indikator->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama KPI</th>
                            <td>{{ $realisasi->indikator->nama }}</td>
                        </tr>
                        <tr>
                            <th>Bidang</th>
                            <td>{{ $realisasi->indikator->bidang->nama }}</td>
                        </tr>
                        <tr>
                            <th>Pilar</th>
                            <td>{{ $realisasi->indikator->pilar->nama }}</td>
                        </tr>
                        <tr>
                            <th>Satuan</th>
                            <td>{{ $realisasi->indikator->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Bobot</th>
                            <td>{{ $realisasi->indikator->bobot }}%</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 fade-in" style="animation-delay: 0.2s">
            <div class="info-panel">
                <div class="info-panel-header info-header">
                    <i class="fas fa-tachometer-alt"></i> Informasi Nilai
                </div>
                <div class="info-panel-body">
                    <table class="info-table">
                        <tr>
                            <th>Periode</th>
                            <td>{{ $realisasi->tahun }} - {{ date('F', mktime(0, 0, 0, $realisasi->bulan, 1)) }}</td>
                        </tr>
                        <tr>
                            <th>Nilai</th>
                            <td>{{ $realisasi->nilai }} {{ $realisasi->indikator->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Target</th>
                            <td>{{ $realisasi->target ?? '-' }} {{ $realisasi->indikator->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Persentase</th>
                            <td>
                                <div class="progress mb-2">
                                    @php
                                        $progressClass = 'bg-danger';
                                        if ($realisasi->persentase >= 70) {
                                            $progressClass = 'bg-success';
                                        } elseif ($realisasi->persentase >= 50) {
                                            $progressClass = 'bg-warning';
                                        }
                                    @endphp
                                    <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $realisasi->persentase }}%" aria-valuenow="{{ $realisasi->persentase }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                {{ number_format($realisasi->persentase, 2) }}%
                            </td>
                        </tr>
                        <tr>
                            <th>Diinput Oleh</th>
                            <td>{{ $realisasi->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Input</th>
                            <td>{{ $realisasi->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="info-panel fade-in" style="animation-delay: 0.3s">
        <div class="info-panel-header secondary-header">
            <i class="fas fa-clipboard-list"></i> Informasi Pendukung
        </div>
        <div class="info-panel-body">
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <div class="form-keterangan">
                    {!! nl2br(e($realisasi->keterangan)) ?: '<em>Tidak ada keterangan</em>' !!}
                </div>
            </div>

            @if($realisasi->bukti_url)
                <div class="mb-3">
                    <label class="form-label">Bukti Pendukung</label>
                    <div class="bukti-file">
                        <i class="fas fa-file-alt"></i>
                        <a href="{{ asset('storage/' . $realisasi->bukti_url) }}" target="_blank" class="btn-unduh">
                            <i class="fas fa-download"></i> Lihat/Unduh Bukti
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="detail-footer">
        <div class="btn-group">
            <a href="{{ route('verifikasi.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            @if(!isset($isPeriodeLocked) || !$isPeriodeLocked)
                @if(Auth::user()->role === 'asisten_manager')
                    <form action="{{ route('verifikasi.update', $realisasi->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success" onclick="return confirm('Yakin verifikasi KPI ini?')">
                            <i class="fas fa-check-circle"></i> Verifikasi
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times-circle"></i> Tolak
                    </button>
                @endif

                @if(str_contains(Auth::user()->role, 'pic_'))
                    @if(!$realisasi->isApprovedByPic())
                        <form action="{{ route('verifikasi.approve.pic', $realisasi->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin menyetujui KPI ini sebagai PIC?')">
                                <i class="fas fa-check"></i> Setujui (PIC)
                            </button>
                        </form>
                    @else
                        <button class="btn btn-outline-primary" disabled>
                            <i class="fas fa-check"></i> Sudah Disetujui PIC
                        </button>
                    @endif
                @endif

                @if(Auth::user()->role === 'manager')
                    @if($realisasi->isApprovedByPic() && !$realisasi->isApprovedByManager())
                        <form action="{{ route('verifikasi.approve.manager', $realisasi->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info" onclick="return confirm('Yakin menyetujui KPI ini sebagai Manager?')">
                                <i class="fas fa-check-double"></i> Setujui (Manager)
                            </button>
                        </form>
                    @elseif($realisasi->isApprovedByManager())
                        <button class="btn btn-outline-info" disabled>
                            <i class="fas fa-check-double"></i> Sudah Disetujui Manager
                        </button>
                    @else
                        <button class="btn btn-outline-secondary" disabled>
                            <i class="fas fa-clock"></i> Menunggu Persetujuan PIC
                        </button>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('verifikasi.destroy', $realisasi->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTolakLabel">
                        <i class="fas fa-times-circle text-danger"></i> Tolak Nilai KPI
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="alasan_penolakan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="4" required></textarea>
                        <small class="text-muted">Berikan alasan yang jelas mengapa nilai KPI ini ditolak</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-kembali" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak KPI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan efek ripple pada tombol-tombol
        const buttons = document.querySelectorAll('.btn, .btn-kembali, .btn-unduh');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (button.type !== 'submit' || !this.form) { // Skip for form submit buttons
                    const x = e.clientX - e.target.getBoundingClientRect().left;
                    const y = e.clientY - e.target.getBoundingClientRect().top;

                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                }
            });
        });
    });
</script>
@endsection
