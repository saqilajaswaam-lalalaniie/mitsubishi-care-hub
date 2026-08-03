<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garasi Digital - Mitsubishi Care Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
<div class="container">

    <h2 class="mb-4 text-danger fw-bold">MITSUBISHI CARE HUB</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="m-0">Profil Pengguna</h5>
        </div>
        <div class="card-body">
            @if($user)
                <form action="{{ route('user.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Simpan Perubahan Profil</button>
                </form>
            @else
                <p class="text-muted m-0">Kamu belum terhubung dengan akun user.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="m-0">Garasi Digital Saya</h5>
        </div>
        <div class="card-body">
            @if(empty($vehicles) || count($vehicles) == 0)
                <p class="text-muted m-0">Belum ada mobil yang terdaftar di garasi kamu.</p>
            @else
                <div class="row">
                    @foreach($vehicles as $item)
                        <div class="col-md-4 mb-3">
                            <div class="card border-secondary">
                                <div class="card-body">
                                    <h5 class="card-title text-danger">{{ $item->tipe_mobil }}</h5>
                                    <p class="card-text mb-1"><strong>Plat:</strong> {{ $item->plat_nomor }}</p>
                                    <p class="card-text mb-1"><strong>Tahun:</strong> {{ $item->tahun }}</p>
                                    <p class="card-text mb-1"><strong>Warna:</strong> {{ $item->warna }}</p>
                                    <p class="card-text text-muted mb-3"><small>No. Rangka: {{ $item->no_rangka }}</small></p>
                                    
                                    <form action="{{ route('vehicles.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus mobil ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus Kendaraan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="m-0">+ Tambah Mobil Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe Mobil</label>
                        <select name="tipe_mobil" class="form-select" required>
                            <option value="XPander">XPander</option>
                            <option value="XPander Cross">XPander Cross</option>
                            <option value="XForce">XForce</option>
                            <option value="Pajero Sport">Pajero</option>
                            <option value="Pajero Sport">Pajero Sport</option>
                            <option value="Pajero Sport">L300</option>
                            <option value="Triton">Triton</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" name="plat_nomor" class="form-control" placeholder="B 1234 ABC" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" class="form-control" placeholder="2023" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Warna</label>
                        <input type="text" name="warna" class="form-control" placeholder="Hitam / Putih / Silver" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No. Rangka</label>
                        <input type="text" name="no_rangka" class="form-control" placeholder="MHX..." required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Tambah ke Garasi</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>