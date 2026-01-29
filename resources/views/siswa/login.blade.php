<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa - PPDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #ecfdf5; }
        .card-login { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-green { background-color: #059669; color: white; }
        .btn-green:hover { background-color: #047857; color: white; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-success">Login Calon Santri</h3>
                <p class="text-muted">Masuk untuk melihat biodata & pengumuman.</p>
            </div>
            
            <div class="card card-login p-4">
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ url('/siswa/login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="fw-bold small text-muted">Nomor Pendaftaran (Username)</label>
                            <input type="text" name="no_daftar" class="form-control form-control-lg" placeholder="REG-2025-XXXX" required>
                        </div>
                        <div class="mb-4">
                            <label class="fw-bold small text-muted">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="6 Digit Angka" required>
                        </div>
                        <button class="btn btn-green w-100 btn-lg fw-bold mb-3">Masuk Sekarang</button>
                        <div class="text-center">
                            <a href="{{ url('/') }}" class="text-decoration-none text-muted small">Kembali ke Beranda</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>