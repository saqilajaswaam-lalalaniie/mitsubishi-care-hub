<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Mitsubishi Care Hub</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Merah Resmi Mitsubishi */
        .bg-mitsubishi {
            background-color: #111111 !important;
            border-bottom: 3px solid #E60012;
        }
        .bg-mitsubishi-garasi {
            background-color: #E60012 !important;
            border-bottom: 3px solid #000000;
        }
        .bg-mitsubishi-profile {
            background-color: #b3b3b3 !important;
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
        .btn-outline-mitsubishi {
            border: 1px solid #E60012;
            color: #E60012;
            background: transparent;
        }
        .btn-outline-mitsubishi:hover {
            background-color: #E60012;
            color: #ffffff;
        }
        .btn-black {
        background-color: #000000 !important;
        color: #ffffff !important;
        border: 1px solid #000000;
        }
        .btn-black:hover {
        background-color: #222222 !important; /* Efek sedikit terang saat di-hover */
        color: #ffffff !important;
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
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                <i class="fa-solid fa-store me-1"></i> Beranda / Katalog
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
    @if(session('success'))
        <div class="alert alert-success"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-3 small">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 text-center p-3">
                <div class="card-body">
                    <div class="bg-mitsubishi-profile text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px;">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>

                    <hr>

                    <form action="{{ route('user.profile.update') }}" method="POST" class="text-start">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-bold"><i class="fa-solid fa-id-card me-1"></i> Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-sm" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold"><i class="fa-solid fa-envelope me-1"></i> Email</label>
                            <input type="email" name="email" class="form-control form-control-sm" value="{{ $user->email }}" required>
                        </div>
                        <button type="submit" class="btn btn-sm btn-black w-100">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Update Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-mitsubishi-garasi text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold"><i class="fa-solid fa-warehouse me-2"></i>Garasi Digital Saya</h6>
                    <span class="badge bg-light text-dark">{{ count($vehicles) }} Kendaraan</span>
                </div>
                <div class="card-body">
                    @if(empty($vehicles) || count($vehicles) == 0)
                        <div class="text-center my-4 text-muted">
                            <i class="fa-solid fa-car-burst fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada kendaraan di garasi Anda. Tambahkan di bawah!</p>
                        </div>
                    @else
                        <div class="row">
                            @foreach($vehicles as $item)
                                <div class="col-md-6 mb-3">
                                    <div class="card border shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title text-mitsubishi fw-bold mb-2">
                                                <i class="fa-solid fa-car me-2"></i>{{ $item->tipe_mobil }}
                                            </h6>
                                            <p class="card-text mb-1 small"> <strong>NOPOL:</strong> {{ $item->plat_nomor }}</p>
                                            <p class="card-text mb-1 small"> <strong>Warna/Thn:</strong> {{ $item->warna }} ({{ $item->tahun }})</p>
                                            <p class="card-text mb-3 small"> <strong>No. Rangka:</strong> {{ $item->no_rangka }}</p>

                                            <form action="{{ route('vehicles.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus mobil ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-mitsubishi w-100">
                                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus Mobil
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-black text-white">
                    <h6 class="m-0 fw-bold"><i class="fa-solid fa-square-plus me-2"></i>Tambah Kendaraan Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Tipe Mobil</label>
                                <select name="tipe_mobil" class="form-select form-select-sm" required>
                                    <option value="XPander">XPander</option>
                                    <option value="XPander Cross">XPander Cross</option>
                                    <option value="XForce">XForce</option>
                                    <option value="Pajero Sport">Pajero Sport</option>
                                    <option value="Destinator">Destinator</option>
                                    <option value="L300">L300</option>
                                    <option value="Triton">Triton</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">No. Polisi (Plat)</label>
                                <input type="text" name="plat_nomor" class="form-control form-control-sm" placeholder="B 1234 ABC" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold">Tahun</label>
                                <input type="number" name="tahun" class="form-control form-control-sm" placeholder="2023" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold">Warna</label>
                                <select name="warna" class="form-select form-select-sm" required>
                                    <option value="Hitam">Hitam</option>
                                    <option value="Putih">Putih</option>
                                    <option value="Merah">Merah</option>
                                    <option value="Silver">Silver</option>
                                    <option value="Abu-abu">Abu-abu</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold">No. Rangka</label>
                                <input type="text" name="no_rangka" class="form-control form-control-sm" placeholder="MHX..." required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-mitsubishi w-100 fw-bold btn-sm mt-2">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan ke Garasi
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>