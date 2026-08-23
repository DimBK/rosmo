<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Token</title>
    <style>
        body {
            font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e1e8ed;
        }
        .header {
            background-color: #2e7d32;
            color: #ffffff;
            text-align: center;
            padding: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px;
            line-height: 1.6;
        }
        .content p {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 16px;
            color: #555555;
        }
        .token-card {
            background-color: #f1f8e9;
            border: 1px dashed #81c784;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .token-code {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 6px;
            color: #2e7d32;
            margin: 0;
        }
        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #888888;
            border-top: 1px solid #e1e8ed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reset Password</h1>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $user->name }}</strong></p>
            <p>Kami menerima permintaan untuk melakukan reset password pada akun Admin ROSMO Anda. Gunakan kode token berikut untuk memproses reset password Anda:</p>
            
            <div class="token-card">
                <p style="margin-bottom: 10px; font-size: 14px; font-weight: 600; color: #666;">KODE RESET TOKEN</p>
                <div class="token-code">{{ $token }}</div>
            </div>

            <p style="color: #d32f2f; font-size: 14px; font-weight: 600;">Penting: Kode token ini hanya berlaku selama 15 menit. Jangan bagikan kode ini kepada siapa pun.</p>
            <p>Jika Anda tidak meminta perubahan ini, silakan abaikan email ini.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} ROSMO Biro SDMO Kementerian Kehutanan. All rights reserved.
        </div>
    </div>
</body>
</html>
