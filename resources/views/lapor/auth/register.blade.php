<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lapor SDM | Daftar Akun</title>
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
            padding: 2rem 0;
        }
        .auth-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            background: white;
            width: 100%;
            max-width: 500px;
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
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus, .form-select:focus {
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
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.3rem;
        }
        .input-group-text {
            background-color: #f8f9fa;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-header">
            <h3>Lapor SDM</h3>
            <p class="mb-0 text-white-50 mt-1" style="font-size: 0.9rem;">Buat Akun Pelapor Baru</p>
        </div>
        <div class="auth-body">
            
            @if ($errors->any())
                <div class="alert alert-danger" style="font-size: 0.85rem; border-radius: 0.5rem;">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('lapor-sdm/register') }}" method="post">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="Nama sesuai identitas" value="{{ old('name') }}" required autofocus />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Aktif</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="contoh@email.com" value="{{ old('email') }}" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-whatsapp"></i></span>
                        <input type="text" name="whatsapp" class="form-control border-start-0 ps-0" placeholder="08123xxxx" value="{{ old('whatsapp') }}" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe Pengguna</label>
                    <select name="type" class="form-select" id="type-select" required>
                        <option value="">-- Silakan Pilih --</option>
                        <option value="asn" {{ old('type') == 'asn' ? 'selected' : '' }}>Aparatur Sipil Negara (ASN)</option>
                        <option value="non_asn" {{ old('type') == 'non_asn' ? 'selected' : '' }}>Masyarakat Umum (Non-ASN)</option>
                    </select>
                </div>

                <div class="mb-3" id="nip-container" style="display: none;">
                    <label class="form-label text-primary">NIP (18 Digit)</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-primary-subtle border-primary text-primary"><i class="bi bi-credit-card"></i></span>
                        <input type="text" name="nip" id="nip-input" class="form-control border-start-0 ps-0 border-primary bg-primary-subtle" placeholder="Masukkan 18 digit NIP" value="{{ old('nip') }}" minlength="18" maxlength="18" />
                    </div>
                </div>

                <div class="mb-3" id="nik-container" style="display: none;">
                    <label class="form-label text-success">NIK (16 Digit)</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-success-subtle border-success text-success"><i class="bi bi-person-badge"></i></span>
                        <input type="text" name="nik" id="nik-input" class="form-control border-start-0 ps-0 border-success bg-success-subtle" placeholder="Masukkan 16 digit NIK" value="{{ old('nik') }}" minlength="16" maxlength="16" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Min. 8 karakter" required />
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="Ulangi password" required />
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="privacy_policy" id="privacyPolicy" required />
                        <label class="form-check-label text-muted" for="privacyPolicy" style="font-size: 0.85rem;">
                            Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Kebijakan Privasi</a> layanan ini.
                        </label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Buat Akun Sekarang</button>
                </div>
            </form>

            <div class="auth-footer">
                Sudah memiliki akun? <a href="{{ url('lapor-sdm/login') }}">Login di sini</a>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-bottom-0 pb-0">
            <h5 class="modal-title fw-bold" id="privacyModalLabel">Kebijakan Privasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-muted" style="font-size: 0.95rem; line-height: 1.6;">
            <p><strong>1. Pengumpulan Informasi</strong><br>
            Kami mengumpulkan informasi pribadi Anda saat mendaftar, seperti Nama, Email, Nomor WhatsApp, NIP (untuk ASN), atau NIK (untuk Non-ASN). Data ini dikumpulkan semata-mata untuk keperluan verifikasi dan identifikasi pelapor dalam sistem Lapor SDM.</p>
            
            <p><strong>2. Penggunaan Informasi</strong><br>
            Informasi yang dikumpulkan digunakan untuk:</p>
            <ul>
                <li>Memproses laporan atau tiket yang Anda buat.</li>
                <li>Menghubungi Anda terkait status atau tanggapan dari tim Helpdesk BKN.</li>
                <li>Memastikan keamanan dan akuntabilitas setiap laporan yang masuk.</li>
            </ul>

            <p><strong>3. Perlindungan Data</strong><br>
            Kami berkomitmen untuk melindungi data pribadi Anda. Data Anda disimpan secara aman dan tidak akan dibagikan, dijual, atau dipindahtangankan ke pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum atau peraturan perundang-undangan yang berlaku.</p>

            <p class="mb-0"><strong>4. Persetujuan</strong><br>
            Dengan mencentang kotak persetujuan saat pendaftaran, Anda setuju dengan pengumpulan dan penggunaan informasi Anda sesuai dengan kebijakan ini.</p>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-primary w-100 rounded-3" data-bs-dismiss="modal">Saya Mengerti</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type-select');
            const nipContainer = document.getElementById('nip-container');
            const nikContainer = document.getElementById('nik-container');
            const nipInput = document.getElementById('nip-input');
            const nikInput = document.getElementById('nik-input');

            function toggleFields() {
                if (typeSelect.value === 'asn') {
                    nipContainer.style.display = 'block';
                    nikContainer.style.display = 'none';
                    nipInput.required = true;
                    nikInput.required = false;
                    nikInput.value = '';
                } else if (typeSelect.value === 'non_asn') {
                    nikContainer.style.display = 'block';
                    nipContainer.style.display = 'none';
                    nikInput.required = true;
                    nipInput.required = false;
                    nipInput.value = '';
                } else {
                    nipContainer.style.display = 'none';
                    nikContainer.style.display = 'none';
                    nipInput.required = false;
                    nikInput.required = false;
                }
            }

            typeSelect.addEventListener('change', toggleFields);
            toggleFields(); // Initial run on page load for old values
        });
    </script>
</body>
</html>
