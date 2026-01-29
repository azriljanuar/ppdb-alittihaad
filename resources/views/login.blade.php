<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - Al-Ittihaad</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        .login-container { height: 100%; }
        
        /* Bagian Kiri (Gambar) */
        .login-image {
            background-image: url('https://img.freepik.com/free-photo/modern-school-building-with-blue-sky_1127-3079.jpg'); /* Ganti URL ini dengan foto sekolah Anda */
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .login-overlay {
            background: linear-gradient(to bottom, rgba(6, 78, 59, 0.7), rgba(6, 78, 59, 0.9));
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 50px;
            color: white;
        }
        
        /* Bagian Kanan (Form) */
        .login-form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        
        /* Styling Input */
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #34d399;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(52, 211, 153, 0.1);
        }
        
        /* Tombol */
        .btn-login {
            background-color: #064e3b; /* Hijau Tua */
            color: #d1fae5; /* Hijau Muda */
            font-weight: 700;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            transition: 0.3s;
            border: none;
        }
        .btn-login:hover {
            background-color: #065f46;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(6, 78, 59, 0.2);
        }
        
        .back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .back-link:hover { color: #064e3b; }
    </style>
</head>
<body>

<div class="container-fluid login-container">
    <div class="row h-100">
        
        <div class="col-lg-7 d-none d-lg-block login-image">
            <div class="login-overlay">
                <h2 class="fw-bold mb-2">Selamat Datang Kembali!</h2>
                <p class="fs-5 opacity-75">Sistem Penerimaan Peserta Didik Baru (PPDB) <br> Al-Ittihaad Tahun Ajaran 2025/2026.</p>
            </div>
        </div>

        <div class="col-lg-5 login-form-section">
            <div class="login-card">
                <div class="text-center mb-5">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-lock-fill fs-3"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Login Admin</h3>
                    <p class="text-muted small">Masuk untuk mengelola data pendaftaran.</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                        <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.proses') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-secondary text-uppercase">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@sekolah.com" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-secondary text-uppercase">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn btn-login mb-4">
                        MASUK DASHBOARD <i class="bi bi-arrow-right-short ms-1"></i>
                    </button>

                    <div class="text-center">
                        <a href="{{ url('/') }}" class="back-link">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Utama
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

</body>
</html>