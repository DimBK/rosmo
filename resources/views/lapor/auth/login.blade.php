<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lapor SDM | Login</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            background: white;
            width: 100%;
            max-width: 420px;
        }
        .auth-header {
            background: #0d6efd;
            padding: 2rem 1.5rem;
            text-align: center;
            color: white;
        }
        .auth-header h3 {
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .auth-body {
            padding: 2.5rem;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            background-color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .btn-primary {
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .auth-footer a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-header">
            <h3>Lapor SDM</h3>
            <p class="mb-0 text-white-50 mt-1" style="font-size: 0.9rem;">Portal Layanan Pengaduan BKN</p>
        </div>
        <div class="auth-body">
            <h5 class="text-center mb-4 fw-bold text-dark">Selamat Datang</h5>

            @if ($errors->any())
                <div class="alert alert-danger" style="font-size: 0.85rem; border-radius: 0.5rem;">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('lapor-sdm/login') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted small">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Masukkan password" required />
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Masuk ke Sistem</button>
                </div>
            </form>

            <div class="auth-footer">
                Belum memiliki akun pelapor? <br><a href="{{ url('lapor-sdm/register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
