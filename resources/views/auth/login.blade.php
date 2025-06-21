<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Dashboard Kinerja PLN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --pln-blue: #0057a7;
            --pln-light-blue: #009bd4;
            --pln-yellow: #fce700;
            --pln-red: #e40613;
            --pln-gradient: linear-gradient(135deg, var(--pln-blue), var(--pln-light-blue));
            --pln-shadow: rgba(0, 87, 167, 0.2);
            --pln-text: #333;
            --pln-text-light: #6c757d;
        }

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f8f9fa
        }

        body {
            background-image: url("{{ asset('images/bg.jpeg') }}");
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(0, 87, 167, 0.7), rgba(0, 155, 212, 0.9));
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 900px;
            display: flex;
            align-items: stretch;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
            height: 550px;
            margin: 20px;
            background: white;
        }

        .login-image {
            flex: 1;
            background-image: url("{{ asset('images/bg.jpeg') }}");
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            color: white;
        }

        .login-image::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(to top, rgba(0, 87, 167, 0.9), rgba(0, 155, 212, 0.5));
            z-index: 0;
        }

        .login-image-content {
            position: relative;
            z-index: 1;
        }

        .login-image h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .login-image p {
            font-size: 1.05rem;
            line-height: 1.6;
            opacity: 0.9;
            max-width: 80%;
        }

        .login-form {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .logo-container .pln-logo {
            background-color: var(--pln-yellow);
            width: 70px;
            height: 70px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            padding: 6px;
            margin-bottom: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo-container .pln-logo:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .logo-container .pln-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title h2 {
            color: var(--pln-blue);
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-title p {
            color: var(--pln-text-light);
            font-size: 1rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--pln-text-light);
            transition: all 0.3s ease;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #e1e5eb;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--pln-light-blue);
            box-shadow: 0 0 0 3px rgba(0, 155, 212, 0.15);
            background-color: white;
        }

        .input-group input:focus + i {
            color: var(--pln-light-blue);
        }

        .login-button {
            background: var(--pln-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px var(--pln-shadow);
            margin-top: 15px;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px var(--pln-shadow);
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button .button-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-button .spinner {
            display: none;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s infinite linear;
        }

        .login-button.loading .spinner {
            display: inline-block;
        }

        .login-button.loading .button-text {
            margin-left: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert-error {
            background-color: #fff3f3;
            color: #e74c3c;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 500;
            border-left: 4px solid #e74c3c;
            display: flex;
            align-items: center;
        }

        .alert-error i {
            margin-right: 10px;
            font-size: 18px;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: var(--pln-text-light);
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
            }

            .login-image {
                display: none;
            }

            .login-form {
                padding: 40px 30px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-title, .input-group, .login-button, .alert-error, .footer-text {
            animation: fadeIn 0.6s ease forwards;
        }

        .login-title { animation-delay: 0.1s; }
        .alert-error { animation-delay: 0.2s; }
        .input-group:nth-child(1) { animation-delay: 0.3s; }
        .input-group:nth-child(2) { animation-delay: 0.4s; }
        .login-button { animation-delay: 0.5s; }
        .footer-text { animation-delay: 0.6s; }

        /* Page Transition Animation */
        .transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--pln-blue);
            z-index: 9999;
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .transition-overlay.active {
            transform: translateY(0);
        }

        .transition-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            width: 100%;
        }

        .transition-logo {
            background-color: var(--pln-yellow);
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin: 0 auto 20px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        .transition-logo img {
            width: 80%;
            height: 80%;
            object-fit: contain;
        }

        .loading-text {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .loading-bar {
            width: 200px;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            margin: 0 auto;
            position: relative;
        }

        .loading-bar::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0;
            background: white;
            border-radius: 10px;
            animation: loading 2s ease-in-out forwards;
        }

        @keyframes loading {
            0% { width: 0; }
            20% { width: 20%; }
            50% { width: 40%; }
            70% { width: 60%; }
            85% { width: 80%; }
            100% { width: 100%; }
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(252, 231, 0, 0.7); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(252, 231, 0, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(252, 231, 0, 0); }
        }

        /* Sparkle Animation */
        .sparkle {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: white;
            box-shadow: 0 0 10px 2px white;
            opacity: 0;
            animation: sparkle 2s infinite;
        }

        @keyframes sparkle {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1); opacity: 1; }
            100% { transform: scale(0); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <div class="login-image-content">
                <h1>Dashboard Kinerja</h1>
                <p>Sistem monitoring dan pengelolaan data kinerja terpadu PT PLN (Persero)</p>
            </div>
        </div>
        <div class="login-form">
            <div class="logo-container">
                <div class="pln-logo">
                    <img src="{{ asset('images/logoPLN.jpg') }}" alt="PLN Logo">
                </div>
            </div>

            <div class="login-title">
                <h2>Selamat Datang</h2>
                <p>Silahkan login untuk melanjutkan</p>
            </div>

            <!-- Menampilkan pesan error kalau login gagal -->
            @if(session('error'))
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="input-group">
                    <input type="text" name="email" placeholder="Email" required value="{{ old('email') }}">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class="fas fa-lock"></i>
                </div>
                <button type="submit" class="login-button" id="loginButton">
                    <div class="button-content">
                        <div class="spinner"></div>
                        <span class="button-text">Masuk</span>
                    </div>
                </button>
            </form>

            <div class="footer-text">
                &copy; {{ date('Y') }} PT PLN (Persero) - Dashboard Kinerja
            </div>
        </div>
    </div>

    <!-- Transition Overlay -->
    <div class="transition-overlay" id="transitionOverlay">
        <div class="transition-content">
            <div class="transition-logo">
                <img src="{{ asset('images/logoPLN.jpg') }}" alt="PLN Logo">
            </div>
            <div class="loading-text">Memuat Dashboard PLN...</div>
            <div class="loading-bar"></div>
        </div>
    </div>

    <!-- Sparkles for animation effect -->
    <div id="sparkleContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const transitionOverlay = document.getElementById('transitionOverlay');
            const sparkleContainer = document.getElementById('sparkleContainer');

            // Add sparkles
            function createSparkles() {
                // Create 15 sparkles with random positions
                for (let i = 0; i < 15; i++) {
                    const sparkle = document.createElement('div');
                    sparkle.classList.add('sparkle');
                    sparkle.style.left = Math.random() * 100 + 'vw';
                    sparkle.style.top = Math.random() * 100 + 'vh';
                    sparkle.style.animationDelay = Math.random() * 2 + 's';
                    sparkleContainer.appendChild(sparkle);
                }
            }

            createSparkles();

            loginForm.addEventListener('submit', function(e) {
                // Show loading state on button
                loginButton.classList.add('loading');

                // Show transition overlay
                transitionOverlay.classList.add('active');

                // Tidak perlu preventDefault() dan setTimeout() karena akan menyebabkan token CSRF kedaluwarsa
                // Form akan langsung di-submit secara normal
            });
        });
    </script>
</body>
</html>
