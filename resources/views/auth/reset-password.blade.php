<!doctype html>
<html lang="id">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ROSMO Admin | Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css') }}" />

    <style>
      body.login-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: linear-gradient(135deg, #0d3b23 0%, #1b5e3a 40%, #2e7d32 80%, #388e3c 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        position: relative;
        overflow-x: hidden;
      }
      .login-box {
        width: 100%;
        max-width: 440px;
        padding: 20px;
        position: relative;
        z-index: 10;
      }
      .login-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
      }
      .login-card-body {
        padding: 2.25rem 2rem;
      }
      .brand-header {
        text-align: center;
        margin-bottom: 1.5rem;
      }
      .brand-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #1b5e3a, #2e7d32);
        color: #ffffff;
        border-radius: 16px;
        font-size: 1.6rem;
        box-shadow: 0 8px 20px rgba(27, 94, 58, 0.3);
        margin-bottom: 1rem;
      }
      .brand-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #1b5e3a;
        margin: 0;
      }
      .brand-subtitle {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
      }
      .form-control, .input-group-text {
        border-color: #e2e8f0;
        padding: 0.65rem 0.9rem;
        font-size: 0.92rem;
      }
      .form-control:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.15);
      }
      .input-group-text {
        background-color: #f8fafc;
        color: #64748b;
      }
      .btn-toggle-password {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
        cursor: pointer;
      }
      .btn-toggle-password:hover {
        background-color: #f1f5f9;
        color: #1e293b;
      }
      .btn-submit {
        background: linear-gradient(135deg, #1b5e3a 0%, #2e7d32 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        padding: 0.75rem;
        border-radius: 12px;
        font-size: 0.95rem;
        box-shadow: 0 8px 18px rgba(27, 94, 58, 0.25);
        transition: all 0.25s ease;
      }
      .btn-submit:hover {
        background: linear-gradient(135deg, #14472b 0%, #236327 100%);
        color: #ffffff;
      }
    </style>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-card">
        <div class="login-card-body">
          
          <div class="brand-header">
            <div class="brand-badge">
              <i class="bi bi-key-fill"></i>
            </div>
            <h1 class="brand-title">Reset Password</h1>
            <p class="brand-subtitle">Masukkan kode token & password baru Anda</p>
          </div>

          @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm p-3 mb-3" style="border-radius: 10px; font-size: 0.88rem;">
              <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm p-3 mb-3" style="border-radius: 10px; font-size: 0.88rem;">
              <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
            </div>
          @endif

          <form action="{{ route('password.update') }}" method="post">
            @csrf
            
            <!-- Email (Readonly) -->
            <div class="mb-3">
              <label for="email" class="form-label text-secondary fw-semibold small mb-1">Email Terdaftar</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="email" name="email" id="email" class="form-control bg-light" value="{{ old('email', $email) }}" required readonly />
              </div>
            </div>

            <!-- Kode Token -->
            <div class="mb-3">
              <label for="token" class="form-label text-secondary fw-semibold small mb-1">Kode Token (6 Digit)</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                <input type="text" name="token" id="token" class="form-control text-center fw-bold" placeholder="000000" maxlength="6" value="{{ old('token') }}" required autofocus style="letter-spacing: 4px; font-size: 1.1rem;" />
              </div>
            </div>

            <!-- Password Baru -->
            <div class="mb-3">
              <label for="password" class="form-label text-secondary fw-semibold small mb-1">Password Baru (Min 8 Karakter)</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required />
                <button type="button" class="btn btn-toggle-password input-group-text" id="togglePassword1" title="Tampilkan Password">
                  <i class="bi bi-eye-slash-fill" id="toggleIcon1"></i>
                </button>
              </div>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="mb-4">
              <label for="password_confirmation" class="form-label text-secondary fw-semibold small mb-1">Konfirmasi Password Baru</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required />
                <button type="button" class="btn btn-toggle-password input-group-text" id="togglePassword2" title="Tampilkan Password">
                  <i class="bi bi-eye-slash-fill" id="toggleIcon2"></i>
                </button>
              </div>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center">
                <span>Perbarui Password</span>
                <i class="bi bi-check-circle-fill ms-2 fs-5"></i>
              </button>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary small fw-semibold">
              <i class="bi bi-arrow-clockwise me-1"></i> Kirim Ulang Kode Token
            </a>
          </div>

        </div>
      </div>
    </div>

    <script>
      function setupToggle(buttonId, inputId, iconId) {
        const btn = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (btn && input && icon) {
          btn.addEventListener('click', function () {
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            icon.classList.toggle('bi-eye-slash-fill', !isPassword);
            icon.classList.toggle('bi-eye-fill', isPassword);
          });
        }
      }

      setupToggle('togglePassword1', 'password', 'toggleIcon1');
      setupToggle('togglePassword2', 'password_confirmation', 'toggleIcon2');
    </script>
  </body>
</html>
