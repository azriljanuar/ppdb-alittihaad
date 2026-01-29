<!DOCTYPE html>
<html>
<head>
    <title>Tambah User Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Tambah User Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email Login</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Jabatan (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin Unit (Operator)</option>
                            <option value="kepsek">Kepala Sekolah (Hanya Lihat)</option>
                            <option value="superadmin">Super Admin (Penyelia)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Akses Jenjang (Khusus Admin Unit & Kepsek)</label>
                        <select name="jenjang_access" class="form-select">
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="PAUD">PAUD</option>
                            <option value="RA/TK">RA/TK</option>
                            <option value="SDIT">SDIT</option>
                            <option value="MDU">MDU</option>
                            <option value="MTS">MTS</option>
                            <option value="MA">MA</option>
                        </select>
                        <small class="text-muted">*Jika Super Admin, pilihan ini tidak berpengaruh.</small>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Simpan User</button>
                    <a href="{{ url('/users') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
