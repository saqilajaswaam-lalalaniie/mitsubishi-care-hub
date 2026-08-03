<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

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
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-mitsubishi py-3 mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold tracking-wide" href="#">
            <i class="fa-solid fa-gem text-mitsubishi me-2"></i>LOGO TAR GANTI AJ<span class="fw-normal text-white"></span>
        </a>

        <div class="d-flex align-items-center gap-3">
            <span class="badge border border-white px-3 py-2 rounded-pill">
                <i class="fa-solid fa-user-shield me-1"></i> Admin Diler
            </span>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-mitsubishi btn-sm px-3 rounded-pill">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-custom p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="fw-bold mb-1 text-dark">Monitoring Garasi Digital</h4>
                <p class="text-secondary small mb-0">Daftar semua unit kendaraan pelanggan yang terdaftar di sistem Mitsubishi Sun Star Prima Motor.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="d-inline-block text-start p-3 bg-light rounded-3 border">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.75rem;">Total Unit Registered</small>
                    <span class="fs-3 fw-bold text-dark me-2">{{ count($vehicles) }}</span>
                    <span class="badge bg-danger">Mobil Pelanggan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom overflow-hidden">
        <div class="card-header bg-dark text-white p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h6 class="m-0 fw-bold"><i class="fa-solid fa-car-tunnel text-mitsubishi me-2"></i>Data Kendaraan Terdaftar</h6>
            
            <div class="input-group input-group-sm" style="max-width: 280px;">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control border-start-0" placeholder="Cari Nopol / Pemilik / Tipe...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="vehicleTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Pemilik</th>
                            <th>Tipe Mobil</th>
                            <th>Plat Nomor</th>
                            <th>Warna & Tahun</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $item->user->name ?? 'User Terhapus' }}</div>
                                </td>

                                <td>
                                    <span class="badge bg-danger bg-opacity-10 text-mitsubishi fw-bold px-3 py-2 rounded-2">
                                        {{ $item->tipe_mobil }}
                                    </span>
                                </td>

                                <td>
                                    <code class="fw-bold text-dark fs-6 bg-light px-2 py-1 rounded border">{{ $item->plat_nomor }}</code>
                                </td>

                                <td>
                                    <span class="text-dark fw-semibold">{{ $item->warna }}</span>
                                    <span class="text-muted small">({{ $item->tahun }})</span>
                                </td>

                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}" title="Lihat Detail Lengkap">
                                            <i class="fa-solid fa-eye me-1"></i>
                                        </button>

                                        <form action="{{ route('vehicles.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data mobil ini dari garasi digital?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary"></i>
                                    <p class="mb-0">Belum ada kendaraan yang dimasukkan oleh pelanggan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($vehicles as $item)
    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-dark text-white">
                    <h6 class="modal-title fw-bold"><i class="fa-solid fa-id-card text-mitsubishi me-2"></i>Kartu Informasi Kendaraan</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start p-4">
                    <div class="text-center mb-3">
                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill mb-2">{{ $item->tipe_mobil }}</span>
                        <h4 class="fw-bold text-dark font-monospace mb-0">{{ $item->plat_nomor }}</h4>
                    </div>
                    <hr>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 40%;"><i class="fa-solid fa-user me-2"></i>Nama Pemilik:</td>
                            <td class="fw-bold text-dark">{{ $item->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fa-solid fa-envelope me-2"></i>Email Pemilik:</td>
                            <td class="text-dark">{{ $item->user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fa-solid fa-palette me-2"></i>Warna / Tahun:</td>
                            <td class="text-dark">{{ $item->warna }} / {{ $item->tahun }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fa-solid fa-fingerprint me-2"></i>No. Rangka:</td>
                            <td><code class="text-dark fw-bold">{{ $item->no_rangka }}</code></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fa-solid fa-calendar-check me-2"></i>Terdaftar Pada:</td>
                            <td class="text-dark">{{ $item->created_at ? $item->created_at->format('d M Y H:i') . ' WIB' : '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function searchTable() {
    let input = document.getElementById("searchInput").value.toUpperCase();
    let table = document.getElementById("vehicleTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td");
        if (td.length > 0) {
            let text = tr[i].innerText.toUpperCase();
            if (text.indexOf(input) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
</body>
</html>