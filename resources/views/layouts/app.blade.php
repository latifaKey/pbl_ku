@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'PB LIGHT') | Mandau Cipta Tenaga Nusantara</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="/css/style.css">
  <style>
    :root {
      /* Common variables */
      --pln-blue: #0a4d85;
      --pln-light-blue: #009cde;

      /* Light theme variables (default) */
      --pln-bg: #f5f7fa;
      --pln-surface: #ffffff;
      --pln-surface-2: #f0f2f5;
      --pln-text: #333333;
      --pln-text-secondary: rgba(0, 0, 0, 0.6);
      --pln-border: rgba(0, 0, 0, 0.1);
      --pln-shadow: rgba(0, 0, 0, 0.1);
      --pln-accent-bg: rgba(10, 77, 133, 0.05);
      --pln-header-bg: linear-gradient(90deg, var(--pln-blue), var(--pln-light-blue));
      --sidebar-width: 70px;
      --sidebar-expanded: 260px;
      --sidebar-bg: #0a4d85;
      --transition-speed: 0.35s;
    }

    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: var(--pln-bg);
      color: var(--pln-text);
      transition: background-color var(--transition-speed) ease,
                  color var(--transition-speed) ease;
    }

    .container-fluid {
      display: flex;
      min-height: 100vh;
      padding: 0;
      width: 100%;
    }

    .dashboard-header {
      width: 100%;
      padding: 15px 25px;
      background: var(--pln-header-bg);
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      left: var(--sidebar-width);
      height: 70px;
      z-index: 10;
      width: calc(100% - var(--sidebar-width));
      box-shadow: 0 2px 15px var(--pln-shadow);
      transition: left var(--transition-speed) ease,
                  width var(--transition-speed) ease;
    }

    /* Layouts untuk header */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-left {
      display: flex;
      align-items: center;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    /* Tombol toggle sidebar */
    .sidebar-toggle {
      display: none;
      background: transparent;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      padding: 8px;
      margin-right: 10px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .sidebar-toggle:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    /* Tombol ikon di topbar */
    .topbar-icon-btn {
      position: relative;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(0, 0, 0, 0.2);
      border-radius: 50%;
      cursor: pointer;
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s ease;
    }

    .topbar-icon-btn:hover {
      background: rgba(0, 0, 0, 0.3);
      transform: translateY(-2px);
    }

    .topbar-icon-btn i {
      font-size: 16px;
      color: white;
    }

    /* Notifikasi */
    .notification-btn {
      position: relative;
    }

    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: #ff4757;
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .notification-badge-2 {
      position: absolute;
      top: -5px;
      left: -5px;
      background-color: #2ed573;
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .notification-dropdown {
      position: fixed;
      top: 70px;
      right: 20px;
      width: 350px;
      background: var(--pln-surface);
      border-radius: 12px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
      border: 1px solid var(--pln-border);
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      overflow: hidden;
      max-height: 80vh;
      display: flex;
      flex-direction: column;
    }

    .notification-dropdown.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .notification-header {
      padding: 15px;
      border-bottom: 1px solid var(--pln-border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(0, 0, 0, 0.05);
    }

    .notification-header h5 {
      margin: 0;
      font-size: 16px;
      font-weight: 600;
      color: var(--pln-text);
    }

    .close-btn {
      background: none;
      border: none;
      color: var(--pln-text-secondary);
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .close-btn:hover {
      color: var(--pln-text);
    }

    .notification-body {
      padding: 0;
      overflow-y: auto;
      max-height: calc(80vh - 50px);
    }

    .notification-section {
      padding: 10px 0;
      border-bottom: 1px solid var(--pln-border);
    }

    .notification-section h6 {
      padding: 0 15px;
      margin-bottom: 10px;
      font-size: 14px;
      font-weight: 600;
      color: var(--pln-text-secondary);
    }

    .notification-item {
      display: flex;
      padding: 10px 15px;
      border-left: 3px solid transparent;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .notification-item:hover {
      background: rgba(0, 0, 0, 0.05);
      border-left-color: var(--pln-light-blue);
    }

    .notification-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      flex-shrink: 0;
    }

    .notification-icon i {
      color: white;
      font-size: 14px;
    }

    .bg-warning {
      background-color: #ffa502;
    }

    .bg-info {
      background-color: #2e86de;
    }

    .notification-content {
      flex-grow: 1;
    }

    .notification-title {
      margin: 0 0 3px 0;
      font-size: 14px;
      font-weight: 500;
      color: var(--pln-text);
      line-height: 1.3;
    }

    .notification-info {
      margin: 0 0 3px 0;
      font-size: 12px;
      color: var(--pln-text-secondary);
    }

    .notification-time {
      margin: 0;
      font-size: 11px;
      color: var(--pln-text-secondary);
      opacity: 0.8;
    }

    .notification-more {
      display: block;
      text-align: center;
      padding: 8px;
      font-size: 13px;
      color: var(--pln-light-blue);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .notification-more:hover {
      background: rgba(0, 156, 222, 0.1);
    }

    .notification-empty {
      padding: 30px 15px;
      text-align: center;
      color: var(--pln-text-secondary);
    }

    .notification-empty i {
      font-size: 32px;
      margin-bottom: 10px;
      opacity: 0.5;
    }

    .notification-empty p {
      margin: 0;
      font-size: 14px;
    }

    /* Sidebar yang lebih modern */
    .sidebar {
      width: var(--sidebar-width);
      background: var(--sidebar-bg);
      position: fixed;
      height: 100%;
      left: 0;
      top: 0;
      z-index: 100;
      transition: all var(--transition-speed) ease;
      overflow: hidden;
      box-shadow: 2px 0 20px var(--pln-shadow);
    }

    .sidebar:hover {
      width: var(--sidebar-expanded);
    }

    .sidebar-logo {
      padding: 15px;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      height: 70px;
      background: rgba(0,0,0,0.2);
      overflow: hidden;
      white-space: nowrap;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-logo img {
      height: 40px;
      min-width: 40px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      margin-right: 15px;
      transition: transform 0.3s ease;
    }

    .sidebar:hover .sidebar-logo img {
      transform: scale(1.05);
    }

    .logo-text {
      opacity: 0;
      transform: translateX(-20px);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .sidebar:hover .logo-text {
      opacity: 1;
      transform: translateX(0);
    }

    .logo-title {
      font-size: 18px;
      font-weight: 600;
      margin: 0;
      color: #fff;
      letter-spacing: 1px;
    }

    .logo-subtitle {
      font-size: 11px;
      margin: 0;
      color: rgba(255,255,255,0.7);
      line-height: 1.2;
    }

    /* Sidebar menu yang lebih baik */
    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 1rem 0;
    }

    .sidebar-menu li {
      width: 100%;
      margin-bottom: 0.5rem;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      padding: 12px 15px;
      text-decoration: none;
      color: rgba(255, 255, 255, 0.7);
      transition: all 0.3s ease;
      border-radius: 8px;
      margin: 0 8px;
      position: relative;
    }

    .sidebar-menu a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white;
    }

    .sidebar-menu a.active {
      background: rgba(var(--accent-color-rgb), 0.2);
      color: rgb(var(--accent-color-rgb));
      font-weight: 600;
    }

    .sidebar-menu a.active::before {
      content: '';
      position: absolute;
      left: -8px;
      top: 50%;
      transform: translateY(-50%);
      height: 70%;
      width: 4px;
      background: rgb(var(--accent-color-rgb));
      border-radius: 0 4px 4px 0;
    }

    .sidebar-menu .icon {
      min-width: 24px;
      margin-right: 10px;
      font-size: 1.1rem;
    }

    .sidebar-menu .menu-text {
      display: none;
      white-space: nowrap;
    }

    .sidebar:hover .menu-text {
      display: inline-block;
    }

    /* Date display yang lebih modern */
    .date-display {
      color: white;
      font-size: 14px;
      background: rgba(0,0,0,0.25);
      padding: 8px 15px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255,255,255,0.1);
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
    }

    .date-display:hover {
      background: rgba(0,0,0,0.35);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .date-display:active {
      transform: translateY(0);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }

    .date-display i {
      margin-right: 8px;
      color: var(--pln-light-blue);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { opacity: 0.7; }
      50% { opacity: 1; }
      100% { opacity: 0.7; }
    }

    .date-info {
      margin-right: 8px;
    }

    .time-display {
      display: none;
    }

    .time-colon {
      display: none;
    }

    .time-seconds {
      display: none;
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    .header-text {
      line-height: 1.2;
    }

    .header-title {
      font-size: 18px;
      font-weight: 600;
      margin: 0;
      color: white;
      letter-spacing: 0.5px;
    }

    .header-subtitle {
      font-size: 12px;
      margin: 0;
      opacity: 0.9;
      color: white;
    }

    .main {
      margin-top: 70px;
      margin-left: var(--sidebar-width);
      padding: 25px;
      width: calc(100% - var(--sidebar-width));
      transition: margin-left var(--transition-speed) ease,
                  width var(--transition-speed) ease;
    }

    /* Logout button yang lebih modern */
    .logout-btn {
      position: absolute;
      bottom: 20px;
      left: 0;
      width: 100%;
      background: none;
      border: none;
      display: flex;
      align-items: center;
      color: white;
      padding: 12px 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      opacity: 0.8;
    }

    .logout-btn:hover {
      background: linear-gradient(to right, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.3));
      opacity: 1;
    }

    .logout-icon {
      margin-right: 15px;
      width: 20px;
      text-align: center;
    }

    .logout-text {
      opacity: 0;
      transform: translateX(-10px);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .sidebar:hover .logout-text {
      opacity: 1;
      transform: translateX(0);
    }

    @media (max-width: 1200px) {
      .pillar-container {
        justify-content: center;
      }
    }

    @media (max-width: 992px) {
      :root {
        --sidebar-width: 0px;
      }

      .sidebar {
        width: 0;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        z-index: 1001;
      }

      .sidebar.expanded {
        width: var(--sidebar-expanded);
      }

      .main, .dashboard-header {
        margin-left: 0;
        width: 100%;
      }

      .sidebar-toggle {
        display: block;
      }

      .header-left {
        flex: 1;
      }

      .header-title {
        font-size: 16px;
      }

      .header-subtitle {
        font-size: 11px;
      }

      .profile-name {
        max-width: 100px;
      }

      .notification-dropdown {
        right: -50px;
      }
    }

    @media (max-width: 768px) {
      .date-display {
        display: none;
      }

      .header-right {
        gap: 8px;
      }

      .profile-name {
        display: none;
      }

      .notification-dropdown {
        width: 280px;
        right: -10px;
      }
    }

    @media (max-width: 576px) {
      .notification-dropdown {
        width: 250px;
        right: -70px;
      }
    }

    /* Smooth transition untuk semua elemen */
    * {
      transition-property: background-color, color, border-color, box-shadow;
      transition-duration: var(--transition-speed);
      transition-timing-function: ease;
    }

    /* Styling untuk tanggal dan hari libur */
    .holiday-text {
      color: #ff6b6b !important;
      font-weight: 600;
    }

    .weekend-text {
      color: #ff9f43 !important;
      font-weight: 600;
    }

    .holiday-badge {
      display: inline-block;
      font-size: 10px;
      background: rgba(255, 107, 107, 0.2);
      color: #ff6b6b;
      padding: 2px 6px;
      border-radius: 8px;
      margin-left: 8px;
      font-weight: 600;
      border: 1px solid rgba(255, 107, 107, 0.3);
    }

    .weekend-badge {
      display: inline-block;
      font-size: 10px;
      background: rgba(255, 159, 67, 0.2);
      color: #ff9f43;
      padding: 2px 6px;
      border-radius: 8px;
      margin-left: 8px;
      font-weight: 600;
      border: 1px solid rgba(255, 159, 67, 0.3);
    }

    .date-tooltip {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      background: var(--pln-surface);
      border-radius: 8px;
      padding: 12px;
      min-width: 200px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
      border: 1px solid var(--pln-border);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .date-display.show-tooltip .date-tooltip {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .date-tooltip:before {
      content: '';
      position: absolute;
      top: -6px;
      right: 20px;
      width: 12px;
      height: 12px;
      background: var(--pln-surface);
      transform: rotate(45deg);
      border-top: 1px solid var(--pln-border);
      border-left: 1px solid var(--pln-border);
    }

    .tooltip-title {
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--pln-light-blue);
      font-size: 14px;
    }

    .tooltip-info {
      font-size: 12px;
      color: var(--pln-text-secondary);
      margin-bottom: 5px;
    }

    /* Badge notifikasi - Improved */
    .notification-badge {
      display: none;
      position: absolute;
      top: 6px;
      right: 8px;
      background: linear-gradient(135deg, #e74c3c, #ff6b6b);
      color: white;
      font-size: 0.65rem;
      min-width: 20px;
      height: 20px;
      border-radius: 50px;
      text-align: center;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      padding: 0 6px;
      box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.3);
      transform-origin: center center;
      z-index: 5;
    }

    /* Badge notifikasi untuk menu dropdown */
    .notification-badge-menu {
      display: none;
      background: linear-gradient(135deg, #e74c3c, #ff6b6b);
      color: white;
      font-size: 0.65rem;
      min-width: 20px;
      height: 20px;
      border-radius: 50px;
      text-align: center;
      line-height: 20px;
      font-weight: bold;
      padding: 0 6px;
      box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.3);
      margin-left: auto;
    }

    /* User Profile Menu */
    .user-profile-menu {
      position: relative;
      margin-right: 15px;
    }

    .profile-trigger {
      display: flex;
      align-items: center;
      cursor: pointer;
      padding: 8px 15px;
      border-radius: 30px;
      background: rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s ease;
      position: relative;
    }

    .profile-trigger:hover {
      background: rgba(0, 0, 0, 0.3);
    }

    .profile-img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .profile-icon {
      width: 30px;
      height: 30px;
      background: var(--pln-blue);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 14px;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .profile-name {
      margin: 0 10px;
      font-size: 14px;
      color: white;
      font-weight: 500;
      max-width: 150px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .profile-trigger i.fa-chevron-down {
      font-size: 10px;
      color: rgba(255, 255, 255, 0.7);
      transition: transform 0.3s ease;
    }

    .profile-menu {
      position: absolute;
      top: calc(100% + 15px);
      right: 0;
      width: 240px;
      background: var(--pln-surface);
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
      border: 1px solid var(--pln-border);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 1000;
      overflow: hidden;
    }

    /* Tampilkan menu saat hover pada profil */
    .user-profile-menu:hover .profile-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    /* Tampilkan tanda panah saat hover */
    .user-profile-menu:hover .profile-trigger i.fa-chevron-down {
      transform: rotate(180deg);
    }

    .profile-menu.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .profile-menu-header {
      padding: 15px;
      border-bottom: 1px solid var(--pln-border);
      background: rgba(0, 0, 0, 0.05);
    }

    .profile-title {
      margin: 0;
      font-weight: 600;
      font-size: 14px;
      color: var(--pln-text);
    }

    .profile-subtitle {
      margin: 5px 0 0;
      font-size: 12px;
      color: var(--pln-text-secondary);
    }

    .profile-menu-items {
      padding: 10px 0;
    }

    .profile-menu-item {
      display: flex;
      align-items: center;
      padding: 10px 15px;
      color: var(--pln-text);
      transition: all 0.3s ease;
      text-decoration: none;
      font-size: 14px;
    }

    .profile-menu-item:hover {
      background: rgba(0, 0, 0, 0.05);
      color: var(--pln-light-blue);
    }

    .profile-menu-item i {
      margin-right: 10px;
      font-size: 16px;
      width: 20px;
      text-align: center;
      color: var(--pln-text-secondary);
    }

    .profile-menu-item:hover i {
      color: var(--pln-light-blue);
    }

    .divider {
      height: 1px;
      background: var(--pln-border);
      margin: 8px 0;
    }

    .logout-btn-menu {
      width: 100%;
      text-align: left;
      background: none;
      border: none;
      cursor: pointer;
      color: var(--pln-text);
      font-size: 14px;
    }

    .logout-btn-menu:hover {
      color: #e74c3c;
    }

    .logout-btn-menu:hover i {
      color: #e74c3c;
    }

    /* Animasi badge - Enhanced */
    @keyframes pulse {
      0% { transform: scale(1); box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4); }
      50% { transform: scale(1.2); box-shadow: 0 2px 12px rgba(231, 76, 60, 0.7); }
      100% { transform: scale(1); box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4); }
    }

    .notification-badge:not(:empty) {
      animation: pulse 1.5s infinite;
    }

    /* Hover effect for notification menu item */
    .sidebar-menu a:hover .notification-badge {
      background: linear-gradient(135deg, #ff6b6b, #e74c3c);
    }

    /* Animasi Logout Modern */
    @keyframes fadeOutScale {
      0% {
        opacity: 1;
        transform: scale(1);
      }
      70% {
        opacity: 0.7;
        transform: scale(1.05);
      }
      100% {
        opacity: 0;
        transform: scale(0.95);
      }
    }

    @keyframes spinFade {
      0% {
        transform: rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: rotate(180deg);
        opacity: 0;
      }
    }

    .logout-animation {
      animation: fadeOutScale 0.5s ease forwards;
    }

    .logout-icon-animation {
      display: inline-block;
      animation: spinFade 0.5s ease forwards;
    }

    /* Overlay saat logout */
    .logout-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      z-index: 9999;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .logout-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .logout-message {
      color: white;
      font-size: 1.5rem;
      margin-top: 20px;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s ease;
    }

    .logout-overlay.active .logout-message {
      opacity: 1;
      transform: translateY(0);
    }

    .logout-spinner {
      width: 60px;
      height: 60px;
      border: 4px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top: 4px solid var(--pln-light-blue);
      animation: spin 1s linear infinite;
      opacity: 0;
      transform: scale(0.7);
      transition: all 0.5s ease;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .logout-overlay.active .logout-spinner {
      opacity: 1;
      transform: scale(1);
    }

    /* Modal Profil Styles */
    .profile-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      z-index: 9999;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      display: none; /* Diatur melalui JS */
    }

    .profile-modal.active {
      opacity: 1;
      visibility: visible;
    }

    .profile-modal-content {
      width: 90%;
      max-width: 600px;
      background: var(--pln-surface);
      border-radius: 16px;
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      transform: translateY(20px) scale(0.95);
      transition: all 0.3s ease;
      border: 1px solid var(--pln-border);
    }

    .profile-modal.active .profile-modal-content {
      transform: translateY(0) scale(1);
    }

    .profile-modal-header {
      padding: 20px 25px;
      background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--pln-border);
      position: relative;
      overflow: hidden;
    }

    .profile-modal-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.2), transparent 70%);
      z-index: 1;
    }

    .profile-modal-title {
      color: white;
      font-size: 1.4rem;
      font-weight: 600;
      margin: 0;
      position: relative;
      z-index: 2;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .profile-modal-close {
      background: rgba(0, 0, 0, 0.2);
      border: none;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      z-index: 2;
    }

    .profile-modal-close:hover {
      background: rgba(0, 0, 0, 0.3);
      transform: rotate(90deg);
    }

    .profile-modal-body {
      padding: 25px;
      max-height: 70vh;
      overflow-y: auto;
    }

    .profile-tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid var(--pln-border);
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .profile-tab {
      background: none;
      border: none;
      padding: 10px 15px;
      border-radius: 20px;
      color: var(--pln-text-secondary);
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      white-space: nowrap;
    }

    .profile-tab:hover {
      color: var(--pln-light-blue);
      background: rgba(0, 0, 0, 0.05);
    }

    .profile-tab.active {
      background: var(--pln-light-blue);
      color: white;
      box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }

    .profile-tab-content {
      display: none;
      animation: fadeIn 0.3s ease forwards;
    }

    .profile-tab-content.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 25px;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
      border: none;
      border-radius: 30px;
      padding: 10px 20px;
      font-weight: 600;
      color: white;
      box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .btn-primary i {
      margin-right: 8px;
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
    }

    .profile-photo-preview {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin: 0 auto 20px;
      overflow: hidden;
      border: 5px solid var(--pln-border);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      background: var(--pln-accent-bg);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .profile-photo-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-photo-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
      color: var(--pln-text-secondary);
      background: var(--pln-accent-bg);
    }

    .profile-photo-upload-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      margin-top: 20px;
    }

    .photo-upload-btn {
      background: var(--pln-light-blue);
      color: white;
      padding: 8px 15px;
      border-radius: 20px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
    }

    .photo-upload-btn:hover {
      background: var(--pln-blue);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .photo-input {
      display: none;
    }

    .photo-filename {
      font-size: 0.85rem;
      color: var(--pln-text-secondary);
    }

    .password-input-group {
      position: relative;
      display: flex;
      align-items: center;
    }

    .password-toggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--pln-text-secondary);
      cursor: pointer;
    }

    .password-strength {
      margin-top: 15px;
    }

    .strength-bar {
      height: 5px;
      background: rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      margin-bottom: 5px;
      overflow: hidden;
    }

    .strength-progress {
      height: 100%;
      width: 0;
      border-radius: 10px;
      transition: all 0.3s ease;
      background: linear-gradient(90deg, #dc3545, #ffc107, #28a745);
      background-size: 300% 100%;
    }

    .strength-text {
      font-size: 0.8rem;
      color: var(--pln-text-secondary);
    }

    @media (max-width: 576px) {
      .profile-modal-content {
        width: 95%;
      }

      .profile-tabs {
        gap: 5px;
      }

      .profile-tab {
        padding: 8px 12px;
        font-size: 0.9rem;
      }

      .profile-modal-body {
        padding: 15px;
      }
    }
  </style>
  @yield('styles')
</head>
<body data-theme="dark">
  <div class="container-fluid">
    <!-- Sidebar yang lebih modern -->
    <div class="sidebar">
      <div class="sidebar-logo">
        <img src="/images/logoPLN.jpg" alt="Logo PLN" class="logo-pln">
        <div class="logo-text">
          <h1 class="logo-title">PLN</h1>
          <p class="logo-subtitle">Mandau Cipta Tenaga Nusantara</p>
        </div>
      </div>

      <ul class="sidebar-menu">
        <li>
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') || request()->routeIs('dashboard.*') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt icon"></i>
            <span class="menu-text">Dashboard</span>
          </a>
        </li>

  {{-- Menu untuk Master Admin (Asisten Manajer) --}}
        @if(Auth::user()->role == 'asisten_manager')
        <li>
          <a href="{{route('dataKinerja.index')}}" class="{{ request()->routeIs('dataKinerja.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar icon"></i>
            <span class="menu-text">Data Kinerja</span>
          </a>
        </li>
        <li>
          <a href="{{route('akun.index')}}" class="{{ request()->routeIs('akun.*') ? 'active' : '' }}">
            <i class="fas fa-users icon"></i>
            <span class="menu-text">Data Akun</span>
          </a>
        </li>
        <li>
          <a href="{{route('verifikasi.index')}}" class="{{ request()->routeIs('verifikasi.*') ? 'active' : '' }}">
            <i class="fas fa-check-circle icon"></i>
            <span class="menu-text">Verifikasi</span>
          </a>
        </li>
        <li>
          <a href="{{route('tahunPenilaian.index')}}" class="{{ request()->routeIs('tahunPenilaian.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt icon"></i>
            <span class="menu-text">Tahun Penilaian</span>
          </a>
        </li>

        <li>
          <a href="{{route('targetKinerja.index')}}" class="{{ request()->routeIs('targetKinerja.*') ? 'active' : '' }}">
            <i class="fas fa-bullseye icon"></i>
            <span class="menu-text">Target Kinerja</span>
          </a>
        </li>
        <li>
          <a href="{{ route('realisasi.index') }}" class="{{ request()->routeIs('realisasi.*') ? 'active' : '' }}">
            <i class="fas fa-tasks icon"></i>
            <span class="menu-text">Realisasi</span>
          </a>
        </li>
        <li>
          <a href="{{route('aktivitasLog.index')}}" class="{{ request()->routeIs('aktivitasLog.*') ? 'active' : '' }}">
            <i class="fas fa-history icon"></i>
            <span class="menu-text">Log Aktivitas</span>
          </a>
        </li>
        @endif

     {{-- Menu untuk Admin (PIC Bidang) --}}
        @if(Str::startsWith(Auth::user()->role, 'pic_'))
        <li>
          <a href="{{route('dataKinerja.index')}}" class="{{ request()->routeIs('dataKinerja.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar icon"></i>
            <span class="menu-text">Data Kinerja</span>
          </a>
        </li>
        <li>
          <a href="{{ route('realisasi.index') }}" class="{{ request()->routeIs('realisasi.*') ? 'active' : '' }}">
            <i class="fas fa-tasks icon"></i>
            <span class="menu-text">Realisasi</span>
          </a>
        </li>
        <li>
          <a href="#" class="{{ request()->routeIs('kpi.index') ? 'active' : '' }}">
            <i class="fas fa-chart-line icon"></i>
            <span class="menu-text">Laporan KPI</span>
          </a>
        </li>

        @endif

        {{-- Menu untuk semua user --}}

        <li>
          <a href="{{ route('eksporPdf.index') }}" class="{{ request()->routeIs('eksporPdf.*') ? 'active' : '' }}">
            <i class="fas fa-file-pdf icon"></i>
            <span class="menu-text">Ekspor PDF</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Header yang lebih modern -->
    <div class="dashboard-header">
      <div class="header-text">
        <h1 class="header-title">@yield('page_title', 'Dashboard PLN')</h1>
        <p class="header-subtitle">PT PLN MANDAU CIPTA TENAGA NUSANTARA</p>
      </div>

      <div class="header-right">
        <!-- Tombol notifikasi -->
        <div class="topbar-icon-btn notification-btn" id="notificationBtn">
          <i class="fas fa-bell"></i>
          @if(Auth::check() && Auth::user()->role === 'asisten_manager')
            @php
              $unverifiedCount = App\Models\Realisasi::where('diverifikasi', false)->count();
            @endphp
            @if($unverifiedCount > 0)
              <span class="notification-badge">{{ $unverifiedCount }}</span>
            @endif
          @endif

          @if(Auth::check() && Auth::user()->role === 'asisten_manager')
            @php
              $unapprovedCount = App\Models\TargetKPI::where('disetujui', false)->count();
            @endphp
            @if($unapprovedCount > 0)
              <span class="notification-badge-2">{{ $unapprovedCount }}</span>
            @endif
          @endif
        </div>

        <!-- Tanggal & jam -->
        <div class="date-display" id="date-display">
          <i class="far fa-calendar-alt"></i>
          <span>
            @php
              // Set lokasi waktu ke Indonesia/Jakarta
              date_default_timezone_set('Asia/Jakarta');

              // Array untuk konversi nama hari dan bulan ke Bahasa Indonesia
              $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
              $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

              // Format waktu dalam Bahasa Indonesia
              $nama_hari = $hari[date('w')];
              $nama_bulan = $bulan[date('n')-1];
              $tanggal = date('j');
              $tahun = date('Y');

              // Deteksi hari libur nasional (contoh sederhana)
              $hari_libur = [
                // Hari Libur Nasional 2023
                '01-01' => 'Tahun Baru',
                '22-01' => 'Tahun Baru Imlek',
                '18-02' => 'Isra Miraj',
                '22-03' => 'Nyepi',
                '07-04' => 'Wafat Isa Almasih',
                '22-04' => 'Idul Fitri',
                '23-04' => 'Idul Fitri',
                '01-05' => 'Hari Buruh',
                '18-05' => 'Kenaikan Isa Almasih',
                '01-06' => 'Hari Lahir Pancasila',
                '04-06' => 'Waisak',
                '29-06' => 'Idul Adha',
                '19-07' => 'Tahun Baru Hijriah',
                '17-08' => 'HUT RI',
                '28-09' => 'Maulid Nabi',
                '25-12' => 'Hari Natal',

                // Hari Libur Nasional 2024
                '01-01-2024' => 'Tahun Baru 2024',
                '10-02-2024' => 'Tahun Baru Imlek',
                '07-03-2024' => 'Isra Miraj',
                '11-03-2024' => 'Nyepi',
                '29-03-2024' => 'Wafat Isa Almasih',
                '10-04-2024' => 'Idul Fitri',
                '11-04-2024' => 'Idul Fitri',
                '01-05-2024' => 'Hari Buruh',
                '09-05-2024' => 'Kenaikan Isa Almasih',
                '01-06-2024' => 'Hari Lahir Pancasila',
                '15-06-2024' => 'Waisak',
                '17-06-2024' => 'Idul Adha',
                '07-07-2024' => 'Tahun Baru Hijriah',
                '17-08-2024' => 'HUT RI',
                '16-09-2024' => 'Maulid Nabi',
                '25-12-2024' => 'Hari Natal',
              ];

              $tanggal_sekarang = date('d-m');
              $tanggal_sekarang_tahun = date('d-m-Y');
              $day_num = date('w'); // 0 = Minggu, 6 = Sabtu

              // Cek hari libur baik dengan atau tanpa tahun
              $is_libur = isset($hari_libur[$tanggal_sekarang]) ||
                         isset($hari_libur[$tanggal_sekarang_tahun]) ||
                         $day_num == 0; // Minggu

              $is_weekend = $day_num == 0 || $day_num == 6; // Sabtu atau Minggu

              $nama_libur = isset($hari_libur[$tanggal_sekarang]) ? $hari_libur[$tanggal_sekarang] :
                           (isset($hari_libur[$tanggal_sekarang_tahun]) ? $hari_libur[$tanggal_sekarang_tahun] : '');

              $text_color = $is_libur ? 'holiday-text' : ($is_weekend ? 'weekend-text' : '');
            @endphp

            <span class="date-info {{ $text_color }}">{{ $nama_hari }}, {{ $tanggal }} {{ $nama_bulan }} {{ $tahun }}
              @if($nama_libur)
                <span class="holiday-badge">{{ $nama_libur }}</span>
              @elseif($day_num == 0)
                <span class="holiday-badge">Hari Minggu</span>
              @elseif($day_num == 6)
                <span class="weekend-badge">Akhir Pekan</span>
              @endif
            </span>
          </span>

          <div class="date-tooltip">
            <div class="tooltip-title">Informasi Tanggal</div>
            <div class="tooltip-info">Hari ke-{{ date('z')+1 }} dari {{ date('L') ? '366' : '365' }} hari</div>
            <div class="tooltip-info">Minggu ke-{{ date('W') }} tahun {{ $tahun }}</div>
            <div class="tooltip-info">{{ date('t') }} hari dalam bulan ini</div>
            <div class="tooltip-info">{{ date('L') ? 'Tahun Kabisat' : 'Bukan Tahun Kabisat' }}</div>
          </div>
        </div>

        <!-- Menu profil -->
        <div class="user-profile-menu">
          <div class="profile-trigger" onclick="toggleProfileMenu()">
            @if(Auth::user()->profile_photo)
              <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="profile-img">
            @else
              <div class="profile-icon">
                <i class="fas fa-user"></i>
              </div>
            @endif
            <span class="profile-name">{{ Auth::user()->name }}</span>
            <i class="fas fa-chevron-down"></i>
            <span class="notification-badge" id="notification-count"></span>
          </div>
          <div class="profile-menu" id="profile-menu">
            <div class="profile-menu-header">
              <div class="profile-info">
                <h6 class="profile-title">{{ Auth::user()->name }}</h6>
                <p class="profile-subtitle">{{ Auth::user()->email }}</p>
              </div>
            </div>
            <div class="profile-menu-items">
              <a href="#" class="profile-menu-item" onclick="openProfileModal(event)">
                <i class="fas fa-user-edit"></i> Edit Profil
              </a>
              <div class="divider"></div>
              <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="profile-menu-item logout-btn-menu">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
        <!-- Dropdown notifikasi -->
        <div class="notification-dropdown" id="notificationDropdown">
            <div class="notification-header">
            <h5>Notifikasi</h5>
            <button class="close-btn" id="closeNotification"><i class="fas fa-times"></i></button>
            </div>
            <div class="notification-body">
            @if(Auth::check() && Auth::user()->role === 'asisten_manager')
                @php
                $unverifiedItems = App\Models\Realisasi::with(['indikator', 'user'])
                    ->where('diverifikasi', false)
                    ->latest()
                    ->take(5)
                    ->get();

                $unapprovedItems = App\Models\TargetKPI::with(['indikator', 'user'])
                    ->where('disetujui', false)
                    ->latest()
                    ->take(5)
                    ->get();
                @endphp

                @if($unverifiedItems->count() > 0)
                <div class="notification-section">
                    <h6>Realisasi yang Perlu Diverifikasi</h6>
                    @foreach($unverifiedItems as $item)
                    <a href="{{ route('verifikasi.show', $item->id) }}" class="notification-item">
                        <div class="notification-icon bg-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                        <p class="notification-title">{{ $item->indikator->kode }} - {{ $item->indikator->nama }}</p>
                        <p class="notification-info">Diinput oleh: {{ $item->user->name }}</p>
                        <p class="notification-time">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                    @endforeach
                    @if($unverifiedCount > 5)
                    <a href="{{ route('verifikasi.index') }}" class="notification-more">Lihat {{ $unverifiedCount - 5 }} lainnya</a>
                    @endif
                </div>
                @endif

                @if($unapprovedItems->count() > 0)
                <div class="notification-section">
                    <h6>Target yang Perlu Disetujui</h6>
                    @foreach($unapprovedItems as $item)
                    <a href="{{ route('targetKinerja.index') }}" class="notification-item">
                        <div class="notification-icon bg-info">
                        <i class="fas fa-bullseye"></i>
                        </div>
                        <div class="notification-content">
                        <p class="notification-title">{{ $item->indikator->kode }} - {{ $item->indikator->nama }}</p>
                        <p class="notification-info">Diinput oleh: {{ $item->user->name }}</p>
                        <p class="notification-time">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                    @endforeach
                    @if($unapprovedCount > 5)
                    <a href="{{ route('targetKinerja.index') }}" class="notification-more">Lihat {{ $unapprovedCount - 5 }} lainnya</a>
                    @endif
                </div>
                @endif

                @if($unverifiedItems->count() === 0 && $unapprovedItems->count() === 0)
                <div class="notification-empty">
                    <i class="fas fa-check-circle"></i>
                    <p>Tidak ada notifikasi baru</p>
                </div>
                @endif
            @else
                <div class="notification-empty">
                <i class="fas fa-bell-slash"></i>
                <p>Tidak ada notifikasi baru</p>
                </div>
            @endif
            </div>
        </div>
    <main class="main">
      @yield('content')
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

  <!-- Overlay untuk animasi logout -->
  <div class="logout-overlay" id="logoutOverlay">
    <div class="logout-spinner"></div>
    <div class="logout-message">Keluar Dari Sistem...</div>
  </div>

  <!-- Modal Edit Profil -->
  <div class="profile-modal" id="profileModal">
    <div class="profile-modal-content">
      <div class="profile-modal-header">
        <h5 class="profile-modal-title">Edit Profil</h5>
        <button type="button" class="profile-modal-close" id="closeProfileModal" onclick="closeProfileModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="profile-modal-body">
        <div class="profile-tabs">
          <button class="profile-tab active" data-tab="info">Informasi Dasar</button>
          <button class="profile-tab" data-tab="photo">Foto Profil</button>
          <button class="profile-tab" data-tab="password">Ubah Password</button>
        </div>

        <div class="profile-tab-content active" id="tab-info">
          <form id="updateProfileForm" action="/profile" method="POST">
            @csrf
            <input type="hidden" name="update_type" value="profile">

            <div class="form-group">
              <label for="name" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
            </div>

            <div class="form-group">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
            </div>


            <div class="form-actions">
              <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
              </button>
            </div>
          </form>
        </div>

        <div class="profile-tab-content" id="tab-photo">
          <form id="updatePhotoForm" action="/profile/photo" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="profile-photo-preview">
              @if(Auth::user()->profile_photo)
                <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" id="photoPreview">
              @else
                <div class="profile-photo-placeholder">
                  <i class="fas fa-user"></i>
                </div>
              @endif
            </div>

            <div class="profile-photo-upload-container">
              <label for="profile_photo" class="photo-upload-btn">
                <i class="fas fa-camera"></i> Pilih Foto
              </label>
              <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="photo-input">
              <span class="photo-filename" id="photoFilename">Tidak ada file yang dipilih</span>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn-primary" id="uploadPhotoBtn" disabled>
                <i class="fas fa-upload"></i> Upload Foto
              </button>
            </div>
          </form>
        </div>

        <div class="profile-tab-content" id="tab-password">
          <form id="updatePasswordForm" action="/profile" method="POST">
            @csrf
            <input type="hidden" name="update_type" value="password">

            <!-- Tampilkan pesan sukses yang lebih menonjol -->
            @if(session('success'))
            <div class="alert alert-success mb-4" style="background: linear-gradient(135deg, #28a745, #5cb85c); color: white; border-radius: 10px; padding: 15px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);">
              <div class="d-flex align-items-center mb-2">
                <i class="fas fa-check-circle mr-2" style="font-size: 20px;"></i>
                <strong>{{ session('success') }}</strong>
              </div>
              <p class="mb-0" style="font-size: 14px;">
                Untuk menggunakan password baru Anda, silakan:
                <ol class="mt-2 mb-0" style="padding-left: 20px;">
                  <li>Klik Logout di menu profil</li>
                  <li>Login kembali dengan password baru Anda</li>
                </ol>
              </p>
            </div>
            @endif

            <!-- Success message yang akan ditampilkan via JavaScript -->
            <div id="manual-success-message" style="display:none;" class="alert alert-success mb-4" style="background: linear-gradient(135deg, #28a745, #5cb85c); color: white; border-radius: 10px; padding: 15px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);">
              <div class="d-flex align-items-center mb-2">
                <i class="fas fa-check-circle mr-2" style="font-size: 20px;"></i>
                <strong>Password berhasil diperbarui!</strong>
              </div>
              <p class="mb-0" style="font-size: 14px;">
                Untuk menggunakan password baru Anda, silakan:
                <ol class="mt-2 mb-0" style="padding-left: 20px;">
                  <li>Klik Logout di menu profil</li>
                  <li>Login kembali dengan password baru Anda</li>
                </ol>
              </p>
            </div>

            <!-- Tampilkan error jika ada -->
            @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-group">
              <label for="password" class="form-label">Password Baru</label>
              <div class="password-input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <button type="button" class="password-toggle">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="form-group">
              <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
              <div class="password-input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                <button type="button" class="password-toggle">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="password-strength">
              <div class="strength-bar">
                <div class="strength-progress" id="passwordStrength"></div>
              </div>
              <span class="strength-text" id="strengthText">Belum diisi</span>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn-primary">
                <i class="fas fa-lock"></i> Perbarui Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Live clock script yang lebih baik -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded');

    const editProfileBtn = document.getElementById('editProfileBtn');
    const profileModal = document.getElementById('profileModal');

    if (editProfileBtn) {
      editProfileBtn.addEventListener('click', function (e) {
        e.preventDefault();
        if (profileModal) {
          profileModal.style.display = 'flex';
          profileModal.style.justifyContent = 'center';
          profileModal.style.alignItems = 'center';
          profileModal.classList.add('active');
          document.body.style.overflow = 'hidden';
        }
      });
    }

    const dateDisplay = document.getElementById('date-display');
    if (dateDisplay) {
      dateDisplay.addEventListener('click', function () {
        this.classList.toggle('show-tooltip');
      });

      document.addEventListener('click', function (event) {
        if (!dateDisplay.contains(event.target)) {
          dateDisplay.classList.remove('show-tooltip');
        }
      });
    }

    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;
    const currentTheme = localStorage.getItem('theme') || 'dark';
    body.setAttribute('data-theme', currentTheme);

    if (currentTheme === 'light') {
      themeToggle.checked = true;
    }

    themeToggle.addEventListener('change', function () {
      const newTheme = this.checked ? 'light' : 'dark';
      body.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
    });

    const logoutForm = document.querySelector('.logout-form');
    const logoutButton = document.querySelector('.logout-btn-menu');
    const logoutOverlay = document.getElementById('logoutOverlay');

    if (logoutForm && logoutButton) {
      logoutForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const logoutIcon = logoutButton.querySelector('i');
        logoutIcon.classList.add('logout-icon-animation');
        logoutButton.classList.add('logout-animation');

        const profileMenu = document.getElementById('profile-menu');
        if (profileMenu) {
          profileMenu.style.opacity = '0';
          profileMenu.style.visibility = 'hidden';
        }

        setTimeout(function () {
          logoutOverlay.classList.add('active');
          setTimeout(function () {
            logoutForm.submit();
          }, 1500);
        }, 300);
      });
    }

    const closeProfileModal = document.getElementById('closeProfileModal');
    if (closeProfileModal && profileModal) {
      closeProfileModal.addEventListener('click', function () {
        profileModal.classList.remove('active');
        setTimeout(() => profileModal.style.display = '', 300);
        document.body.style.overflow = '';
      });

      profileModal.addEventListener('click', function (e) {
        if (e.target === profileModal) {
          profileModal.classList.remove('active');
          setTimeout(() => profileModal.style.display = '', 300);
          document.body.style.overflow = '';
        }
      });
    }

    // Perbaikan: Tab bisa dipilih dengan klik area manapun (termasuk ikon/foto)
    const profileTabs = document.querySelectorAll('.profile-tab');
    const tabContents = document.querySelectorAll('.profile-tab-content');

    if (profileTabs.length && tabContents.length) {
      profileTabs.forEach(tab => {
        tab.addEventListener('click', function (e) {
          e.preventDefault();
          profileTabs.forEach(t => t.classList.remove('active'));
          this.classList.add('active');

          tabContents.forEach(content => content.classList.remove('active'));
          const tabId = 'tab-' + this.getAttribute('data-tab');
          const tabContent = document.getElementById(tabId);
          if (tabContent) tabContent.classList.add('active');
        });
      });
    }

    const photoInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoFilename = document.getElementById('photoFilename');
    const uploadPhotoBtn = document.getElementById('uploadPhotoBtn');

    if (photoInput) {
      photoInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
          const file = this.files[0];
          const reader = new FileReader();

          photoFilename.textContent = file.name;
          if (uploadPhotoBtn) uploadPhotoBtn.disabled = false;

          reader.onload = function (e) {
            if (photoPreview) {
              if (photoPreview.tagName === 'IMG') {
                photoPreview.src = e.target.result;
              } else {
                const photoPlaceholder = document.querySelector('.profile-photo-placeholder');
                if (photoPlaceholder) {
                  const photoContainer = photoPlaceholder.parentElement;
                  photoPlaceholder.remove();

                  const img = document.createElement('img');
                  img.src = e.target.result;
                  img.id = 'photoPreview';
                  img.alt = 'Preview';
                  photoContainer.appendChild(img);
                }
              }
            }
          };

          reader.readAsDataURL(file);
        }
      });
    }

    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordStrength = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');

    if (passwordInput && passwordStrength && strengthText) {
      passwordInput.addEventListener('input', function () {
        const password = this.value;
        let strength = 0;
        let status = '';

        if (password.length > 0) {
          if (password.length >= 8) strength += 25;
          if (password.match(/[a-z]/)) strength += 25;
          if (password.match(/[A-Z]/)) strength += 25;
          if (password.match(/[0-9]/) || password.match(/[^a-zA-Z0-9]/)) strength += 25;

          if (strength <= 25) {
            status = 'Lemah';
            passwordStrength.style.width = '25%';
            passwordStrength.style.backgroundPosition = '0% 0%';
          } else if (strength <= 50) {
            status = 'Sedang';
            passwordStrength.style.width = '50%';
            passwordStrength.style.backgroundPosition = '50% 0%';
          } else if (strength <= 75) {
            status = 'Kuat';
            passwordStrength.style.width = '75%';
            passwordStrength.style.backgroundPosition = '75% 0%';
          } else {
            status = 'Sangat Kuat';
            passwordStrength.style.width = '100%';
            passwordStrength.style.backgroundPosition = '100% 0%';
          }
        } else {
          status = 'Belum diisi';
          passwordStrength.style.width = '0%';
        }

        strengthText.textContent = status;
      });
    }

    const passwordToggles = document.querySelectorAll('.password-toggle');

    if (passwordToggles.length) {
      passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
          const input = this.parentElement.querySelector('input');
          const icon = this.querySelector('i');

          if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
          } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
          }
        });
      });
    }
  });
</script>


  <!-- Skrip khusus untuk fungsi modal profil -->
  <script>
    // Fungsi untuk toggle menu profil
    function toggleProfileMenu() {
      const profileMenu = document.getElementById('profile-menu');
      if (profileMenu.style.opacity === '1') {
        profileMenu.style.opacity = '0';
        profileMenu.style.visibility = 'hidden';
        profileMenu.style.transform = 'translateY(-10px)';
      } else {
        profileMenu.style.opacity = '1';
        profileMenu.style.visibility = 'visible';
        profileMenu.style.transform = 'translateY(0)';
      }
    }

    // Fungsi untuk membuka modal profil
    function openProfileModal(e) {
      e.preventDefault();
      const profileModal = document.getElementById('profileModal');

      // Tutup dropdown profil
      const profileMenu = document.getElementById('profile-menu');
      profileMenu.style.opacity = '0';
      profileMenu.style.visibility = 'hidden';

      // Tampilkan modal
      profileModal.style.display = 'flex';
      profileModal.style.justifyContent = 'center';
      profileModal.style.alignItems = 'center';
      profileModal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    // Fungsi untuk menutup modal profil
    function closeProfileModal() {
      const profileModal = document.getElementById('profileModal');
      profileModal.classList.remove('active');
      setTimeout(function() {
        profileModal.style.display = 'none';
      }, 300);
      document.body.style.overflow = '';
    }

    // Menambahkan event click untuk area modal
    document.addEventListener('DOMContentLoaded', function() {
      const profileModal = document.getElementById('profileModal');

      if (profileModal) {
        profileModal.addEventListener('click', function(e) {
          if (e.target === this) {
            closeProfileModal();
          }
        });
      }
    });
  </script>



  <!-- Script untuk alert password -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Cari elemen penting
      const passwordForm = document.getElementById('updatePasswordForm');
      const manualSuccessMsg = document.getElementById('manual-success-message');
      const profileTabs = document.querySelectorAll('.profile-tab');
      const passwordTab = document.querySelector('.profile-tab[data-tab="password"]');

      // Fungsi untuk mengaktifkan tab password
      function activatePasswordTab() {
        if (!passwordTab) return;

        // Aktifkan tab button
        profileTabs.forEach(tab => tab.classList.remove('active'));
        passwordTab.classList.add('active');

        // Aktifkan konten tab
        const tabContents = document.querySelectorAll('.profile-tab-content');
        tabContents.forEach(content => content.classList.remove('active'));
        document.getElementById('tab-password').classList.add('active');
      }

      // Cek jika form password disubmit
      if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
          // Simpan state form submission ke localStorage
          localStorage.setItem('password_form_submitted', 'true');
          localStorage.setItem('password_submit_time', Date.now());
        });
      }

      // Cek jika ada flag bahwa form telah disubmit sebelumnya
      const wasSubmitted = localStorage.getItem('password_form_submitted');
      const submitTime = localStorage.getItem('password_submit_time');
      const currentTime = Date.now();

      // Jika form baru saja disubmit (dalam 5 detik terakhir)
      if (wasSubmitted === 'true' && submitTime && (currentTime - submitTime < 5000)) {
        console.log('Form was recently submitted, showing manual success message');

        // Tampilkan pesan sukses manual
        if (manualSuccessMsg) {
          manualSuccessMsg.style.display = 'block';

          // Animasi pesan
          setTimeout(function() {
            manualSuccessMsg.style.transition = 'all 0.3s ease';
            manualSuccessMsg.style.transform = 'scale(1.03)';
            setTimeout(function() {
              manualSuccessMsg.style.transform = 'scale(1)';
            }, 300);
          }, 500);
        }

        // Aktifkan tab password
        activatePasswordTab();

        // Hapus flag agar tidak muncul lagi di refresh berikutnya
        localStorage.removeItem('password_form_submitted');
        localStorage.removeItem('password_submit_time');
      }

      // Cek jika ada success message dari session
      const sessionSuccessMsg = document.querySelector('.profile-tab-content .alert-success:not(#manual-success-message)');
      if (sessionSuccessMsg) {
        console.log('Session success message found, highlighting tab');
        activatePasswordTab();

        // Animasi pesan
        setTimeout(function() {
          sessionSuccessMsg.style.transition = 'all 0.3s ease';
          sessionSuccessMsg.style.transform = 'scale(1.03)';
          setTimeout(function() {
            sessionSuccessMsg.style.transform = 'scale(1)';
          }, 300);
        }, 500);
      }
    });
  </script>






  <script>

    document.addEventListener('DOMContentLoaded', function() {
      // Notifikasi dropdown
      const notificationBtn = document.getElementById('notificationBtn');
      const notificationDropdown = document.getElementById('notificationDropdown');
      const closeNotification = document.getElementById('closeNotification');

      if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          notificationDropdown.classList.toggle('show');
        });

        if (closeNotification) {
          closeNotification.addEventListener('click', function() {
            notificationDropdown.classList.remove('show');
          });
        }

        // Klik di luar dropdown untuk menutup
        document.addEventListener('click', function(e) {
          if (!notificationDropdown.contains(e.target) && e.target !== notificationBtn) {
            notificationDropdown.classList.remove('show');
          }
        });
      }
    });
  </script>

  @yield('scripts')
</body>
</html>
