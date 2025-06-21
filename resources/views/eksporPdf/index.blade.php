@extends('layouts.app')

@section('title', 'Ekspor Laporan PDF')

@section('styles')
<style>
    .form-section {
        background-color: var(--pln-accent-bg);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border);
        box-shadow: 0 8px 20px var(--pln-shadow);
        transition: all 0.3s ease;
    }

    .form-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    }

    .form-section h4 {
        color: var(--pln-light-blue);
        margin-bottom: 20px;
        font-weight: 600;
    }

    .form-section .form-group label {
        font-weight: 500;
        color: var(--pln-text);
    }

    .form-section .btn-submit {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .form-section .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 156, 222, 0.3);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0 text-gray-800">Ekspor Laporan PDF</h1>
            <p class="text-muted">Ekspor laporan kinerja dalam format PDF berdasarkan kriteria yang dipilih</p>
        </div>
    </div>

    @include('components.alert')



<!-- Ekspor Keseluruhan -->
<div class="col-md-4">
    <div class="form-section">
        <h4><i class="fas fa-chart-line mr-2"></i> Laporan Keseluruhan</h4>
<form action="{{ route('eksporPdf.keseluruhan') }}" method="POST" target="_blank">
    @csrf

    <div class="form-group">
        <label for="tahun">Tahun</label>
        <select name="tahun" id="tahun" class="form-control" required>
            @for ($i = date('Y'); $i >= 2020; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <div class="form-group">
        <label for="bulan">Bulan</label>
        <select name="bulan" id="bulan" class="form-control" required>
            @php
                $namaBulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
            @endphp
            @foreach($namaBulan as $key => $bulan)
                <option value="{{ $key }}">{{ $bulan }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-file-pdf mr-2"></i> Ekspor PDF
    </button>
</form>

    </div>
</div>

    </div>
</div>
@endsection
