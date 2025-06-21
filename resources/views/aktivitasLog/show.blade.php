@extends('layouts.app')

@section('title', 'Detail Log Aktivitas')

@section('styles')
<style>
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--pln-text);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .page-title i {
        margin-right: 12px;
        color: var(--pln-light-blue);
    }

    .card {
        background: var(--pln-surface);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pln-border);
        box-shadow: 0 8px 20px var(--pln-shadow);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px var(--pln-shadow);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--pln-border);
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--pln-text);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .card-title i {
        margin-right: 10px;
        color: var(--pln-light-blue);
        font-size: 20px;
    }

    .grid-layout {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .grid-full {
        grid-column: 1 / -1;
    }

    .content-card {
        background: rgba(var(--pln-surface-rgb), 0.5);
        border-radius: 10px;
        padding: 15px;
        border: 1px solid var(--pln-border);
        transition: all 0.3s ease;
    }

    .content-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .log-badge {
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }

    .log-badge i {
        margin-right: 8px;
    }

    .meta-info {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
        background: rgba(var(--pln-blue-rgb), 0.02);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid var(--pln-border);
    }

    .meta-item {
        display: flex;
        align-items: center;
        background: rgba(var(--pln-blue-rgb), 0.05);
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.2s ease;
        flex: 1;
        min-width: 180px;
    }

    .meta-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        background: rgba(var(--pln-blue-rgb), 0.08);
    }

    .meta-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        background: rgba(var(--pln-blue-rgb), 0.1);
        border-radius: 8px;
        margin-right: 10px;
    }

    .meta-icon i {
        color: var(--pln-light-blue);
        font-size: 14px;
    }

    .meta-text {
        display: flex;
        flex-direction: column;
    }

    .meta-label {
        font-size: 12px;
        color: var(--pln-text-secondary);
    }

    .meta-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--pln-text);
    }

    .user-info {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        background: rgba(var(--pln-blue-rgb), 0.03);
        padding: 15px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .user-info:hover {
        background: rgba(var(--pln-blue-rgb), 0.06);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 20px;
        margin-right: 15px;
        box-shadow: 0 5px 15px rgba(0, 156, 222, 0.3);
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 5px;
        color: var(--pln-text);
    }

    .user-role {
        color: var(--pln-text-secondary);
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .user-role i {
        margin-right: 5px;
        font-size: 12px;
    }

    .info-table {
        width: 100%;
    }

    .info-table th, .info-table td {
        padding: 12px 0;
        vertical-align: top;
        border-bottom: 1px solid rgba(var(--pln-border-rgb), 0.3);
    }

    .info-table tr:last-child th,
    .info-table tr:last-child td {
        border-bottom: none;
    }

    .info-table th {
        font-weight: 500;
        color: var(--pln-text-secondary);
        width: 35%;
    }

    .info-table td {
        color: var(--pln-text);
    }

    .code-block {
        background-color: var(--pln-surface-2);
        border-radius: 8px;
        padding: 15px;
        margin: 10px 0;
        overflow-x: auto;
        font-family: "Courier New", monospace;
        font-size: 13px;
        color: var(--pln-text);
        border: 1px solid var(--pln-border);
        max-height: 300px;
        overflow-y: auto;
    }

    .code-block::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .code-block::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .code-block::-webkit-scrollbar-thumb {
        background: rgba(var(--pln-blue-rgb), 0.3);
        border-radius: 10px;
    }

    .code-block::-webkit-scrollbar-thumb:hover {
        background: rgba(var(--pln-blue-rgb), 0.5);
    }

    /* Styling untuk tabel perubahan data */
    .changes-table-container {
        margin: 15px 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--pln-border);
    }

    .changes-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 14px;
    }

    .changes-table th {
        background: linear-gradient(to right, rgba(var(--pln-blue-rgb), 0.1), rgba(var(--pln-blue-rgb), 0.05));
        color: var(--pln-text);
        font-weight: 600;
        text-align: left;
        padding: 14px 16px;
        position: sticky;
        top: 0;
        z-index: 10;
        border-bottom: 1px solid var(--pln-border);
    }

    .changes-table td {
        padding: 12px 16px;
        vertical-align: top;
        border-bottom: 1px solid var(--pln-border);
        transition: background-color 0.2s ease;
    }

    .changes-table tr:hover td {
        background-color: rgba(var(--pln-blue-rgb), 0.03);
    }

    .changes-table tr:last-child td {
        border-bottom: none;
    }

    .field-name {
        font-weight: 500;
        color: var(--pln-light-blue);
        border-right: 1px solid var(--pln-border);
        width: 25%;
    }

    .old-value {
        width: 37.5%;
        color: var(--pln-text-secondary);
        position: relative;
        background-color: rgba(var(--pln-light-blue-rgb), 0.02);
    }

    .new-value {
        width: 37.5%;
        font-weight: 500;
        position: relative;
    }

    .value-null {
        font-style: italic;
        color: var(--pln-text-secondary);
        opacity: 0.7;
    }

    .changes-empty {
        text-align: center;
        padding: 20px;
        color: var(--pln-text-secondary);
        font-style: italic;
    }

    .btn-action {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-action i {
        margin-right: 8px;
    }

    .btn-back {
        background: linear-gradient(45deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        border: none;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 156, 222, 0.3);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(45deg, #e53e3e, #f56565);
        color: white;
        border: none;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(229, 62, 62, 0.3);
        color: white;
    }

    .section-divider {
        height: 1px;
        background: var(--pln-border);
        margin: 20px 0;
    }

    .content-section {
        background: var(--pln-surface);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid var(--pln-border);
        box-shadow: 0 4px 15px var(--pln-shadow);
        position: relative;
        overflow: hidden;
    }

    .content-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
    }

    .badge-role {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 20px;
        font-weight: 600;
        margin-left: 5px;
    }

    .badge-role.role-master {
        background-color: rgba(66, 153, 225, 0.2);
        color: #3182ce;
    }

    .badge-role.role-pic {
        background-color: rgba(72, 187, 120, 0.2);
        color: #38a169;
    }

    .badge-role.role-user {
        background-color: rgba(160, 174, 192, 0.2);
        color: #718096;
    }

    @media (max-width: 992px) {
        .grid-layout {
            grid-template-columns: 1fr;
        }

        .meta-info {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .meta-item {
            flex: 0 0 calc(50% - 10px);
        }
    }

    @media (max-width: 768px) {
        .meta-item {
            flex: 0 0 100%;
        }

        .changes-table th,
        .changes-table td {
            padding: 10px;
        }

        .field-name {
            width: 30%;
        }

        .old-value,
        .new-value {
            width: 35%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid detail-container">
    <!-- Main Content -->
    <div class="content-section">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h2 class="card-title mb-0">
                    <i class="fas {{ $log->getTipeIcon() }}"></i>
                    {{ $log->judul }}
                </h2>
                <span class="log-badge text-white bg-{{ $log->getTipeColor() }} ml-3">
                    <i class="fas {{ $log->getTipeIcon() }}"></i>
                    {{ $log->getTipeLabel() }}
                </span>
            </div>
            <div>
                <button type="button" class="btn btn-action btn-delete" data-toggle="modal" data-target="#deleteLogModal">
                    <i class="fas fa-trash"></i>
                    Hapus Log
                </button>
                <a href="{{ route('aktivitasLog.index') }}" class="btn btn-outline-secondary ml-2">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Meta Information -->
        <div class="meta-info">
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="meta-text">
                    <span class="meta-label">Tanggal</span>
                    <span class="meta-value">{{ $log->created_at->format('d F Y') }}</span>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="meta-text">
                    <span class="meta-label">Waktu</span>
                    <span class="meta-value">{{ $log->created_at->format('H:i:s') }}</span>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="meta-text">
                    <span class="meta-label">User</span>
                    <span class="meta-value">{{ $log->user ? $log->user->name : 'Sistem' }}</span>
                </div>
            </div>

            @if($log->ip_address)
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-network-wired"></i>
                </div>
                <div class="meta-text">
                    <span class="meta-label">IP Address</span>
                    <span class="meta-value">{{ $log->ip_address }}</span>
                </div>
            </div>
            @endif

            @if($log->loggable_type)
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="meta-text">
                    <span class="meta-label">Model</span>
                    <span class="meta-value">{{ class_basename($log->loggable_type) }} #{{ $log->loggable_id }}</span>
                </div>
            </div>
            @endif
        </div>

        <p class="my-3">{{ $log->deskripsi }}</p>

        <div class="section-divider"></div>

        <div class="grid-layout">
            <!-- Informasi Pengguna -->
            @if($log->user)
            <div class="content-card">
                <div class="card-header" style="padding-left: 0; padding-right: 0;">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Informasi Pengguna
                    </h3>
                </div>

                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($log->user->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ $log->user->name }}</div>
                        <div class="user-role">
                            <i class="fas fa-id-badge"></i>
                            @if($log->user->role == 'asisten_manager')
                                <span class="badge-role role-master">Master Admin</span>
                            @elseif(Str::startsWith($log->user->role, 'pic_'))
                                <span class="badge-role role-pic">PIC {{ Str::ucfirst(Str::after($log->user->role, 'pic_')) }}</span>
                            @elseif($log->user->role == 'karyawan')
                                <span class="badge-role role-user">Karyawan</span>
                            @else
                                <span class="badge-role role-user">{{ $log->user->role }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <table class="info-table">
                    <tr>
                        <th>Email</th>
                        <td>{{ $log->user->email }}</td>
                    </tr>
                    @if($log->user->isAdmin() && $log->user->getBidang())
                        <tr>
                            <th>Bidang</th>
                            <td>{{ $log->user->getBidang()->nama }}</td>
                        </tr>
                    @endif
                </table>
            </div>
            @endif

            <!-- Detail Data -->
            @if($log->data)
                <div class="content-card">
                    <div class="card-header" style="padding-left: 0; padding-right: 0;">
                        <h3 class="card-title">
                            <i class="fas fa-code-branch"></i>
                            Detail Perubahan
                        </h3>
                    </div>

                    @if($log->hasPerubahanData())
                        <div class="changes-table-container">
                            <table class="changes-table">
                                <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Nilai Sebelumnya</th>
                                        <th>Nilai Baru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($log->getPerubahan() as $field => $values)
                                        <tr>
                                            <td class="field-name">{{ $field }}</td>
                                            <td class="old-value">
                                                @if(is_array($values['sebelum']))
                                                    <div class="code-block">{{ json_encode($values['sebelum'], JSON_PRETTY_PRINT) }}</div>
                                                @elseif(is_null($values['sebelum']))
                                                    <span class="value-null">NULL</span>
                                                @else
                                                    {{ $values['sebelum'] }}
                                                @endif
                                            </td>
                                            <td class="new-value">
                                                @if(is_array($values['sesudah']))
                                                    <div class="code-block">{{ json_encode($values['sesudah'], JSON_PRETTY_PRINT) }}</div>
                                                @elseif(is_null($values['sesudah']))
                                                    <span class="value-null">NULL</span>
                                                @else
                                                    {{ $values['sesudah'] }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="code-block">
                            <pre>{{ json_encode($log->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif
                </div>
            @endif

            <!-- User Agent -->
            <div class="grid-full content-card">
                <div class="card-header" style="padding-left: 0; padding-right: 0;">
                    <h3 class="card-title">
                        <i class="fas fa-laptop"></i>
                        User Agent
                    </h3>
                </div>
                <div class="code-block">
                    {{ $log->user_agent ?: 'Tidak ada informasi user agent' }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteLogModal" tabindex="-1" role="dialog" aria-labelledby="deleteLogModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLogModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus log aktivitas ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    <strong>Perhatian:</strong> Aksi ini tidak dapat dibatalkan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ url('aktivitas-log', $log->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

