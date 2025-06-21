@extends('layouts.app')
{{-- @extends('layouts.master') --}}

@section('title', 'Kelola Akun - PLN')
@section('page_title', 'DATA AKUN')

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

    /* Animasi untuk modal */
    .modal-content.animate-in {
        animation: modalIn 0.4s cubic-bezier(0.19, 1, 0.22, 1) forwards;
    }

    .modal-content.animate-out {
        animation: modalOut 0.3s cubic-bezier(0.19, 1, 0.22, 1) forwards;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes modalOut {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        to {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
    }

    /* Gaya untuk judul */
    .akun-title {
        margin-bottom: 20px;
        color: var(--pln-text);
        font-weight: 700;
        font-size: 24px;
        position: relative;
        padding-left: 16px;
    }

    .akun-title::before {
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

    /* Gaya dasar untuk tabel */
    .akun-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        margin: 20px 0;
        table-layout: fixed;
    }

    /* Gaya untuk header tabel */
    .akun-table th {
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
        color: white;
        padding: 15px 15px;
        text-align: left;
        font-weight: 600;
        border: none;
        text-transform: uppercase;
        font-size: 13px;
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    .akun-table th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .akun-table th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Gaya untuk sel tabel */
    .akun-table td {
        padding: 15px;
        border: none;
        background: rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
        vertical-align: middle;
    }

    .akun-table tbody tr {
        transition: all 0.3s ease;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--pln-border);
    }

    .akun-table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        background: rgba(255, 255, 255, 0.07);
    }

    .akun-table tbody tr td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .akun-table tbody tr td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Gaya untuk tombol aksi */
    .btn-action {
        padding: 8px 12px;
        margin-right: 5px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        font-weight: 600;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }

    .btn-action:hover::before {
        left: 100%;
    }

    .btn-action i {
        margin-right: 6px;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-3px);
    }

    .btn-detail {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(23, 162, 184, 0.2));
        color: #17a2b8;
        border: 1px solid rgba(23, 162, 184, 0.3);
    }

    .btn-detail:hover {
        box-shadow: 0 6px 15px rgba(23, 162, 184, 0.2);
    }

    .btn-edit {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.2));
        color: #e5ac00;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .btn-edit:hover {
        box-shadow: 0 6px 15px rgba(255, 193, 7, 0.2);
    }

    .btn-hapus {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.2));
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .btn-hapus:hover {
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.2);
    }

    /* Gaya untuk role badge */
    .role-badge {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .role-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: all 0.6s ease;
    }

    .role-badge:hover::before {
        transform: translateX(100%);
    }

    .role-badge i {
        margin-right: 6px;
        transition: transform 0.3s ease;
    }

    .role-badge:hover i {
        transform: rotate(360deg);
    }

    .role-badge {
        background: linear-gradient(135deg, #00a8e8 0%, #0094d3 100%);
        color: white;
    }

    .role-badge.admin {
        background: linear-gradient(135deg, #4CAF50 0%, #3d9140 100%);
    }

    .role-badge.pic {
        background: linear-gradient(135deg, #FFC107 0%, #e5ac00 100%);
        color: #333;
    }

    /* Gaya untuk tombol tambah akun */
    .btn-tambah-akun {
        background: linear-gradient(135deg, var(--pln-light-blue), var(--pln-blue));
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 156, 222, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-tambah-akun::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: 0.6s;
    }

    .btn-tambah-akun:hover::before {
        left: 100%;
    }

    .btn-tambah-akun i {
        margin-right: 8px;
        transition: all 0.3s ease;
    }

    .btn-tambah-akun:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 156, 222, 0.5);
    }

    .btn-tambah-akun:hover i {
        transform: rotate(90deg);
    }

    /* Gaya untuk kotak pencarian */
    .search-box {
        display: flex;
        margin-bottom: 20px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        border: 1px solid var(--pln-border);
        padding: 2px 2px 2px 16px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        max-width: 350px;
    }

    .search-box:focus-within {
        border-color: var(--pln-light-blue);
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.15);
    }

    .search-box input {
        background: transparent;
        border: none;
        padding: 8px 0;
        color: var(--pln-text);
        font-size: 14px;
        width: 100%;
        outline: none;
    }

    .search-box button {
        background: linear-gradient(135deg, var(--pln-light-blue), var(--pln-blue));
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-box button:hover {
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        transform: translateY(-2px);
    }

    /* Gaya untuk pesan sukses */
    .alert-success {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.1), rgba(25, 135, 84, 0.2));
        color: #4CAF50;
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 20px;
        border-left: 5px solid #4CAF50;
        display: flex;
        align-items: center;
        animation: slideInDown 0.5s ease-out, fadeOut 0.5s ease-out 4s forwards;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .alert-success i {
        font-size: 20px;
        margin-right: 12px;
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; height: 0; margin: 0; padding: 0; }
    }

    /* Gaya untuk pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .pagination-control {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
        padding: 8px 16px;
        border-radius: 12px;
        border: 1px solid var(--pln-border);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .pagination-control label {
        margin-right: 10px;
        font-weight: 500;
        color: var(--pln-text-secondary);
    }

    .pagination-control select {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--pln-border);
        border-radius: 8px;
        padding: 5px 25px 5px 10px;
        color: var(--pln-text);
        font-weight: 600;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Gaya untuk modal */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
    }

    .modal-backdrop.show {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background: var(--pln-surface);
        border-radius: 24px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                   0 0 0 1px rgba(255, 255, 255, 0.1),
                   inset 0 1px 1px rgba(255, 255, 255, 0.05);
        border: 1px solid var(--pln-border);
        transform: translateY(40px) scale(0.95);
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        overflow: hidden;
        position: relative;
    }

    .modal-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
        background-size: 200% 100%;
        animation: gradientShift 8s ease infinite;
    }

    .modal-backdrop.show .modal-content {
        transform: translateY(0) scale(1);
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: 1px solid var(--pln-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(to right, rgba(10, 77, 133, 0.15), rgba(0, 156, 222, 0.05));
    }

    .modal-header h3 {
        font-size: 1.3rem;
        color: var(--pln-text);
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .modal-header h3 i {
        margin-right: 10px;
        color: var(--pln-light-blue);
    }

    .modal-header button {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: var(--pln-text);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        font-size: 20px;
    }

    .modal-header button::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        transform: scale(0);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-header button:hover::before {
        transform: scale(2);
        opacity: 1;
    }

    .modal-header button:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 25px;
        max-height: calc(100vh - 240px);
        overflow-y: auto;
    }

    .modal-footer {
        padding: 20px 25px;
        border-top: 1px solid var(--pln-border);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: linear-gradient(to right, rgba(10, 77, 133, 0.05), rgba(0, 156, 222, 0.03));
    }

    .modal-footer button {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .modal-footer button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }

    .modal-footer button:hover::before {
        left: 100%;
    }

    .modal-footer button:hover {
        transform: translateY(-3px);
    }

    .modal-footer button:first-child {
        background: rgba(255, 255, 255, 0.1);
        color: var(--pln-text);
        border: 1px solid var(--pln-border);
    }

    .modal-footer button[type="submit"] {
        background: linear-gradient(135deg, var(--pln-light-blue), var(--pln-blue));
        color: white;
        box-shadow: 0 4px 15px rgba(0, 156, 222, 0.3);
    }

    .modal-footer button[type="submit"]:hover {
        box-shadow: 0 8px 20px rgba(0, 156, 222, 0.4);
    }

    .modal-footer form button[type="submit"] {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .modal-footer form button[type="submit"]:hover {
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    }

    /* Style untuk form pada modal */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--pln-text);
    }

    .form-group input,
    .form-group select {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--pln-border);
        padding: 12px 15px;
        border-radius: 12px;
        color: var(--pln-text);
        font-size: 15px;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: var(--pln-light-blue);
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 156, 222, 0.15), inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .form-group select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
        padding-right: 40px;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, var(--pln-light-blue), var(--pln-blue));
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: content-box;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #0094d3, var(--pln-blue));
    }

    /* Animation for modal */
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(60px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-backdrop.show .modal-content {
        animation: modalFadeIn 0.4s cubic-bezier(0.19, 1, 0.22, 1) forwards;
    }

    /* Empty State Animation */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 50px 0;
        animation: fadeIn 0.5s ease-out;
    }

    .empty-state i {
        font-size: 60px;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.15);
        background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pulse 3s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); opacity: 0.8; }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }

        .akun-table {
            font-size: 14px;
        }

        .btn-action {
            padding: 6px 10px;
            font-size: 12px;
        }

        .modal-content {
            width: 95%;
        }
    }

    @media (max-width: 576px) {
        .akun-table {
            font-size: 12px;
        }

        .akun-table th, .akun-table td {
            padding: 10px 8px;
        }

        .btn-action span {
            display: none;
        }

        .btn-action i {
            margin-right: 0;
        }
    }

    /* Gaya untuk foto profil mini */
    .profile-image-mini {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
        border: 2px solid var(--pln-border);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .profile-image-container {
        display: flex;
        align-items: center;
    }

    .profile-icon-mini {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--pln-accent-bg);
        color: var(--pln-text-secondary);
        margin-right: 10px;
        border: 2px solid var(--pln-border);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .profile-image-mini:hover, .profile-icon-mini:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Gaya untuk foto profil di modal detail */
    .profile-image-modal {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 20px;
        display: block;
        border: 3px solid var(--pln-border);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-icon-modal {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--pln-accent-bg);
        color: var(--pln-text-secondary);
        margin: 0 auto 20px;
        font-size: 2.5rem;
        border: 3px solid var(--pln-border);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2 class="akun-title">Daftar Akun</h2>

    <div class="action-top">
        <form action="{{ route('akun.index') }}" method="GET" class="search-box">
            <input type="text" name="search" placeholder="Cari nama, email, atau role..." value="{{ request('search') }}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <button type="button" class="btn-tambah-akun" onclick="showAddModal()">
            <i class="fas fa-plus-circle"></i> Tambah Akun
        </button>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="akun-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Foto</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            @if($user->profile_photo)
                                <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}" class="profile-image-mini">
                            @else
                                <div class="profile-icon-mini">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $user->name ?: 'Tidak ada nama' }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @php
                                $roleClass = 'role-badge';
                                $roleIcon = 'fa-user';

                                if (strpos($user->role, 'asisten_manager') !== false) {
                                    $roleClass .= ' admin';
                                    $roleIcon = 'fa-user-shield';
                                } elseif (strpos($user->role, 'pic') !== false) {
                                    $roleClass .= ' pic';
                                    $roleIcon = 'fa-user-tie';
                                }
                            @endphp
                            <span class="{{ $roleClass }}">
                                <i class="fas {{ $roleIcon }}"></i>
                                {{ ucwords(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn-action btn-detail"
                                onclick="showDetailModal('{{ $user->name }}', '{{ $user->email }}', '{{ ucwords(str_replace('_', ' ', $user->role)) }}', '{{ $user->profile_photo ? Storage::url($user->profile_photo) : '' }}')">
                                <i class="fas fa-eye"></i> <span>Detail</span>
                            </button>
                            <button type="button" class="btn-action btn-edit"
                                onclick="showEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                <i class="fas fa-edit"></i> <span>Edit</span>
                            </button>
                            <button type="button" class="btn-action btn-hapus"
                                onclick="showDeleteModal({{ $user->id }}, '{{ $user->name }}')">
                                <i class="fas fa-trash"></i> <span>Hapus</span>
                            </button>
                        </td>
                    </tr>
                @endforeach

                @if ($users->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-users-slash"></i>
                                <p>Belum ada data akun di sistem</p>
                                <button type="button" class="btn-tambah-akun" onclick="showAddModal()">
                                    <i class="fas fa-plus-circle"></i> Tambah Akun Baru
                                </button>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if($users->isNotEmpty())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
        </div>
        <div class="pagination-control">
            <label for="perPage">Tampilkan:</label>
            <select id="perPage" onchange="changePerPage(this.value)">
                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span>data per halaman</span>
        </div>
        <div class="pagination-links">
            {{ $users->appends(['perPage' => request('perPage', 10)])->links('pagination.custom') }}
        </div>
    </div>
    @endif
</div>

<!-- Modal Detail -->
<div class="modal-backdrop" id="detailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Akun</h3>
            <button type="button" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div id="detailPhoto" class="text-center mb-4">
                <!-- Foto profil akan ditampilkan di sini -->
            </div>
            <p><strong>Nama:</strong> <span id="detailName"></span></p>
            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
            <p><strong>Role:</strong> <span id="detailRole"></span></p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeModal('detailModal')">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal-backdrop" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <button type="button" onclick="closeModal('deleteModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus akun <strong id="deleteUserName"></strong>?</p>
            <p>Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeModal('deleteModal')">Batal</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" style="background-color: #dc3545; color: white;">Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal-backdrop" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Akun</h3>
            <button type="button" onclick="closeModal('editModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 15px;">
                    <label for="editName">Nama Lengkap</label>
                    <input type="text" id="editName" name="name" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" name="email" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="password">Password</label>
                    <input type="password" name="password" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="Biarkan kosong jika tidak diubah">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="Biarkan kosong jika tidak diubah">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="editRole">Peran</label>
                    <select id="editRole" name="role" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                        <option value="asisten_manager">Asisten Manager</option>
                        <option value="pic_keuangan">PIC Bidang Keuangan</option>
                        <option value="pic_manajemen_risiko">PIC Manajemen Risiko</option>
                        <option value="pic_sekretaris_perusahaan">PIC Sekretaris Perusahaan</option>
                        <option value="pic_perencanaan_operasi">PIC Perencanaan Operasi</option>
                        <option value="pic_pengembangan_bisnis">PIC Pengembangan Bisnis</option>
                        <option value="pic_human_capital">PIC Human Capital</option>
                        <option value="pic_k3l">PIC K3L</option>
                        <option value="pic_perencanaan_korporat">PIC Perencanaan Korporat</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('editModal')">Batal</button>
                    <button type="submit" style="background-color: var(--pln-blue); color: white;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal-backdrop" id="addModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Akun Baru</h3>
            <button type="button" onclick="closeModal('addModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="addForm" method="POST" action="{{ route('akun.store') }}">
                @csrf
                @if ($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div style="margin-bottom: 15px;">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" style="width: 100%; padding: 8px; margin-top: 5px;" value="{{ old('name') }}" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="email">Email</label>
                    <input type="email" name="email" style="width: 100%; padding: 8px; margin-top: 5px;" value="{{ old('email') }}" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="password">Password</label>
                    <input type="password" name="password" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="role">Peran</label>
                    <select name="role" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                        <option value="">-- Pilih Peran --</option>
                        <option value="asisten_manager" {{ old('role') == 'asisten_manager' ? 'selected' : '' }}>Asisten Manager</option>
                        <option value="pic_keuangan" {{ old('role') == 'pic_keuangan' ? 'selected' : '' }}>PIC Bidang Keuangan</option>
                        <option value="pic_manajemen_risiko" {{ old('role') == 'pic_manajemen_risiko' ? 'selected' : '' }}>PIC Manajemen Risiko</option>
                        <option value="pic_sekretaris_perusahaan" {{ old('role') == 'pic_sekretaris_perusahaan' ? 'selected' : '' }}>PIC Sekretaris Perusahaan</option>
                        <option value="pic_perencanaan_operasi" {{ old('role') == 'pic_perencanaan_operasi' ? 'selected' : '' }}>PIC Perencanaan Operasi</option>
                        <option value="pic_pengembangan_bisnis" {{ old('role') == 'pic_pengembangan_bisnis' ? 'selected' : '' }}>PIC Pengembangan Bisnis</option>
                        <option value="pic_human_capital" {{ old('role') == 'pic_human_capital' ? 'selected' : '' }}>PIC Human Capital</option>
                        <option value="pic_k3l" {{ old('role') == 'pic_k3l' ? 'selected' : '' }}>PIC K3L</option>
                        <option value="pic_perencanaan_korporat" {{ old('role') == 'pic_perencanaan_korporat' ? 'selected' : '' }}>PIC Perencanaan Korporat</option>
                        <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('addModal')">Batal</button>
                    <button type="submit" style="background-color: var(--pln-blue); color: white;">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Function to show modal dengan animasi
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');

            // Tambahkan kelas untuk animasi pada content modal
            const modalContent = modal.querySelector('.modal-content');
            if (modalContent) {
                modalContent.classList.add('animate-in');
            }

            // Mencegah scrolling pada halaman ketika modal terbuka
            document.body.style.overflow = 'hidden';
        }
    }

    // Function to close modal dengan animasi
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Animasikan keluarnya modal
            const modalContent = modal.querySelector('.modal-content');
            if (modalContent) {
                modalContent.classList.remove('animate-in');
                modalContent.classList.add('animate-out');

                // Delay sedikit sebelum benar-benar menutup modal
                setTimeout(() => {
                    modal.classList.remove('show');
                    modalContent.classList.remove('animate-out');
                    document.body.style.overflow = '';
                }, 300);
            } else {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        }
    }

    // Functions for different modal types
    function showAddModal() {
        showModal('addModal');
    }

    function showDetailModal(name, email, role, profilePhoto) {
        document.getElementById('detailName').innerText = name;
        document.getElementById('detailEmail').innerText = email;
        document.getElementById('detailRole').innerText = role;

        // Tampilkan foto profil jika ada
        const photoContainer = document.getElementById('detailPhoto');
        if (profilePhoto) {
            photoContainer.innerHTML = `<img src="${profilePhoto}" alt="${name}" class="profile-image-modal">`;
        } else {
            photoContainer.innerHTML = `<div class="profile-icon-modal"><i class="fas fa-user"></i></div>`;
        }

        showModal('detailModal');
    }

    function showEditModal(userId, name, email, role) {
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value = role;
        const form = document.getElementById('editForm');
        form.action = `/akun/${userId}`;
        showModal('editModal');
    }

    function showDeleteModal(userId, userName) {
        document.getElementById('deleteUserName').textContent = userName;
        const form = document.getElementById('deleteForm');
        form.action = `/akun/${userId}`;
        showModal('deleteModal');
    }

    // Function to change items per page
    function changePerPage(value) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('perPage', value);

        if (urlParams.has('search')) {
            const searchValue = urlParams.get('search');
            window.location.href = '{{ route("akun.index") }}?perPage=' + value + '&search=' + searchValue;
        } else {
            window.location.href = '{{ route("akun.index") }}?perPage=' + value;
        }
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('.modal-backdrop');
        modals.forEach(modal => {
            if (event.target === modal) {
                const modalId = modal.id;
                closeModal(modalId);
            }
        });
    });

    // Escape key to close modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const visibleModal = document.querySelector('.modal-backdrop.show');
            if (visibleModal) {
                closeModal(visibleModal.id);
            }
        }
    });

    // Show add modal if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any())
            showAddModal();
        @endif

        // Tambahkan efek ripple pada tombol-tombol
        const buttons = document.querySelectorAll('.btn-action, .btn-tambah-akun');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
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
            });
        });

        // Tambahkan animasi untuk baris tabel saat pertama kali dimuat
        const tableRows = document.querySelectorAll('.akun-table tbody tr');
        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';

            setTimeout(() => {
                row.style.transition = 'all 0.4s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 100 + (index * 50));
        });
    });
</script>
@endsection
