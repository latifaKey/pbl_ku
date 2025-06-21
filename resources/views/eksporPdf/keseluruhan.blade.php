<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #009CDE;
            padding-bottom: 10px;
        }
        .logo {
            width: 150px;
            display: block;
            margin: 0 auto 15px;
        }
        h1 {
            font-size: 18px;
            margin: 5px 0;
            color: #0A4D85;
        }
        h2 {
            font-size: 16px;
            margin: 15px 0 10px;
            color: #009CDE;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        h3 {
            font-size: 14px;
            margin: 10px 0;
            color: #333;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #009CDE;
            color: white;
            text-align: left;
            padding: 8px;
            font-size: 12px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
        }
        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 10px;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .summary-table {
            width: 400px;
            margin: 0 auto 30px;
        }
        .summary-table th {
            width: 60%;
        }
        .pilar-header {
            background-color: #f8f9fa;
            border-left: 4px solid #009CDE;
            padding: 10px;
            margin: 20px 0 15px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo_pln.png') }}" alt="Logo PLN" class="logo">
        <h1>{{ $title }}</h1>
        <p class="subtitle">{{ $subtitle }}</p>
        <p class="subtitle">PT PLN (Persero)</p>
    </div>

    <div class="info-section">
        <div class="info-item">
            <span class="info-label">Tanggal Cetak</span>
            <span>: {{ $tanggal_cetak }}</span>
        </div>
    </div>

    <h2>Ringkasan Pencapaian KPI</h2>
    <table class="summary-table">
        <thead>
            <tr>
                <th>Metrik</th>
                <th class="text-right">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Indikator</td>
                <td class="text-right">{{ $totalIndikator }}</td>
            </tr>
            <tr>
                <td>Indikator Tercapai</td>
                <td class="text-right">{{ $tercapai }}</td>
            </tr>
            <tr>
                <td>Indikator Belum Tercapai</td>
                <td class="text-right">{{ $belumTercapai }}</td>
            </tr>
            <tr>
                <td>Rata-rata Pencapaian</td>
                <td class="text-right">{{ $rataRataPencapaian }}%</td>
            </tr>
        </tbody>
    </table>

    <h2>Detail Indikator Kinerja Per-Pilar</h2>

    @foreach($pilars as $pilar)
        <div class="pilar-header">Pilar {{ $pilar->kode }}: {{ $pilar->nama }}</div>

        @if($pilar->indikators->isEmpty())
            <p>Tidak ada indikator untuk pilar ini.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Indikator</th>
                        <th>Bidang</th>
                        <th>Target</th>
                        <th>Realisasi</th>
                        <th>Pencapaian</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pilar->indikators as $index => $indikator)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $indikator->kode }}</td>
                            <td>{{ $indikator->nama }}</td>
                            <td>{{ $indikator->bidang->nama ?? '-' }}</td>
                            <td class="text-right">
                                {{ isset($indikator->realisasi_target) ? number_format($indikator->realisasi_target, 2) : '-' }}
                            </td>
                            <td class="text-right">
                                {{ isset($indikator->realisasi_nilai) ? number_format($indikator->realisasi_nilai, 2) : '-' }}
                            </td>
                            <td class="text-right">
                                {{ isset($indikator->realisasi_persentase) ? number_format($indikator->realisasi_persentase, 2) . '%' : '-' }}
                            </td>
                            <td>
                                @php
                                    $status = $indikator->realisasi_status ?? 'Belum Ada Data';
                                    $statusClass = match($status) {
                                        'Tercapai' => 'status-success',
                                        'Belum Tercapai' => 'status-danger',
                                        default => 'status-danger'
                                    };
                                @endphp
                                <span class="status {{ $statusClass }}">{{ $status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    <div class="footer">
        <p>Dokumen ini dicetak oleh Sistem Manajemen Kinerja PLN pada {{ $tanggal_cetak }}</p>
        <p>&copy; {{ date('Y') }} PT PLN (Persero). Hak Cipta Dilindungi.</p>
    </div>
</body>

</html>
