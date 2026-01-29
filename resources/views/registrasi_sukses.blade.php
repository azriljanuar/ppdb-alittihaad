<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

<div class="card border-0 shadow-lg" style="max-width: 500px; width: 100%;">
    <div class="card-body p-5 text-center">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
        </div>
        <h2 class="fw-bold text-success mb-3">Alhamdulillah!</h2>
        <p class="text-muted">Data pendaftaran Anda berhasil disimpan.</p>
        
        <div class="alert alert-warning border-warning text-dark text-start mt-4">
            <h5 class="fw-bold mb-2"><i class="bi bi-key-fill me-2"></i> AKUN SISWA</h5>
            <p class="small mb-2">Silakan <strong>Screenshot</strong> atau catat Username & Password di bawah ini untuk login melihat pengumuman.</p>
            
            <div class="bg-white p-3 rounded border">
                <div class="mb-2">
                    <small class="text-muted text-uppercase fw-bold">Username</small>
                    <div class="fs-5 fw-bold text-primary">{{ $no_daftar }}</div>
                    <div class="fs-4 fw-bold text-primary">{{ $no_daftar }}</div>
                </div>
                <div>
                    <small class="text-muted text-uppercase fw-bold">Password</small>
                    <div class="fs-4 fw-bold text-danger">{{ $password_acak }}</div>
                </div>
            </div>
        </div>
            </div>
        </div>

        <div class="d-grid gap-2 mt-4">
            <a href="{{ url('/siswa/login') }}" class="btn btn-primary fw-bold">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login ke Dashboard Siswa
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</div>

</body>
</html>
