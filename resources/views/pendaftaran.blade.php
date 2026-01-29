<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun PPDB - Al-Ittihaad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0fdf4; font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-registrasi { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
        .header-img { background: url('https://source.unsplash.com/random/800x600/?school,islamic') center/cover; min-height: 100%; }
        .btn-daftar { background-color: #059669; color: white; padding: 12px; font-weight: bold; border-radius: 10px; width: 100%; border: none; }
        .btn-daftar:hover { background-color: #047857; }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-registrasi">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-block header-img position-relative">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center text-center p-4">
                                <div class="text-white">
                                    <h3 class="fw-bold">Ahlan Wa Sahlan</h3>
                                    <p>Bergabunglah menjadi bagian dari Generasi Qurani Al-Ittihaad.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-7 bg-white p-5">
                            <div class="text-start mb-4">
                                <h3 class="fw-bold text-success">Buat Akun Pendaftaran</h3>
                                <p class="text-muted">Isi data singkat untuk mendapatkan akun login. Data lengkap dapat diisi setelah login.</p>
                            </div>

                            <form action="{{ url('/proses-daftar') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="fw-bold small text-muted">Nama Lengkap Calon Santri</label>
                                    <input type="text" name="nama_lengkap" class="form-control form-control-lg bg-light" placeholder="Sesuai Ijazah" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="fw-bold small text-muted">Nomor WhatsApp (Aktif)</label>
                                        <input type="number" name="no_wa" class="form-control form-control-lg bg-light" placeholder="08..." required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="fw-bold small text-muted">Jenjang Dituju</label>
                                        <select name="jenjang" id="selectJenjang" class="form-select form-select-lg bg-light" required>
                                            <option value="">- Pilih -</option>
                                            @foreach(['PAUD','RA/TA','SDIT','MDU','MTS','MA'] as $j) <option value="{{$j}}">{{$j}}</option> @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4" id="boxAsrama" style="display: none;">
                                    <label class="fw-bold small text-muted">Pilihan Asrama (Khusus MTS/MA)</label>
                                    <select name="pilihan_asrama" id="selectAsrama" class="form-select form-select-lg bg-light">
                                        <option value="Non-Asrama">Non-Asrama (Pulang Pergi)</option>
                                        <option value="Asrama">Mukim (Asrama)</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-daftar shadow-sm mb-3">
                                    <i class="bi bi-person-plus-fill me-2"></i> DAFTAR SEKARANG
                                </button>

                                <div class="text-center small">
                                    Sudah punya akun? <a href="{{ url('/siswa/login') }}" class="text-success fw-bold text-decoration-none">Login Disini</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectJenjang = document.getElementById('selectJenjang');
            var boxAsrama = document.getElementById('boxAsrama');
            var selectAsrama = document.getElementById('selectAsrama');

            function cekJenjang() {
                var jenjang = selectJenjang.value;
                // Daftar jenjang KECIL (Tidak ada asrama)
                var nonAsrama = ['PAUD', 'RA/TA', 'SDIT', 'MDU', ''];
                
                if (nonAsrama.includes(jenjang)) {
                    // Sembunyikan & Reset ke Non-Asrama
                    boxAsrama.style.display = 'none';
                    selectAsrama.value = 'Non-Asrama';
                } else {
                    // Tampilkan (MTS & MA)
                    boxAsrama.style.display = 'block';
                }
            }

            // Jalankan saat load & saat ganti pilihan
            cekJenjang();
            selectJenjang.addEventListener('change', cekJenjang);
        });
    </script>

</body>
</html>