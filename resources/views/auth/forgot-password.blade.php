<!doctype html>
<html lang="id">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ROSMO Admin | Lupa Password</title>
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
      }
      .login-box {
        width: 100%;
        max-width: 420px;
        padding: 20px;
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
              <i class="bi bi-envelope-paper-fill"></i>
            </div>
            <h1 class="brand-title">Lupa Password</h1>
            <p class="brand-subtitle">Masukkan email terdaftar untuk menerima kode token reset</p>
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

          <form action="{{ route('password.email') }}" method="post">
            @csrf
            
            <div class="mb-4">
              <label for="email" class="form-label text-secondary fw-semibold small mb-1">Alamat Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus />
              </div>
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center">
                <span>Kirim Kode Token</span>
                <i class="bi bi-send-fill ms-2 fs-6"></i>
              </button>
            </div>
          </form>

          <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none text-secondary small fw-semibold">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
            </a>
          </div>

        </div>
      </div>
    </div>
  </body>
</html>
