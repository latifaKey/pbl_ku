@extends('layouts.app')


@section('title', 'Detail Akun')
@section('page_title', 'Detail Akun')

@section('content')
<div style="background: #fff; border-radius: 16px; padding: 30px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-family: 'Segoe UI', sans-serif;">
    <h2 style="margin-bottom: 20px; color: #00566b;">Detail Akun</h2>

    <div style="margin-bottom: 15px;">
        <strong>Nama Lengkap:</strong>
        <div style="margin-top: 5px;">{{ $user->name }}</div>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Email:</strong>
        <div style="margin-top: 5px;">{{ $user->email }}</div>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Role:</strong>
        <div style="margin-top: 5px;">{{ ucfirst($user->role) }}</div>
    </div>

    <div style="margin-top: 30px;">
        <a href="{{ route('akun.index') }}" style="background: #6c757d; color: white; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-size: 14px;">Kembali</a>
        <a href="{{ route('akun.edit', $user->id) }}" style="background: #ffc107; color: black; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; margin-left: 10px;">Edit</a>
    </div>
</div>
@endsection
