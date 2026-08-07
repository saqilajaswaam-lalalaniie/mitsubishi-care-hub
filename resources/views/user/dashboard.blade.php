<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda Katalog - Mitsubishi Care Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    .bg-mitsubishi {
        background-color: #111111 !important;
        border-bottom: 3px solid #E60012;
    }
    .text-mitsubishi {
        color: #E60012 !important;
    }
    .btn-mitsubishi {
        background-color: #E60012;
        color: #ffffff;
        border: none;
    }
    .btn-mitsubishi:hover {
        background-color: #b3000e;
        color: #ffffff;
    }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-mitsubishi py-3 mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold tracking-wide" href="#">
            <i class="fa-solid fa-car-side text-mitsubishi me-2"></i>LOGO TAR GANTI AJ<span class="fw-normal text-white"></span>
        </a>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('forum.index') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                <i class="fa-solid fa-comments me-1 text-mitsubishi"></i> Forum QnA
            </a>

            <a href="{{ route('user.profile') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                <i class="fa-solid fa-user-gear me-1"></i> Profil & Garasi Saya
            </a>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-mitsubishi btn-sm px-3 rounded-pill">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <div class="p-4 bg-white rounded shadow-sm mb-4 border-start border-4 border-danger">
        <h4 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}!</h4>
        <p class="text-muted mb-3"><i class="fa-solid fa-circle-info me-1"></i> Cari sparepart dan estimasi layanan servis diler resmi Sun Star Prima Motors di sini.</p>
        
        <a href="{{ route('forum.index') }}" class="btn btn-dark btn-sm">
            <i class="fa-solid fa-comments text-mitsubishi me-1"></i> Kunjungi Forum QnA Komunitas
        </a>
    </div>

    <div class="card p-5 text-center text-muted border-dashed shadow-sm">
        <i class="fa-solid fa-boxes-stacked fa-3x mb-3 text-secondary"></i>
        <h5>[ Belum kepikiran lagi, hehe. Lanjutin yh ]</h5>
        <p class="mb-0">Katalog akan ditampilkan di sini sesuai kendaraan yang terdaftar di garasi Anda.</p>
    </div>
</div>

</body>
</html>