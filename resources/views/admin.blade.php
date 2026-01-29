@extends('layout_admin') 

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Dashboard Admin</h3>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
        <span class="badge bg-success px-3 py-2">Status System: Online</span>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75 small fw-bold">Total Pendaftar</h6>
                            <h2 class="mb-0 fw-bold">{{ $total_pendaftar }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-success text-white h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75 small fw-bold">Sudah Bayar / Lunas</h6>
                            <h2 class="mb-0 fw-bold">{{ $sudah_bayar }}</h2>
                        </div>
                        <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-warning text-dark h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75 small fw-bold">Menunggu Verifikasi</h6>
                            <h2 class="mb-0 fw-bold">{{ $belum_verifikasi }}</h2>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4 shadow-sm border-0 rounded-3">
        <div class="d-flex">
            <div class="me-3"><i class="bi bi-info-circle-fill fs-4"></i></div>
            <div>
                <h6 class="fw-bold">Informasi Admin</h6>
                <p class="mb-0 small">
                    Untuk melihat detail data siswa, mengedit, menghapus, atau mencetak formulir, silakan akses menu 
                    <strong><i class="bi bi-people-fill"></i> Data Calon Santri</strong> di sidebar sebelah kiri.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection