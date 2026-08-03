<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Mitsubishi Motors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #121212 0%, #2a2a2a 100%);
            min-height: 100vh;
        }
        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            overflow: hidden;
        }
        .login-header {
            background-color: #111;
            padding: 30px;
            text-align: center;
            border-bottom: 4px solid #E60012;
        }
        .text-mitsubishi {
            color: #E60012 !important;
        }
        .btn-mitsubishi {
            background-color: #E60012;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s;
        }
        .btn-mitsubishi:hover {
            background-color: #c40010;
            color: #fff;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 14px;
        }
        .form-control:focus {
            border-color: #E60012;
            box-shadow: 0 0 0 0.25rem rgba(230, 0, 18, 0.25);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">

<div class="card login-card style-card" style="width: 100%; max-width: 420px;">
    <div class="login-header">
        <h3 class="text-white fw-bold tracking-wide m-0">
            <i class="fa-solid fa-car-side text-mitsubishi me-2"></i>MITSUBISHI
        </h3>
        <small class="text-secondary fw-semibold">Sun Star Prima Motor</small>
    </div>

    <div class="card-body p-4">
        <h5 class="fw-bold mb-1 text-dark">Selamat Datang Kembali</h5>
        <p class="text-muted small mb-4">Masuk untuk mengelola kendaraan & melihat katalog servis.</p>

        @if($errors->any())
            <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Isi Alamat Email" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Isi Password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-mitsubishi w-100 mb-3">
                <i class="fa-solid fa-right-to-bracket me-2"></i> MASUK
            </button>
        </form>

        <div class="text-center mt-3 pt-3 border-top">
            <p class="small text-muted mb-0">Belum punya akun? 
                <a href="{{ route('register') }}" class="text-mitsubishi fw-bold text-decoration-none">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>