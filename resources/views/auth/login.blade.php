<!doctype html>
<html lang="id">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ROSMO Admin | Masuk Ke Sistem</title>
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
      /* Decorative Background Elements */
      body.login-page::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        top: -100px;
        left: -100px;
        pointer-events: none;
      }
      body.login-page::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 50%;
        bottom: -80px;
        right: -80px;
        pointer-events: none;
      }

      .login-box {
        width: 100%;
        max-width: 420px;
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
        margin-bottom: 1.75rem;
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
        letter-spacing: -0.5px;
      }

      .brand-subtitle {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
        font-weight: 500;
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
        transition: all 0.2s ease;
      }
      .btn-toggle-password:hover {
        background-color: #f1f5f9;
        color: #1e293b;
      }

      .captcha-card {
        background: #f0fdf4;
        border: 1px dashed #86efac;
        border-radius: 12px;
        padding: 1rem;
      }

      .btn-submit {
        background: linear-gradient(135deg, #1b5e3a 0%, #2e7d32 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        padding: 0.75rem;
        border-radius: 12px;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
        box-shadow: 0 8px 18px rgba(27, 94, 58, 0.25);
        transition: all 0.25s ease;
      }

      .btn-submit:hover {
        background: linear-gradient(135deg, #14472b 0%, #236327 100%);
        transform: translateY(-1px);
        box-shadow: 0 12px 22px rgba(27, 94, 58, 0.35);
        color: #ffffff;
      }

      .forgot-link {
        color: #475569;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: color 0.2s ease;
      }
      .forgot-link:hover {
        color: #1b5e3a;
        text-decoration: underline;
      }
    </style>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-card">
        <div class="login-card-body">
          
          <!-- Brand Header -->
          <div class="brand-header">
            <div class="brand-badge">
              <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h1 class="brand-title">ROSMO Admin</h1>
            <p class="brand-subtitle">Biro Sumber Daya Manusia dan Organisasi</p>
          </div>

          <!-- Notification Messages -->
          @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm p-3 mb-3" style="border-radius: 10px; font-size: 0.88rem;">
              <div class="d-flex align-items-center mb-1">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <strong class="fw-bold">Gagal Masuk</strong>
              </div>
              <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm p-3 mb-3" style="border-radius: 10px; font-size: 0.88rem;">
              <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
          @endif

          @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm p-3 mb-3" style="border-radius: 10px; font-size: 0.88rem;">
              <i class="bi bi-info-circle-fill me-2"></i> {{ session('status') }}
            </div>
          @endif

          <!-- Login Form -->
          <form action="{{ url('login') }}" method="post">
            @csrf
            
            <!-- Email Field -->
            <div class="mb-3">
              <label for="email" class="form-label text-secondary fw-semibold small mb-1">Alamat Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus />
              </div>
            </div>

            <!-- Password Field with View Eye Icon Toggle -->
            <div class="mb-3">
              <label for="password" class="form-label text-secondary fw-semibold small mb-1">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required />
                <button type="button" class="btn btn-toggle-password input-group-text" id="togglePassword" title="Tampilkan Password" aria-label="Tampilkan Password">
                  <i class="bi bi-eye-slash-fill" id="toggleIcon"></i>
                </button>
              </div>
            </div>
            
            <!-- Math Captcha Section -->
            <div class="captcha-card mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label for="captcha" class="form-label mb-0 fw-semibold text-dark small">
                  <i class="bi bi-shield-check text-success me-1"></i> Berapakah 
                  <span id="captcha-text" class="badge bg-success fs-6 px-2 py-1 ms-1">{{ session('captcha_text') }}</span> ?
                </label>
                <button type="button" id="refresh-btn" class="btn btn-sm btn-link text-success p-0 text-decoration-none fw-semibold small">
                  <i class="bi bi-arrow-clockwise"></i> Acak Ulang
                </button>
              </div>
              <div class="input-group input-group-sm">
                <span class="input-group-text"><i class="bi bi-calculator-fill"></i></span>
                <input type="number" name="captcha" id="captcha" class="form-control" placeholder="Masukkan jawaban angka..." required />
              </div>
            </div>

            <!-- Options Row -->
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                <label class="form-check-label text-secondary small fw-medium" for="remember"> Ingat Saya </label>
              </div>
              <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
              <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center">
                <span>Masuk Sekarang</span>
                <i class="bi bi-arrow-right-circle-fill ms-2 fs-5"></i>
              </button>
            </div>
          </form>

        </div>
      </div>
      
      <!-- Footer Note -->
      <div class="text-center mt-3 text-white-50 small">
        &copy; {{ date('Y') }} ROSMO Biro SDMO Kementerian Kehutanan
      </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Interactive Scripts -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (togglePassword && passwordInput && toggleIcon) {
          togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            toggleIcon.classList.toggle('bi-eye-slash-fill', !isPassword);
            toggleIcon.classList.toggle('bi-eye-fill', isPassword);
            this.setAttribute('title', isPassword ? 'Sembunyikan Password' : 'Tampilkan Password');
          });
        }

        // Refresh Math Captcha
        const refreshBtn = document.getElementById('refresh-btn');
        if (refreshBtn) {
          refreshBtn.addEventListener('click', function () {
            const icon = this.querySelector('i');
            icon.classList.add('pe-none');
            icon.style.transition = 'transform 0.5s';
            icon.style.transform = 'rotate(360deg)';
            
            fetch("{{ route('captcha.refresh') }}", {
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => response.json())
            .then(data => {
              document.getElementById('captcha-text').innerText = data.captcha;
              document.getElementById('captcha').value = '';
              setTimeout(() => {
                icon.style.transform = 'none';
                icon.classList.remove('pe-none');
              }, 500);
            })
            .catch(err => {
              console.error(err);
              icon.style.transform = 'none';
              icon.classList.remove('pe-none');
            });
          });
        }
      });
    </script>
  </body>
</html>
