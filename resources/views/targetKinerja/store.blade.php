@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Input Target KPI</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('targetKinerja.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="indikator_id" class="form-label">Indikator</label>
            <select name="indikator_id" id="indikator_id" class="form-control" required>
                @foreach($indikators as $indikator)
                    <option value="{{ $indikator->id }}">{{ $indikator->kode }} - {{ $indikator->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tahun_penilaian_id" class="form-label">Tahun Penilaian</label>
            <select name="tahun_penilaian_id" id="tahun_penilaian_id" class="form-control" required>
                @foreach($tahunPenilaians as $tahun)
                    <option value="{{ $tahun->id }}">{{ $tahun->tahun }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="target_tahunan" class="form-label">Target Tahunan</label>
            <input type="number" step="0.01" class="form-control" name="target_tahunan" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Target Bulanan</label>
            @php
                $bulan = [
                    'Januari', 'Februari', 'Maret', 'April',
                    'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'
                ];
            @endphp
            <div class="row">
                @foreach($bulan as $i => $nama_bulan)
                    <div class="col-md-3 mb-2">
                        <label class="form-label">{{ $nama_bulan }}</label>
                        <input type="number" step="0.01" class="form-control" name="target_bulanan[{{ $i }}]" value="8.33">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Target</button>
    </form>
</div>
@endsection
