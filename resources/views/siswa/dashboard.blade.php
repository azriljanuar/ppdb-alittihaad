<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa - Al-Ittihaad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8fafc; font-family: sans-serif; }
        .header-profil { background: linear-gradient(to right, #064e3b, #059669); color: white; padding: 40px 0 80px; margin-bottom: -40px; border-radius: 0 0 30px 30px; }
        .nav-pills .nav-link { color: #64748b; background: white; border: 1px solid #e2e8f0; margin-right: 10px; border-radius: 50px; padding: 10px 25px; font-weight: 600; margin-bottom: 10px; }
        .nav-pills .nav-link.active { background-color: #059669; color: white; border-color: #059669; }
        .card-form { border: none; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #475569; }
        .form-control, .form-select { padding: 10px; border-radius: 10px; }
    </style>
</head>
<body>

    <div class="header-profil">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">{{ $siswa->nama_lengkap }}</h2>
                    <p class="opacity-75 mb-0">No. Daftar: <strong>{{ $siswa->no_daftar }}</strong> | Jenjang: {{ $siswa->jenjang }}</p>
                </div>
                <form action="{{ url('/siswa/logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-light text-success fw-bold rounded-pill px-4 shadow-sm">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="text-muted small fw-bold text-uppercase">Status Kelulusan</span>
                    <h4 class="mb-0 fw-bold 
                        {{ $siswa->status_lulus == 'LULUS' ? 'text-primary' : ($siswa->status_lulus == 'TIDAK DITERIMA' ? 'text-danger' : 'text-warning') }}">
                        @if($siswa->status_lulus == 'LULUS') <i class="bi bi-patch-check-fill"></i> SELAMAT! ANDA LULUS
                        @elseif($siswa->status_lulus == 'TIDAK DITERIMA') <i class="bi bi-x-circle-fill"></i> MAAF, BELUM LULUS
                        @else <i class="bi bi-hourglass-split"></i> SEDANG DIPROSES
                        @endif
                    </h4>
                </div>
                @if($siswa->status_lulus == 'LULUS')
                <a href="{{ url('/cetak/'.$siswa->id) }}" target="_blank" class="btn btn-primary rounded-pill px-4 fw-bold">
                    <i class="bi bi-printer me-2"></i> Cetak Bukti Lulus
                </a>
                @elseif($siswa->status_lulus == 'Proses Seleksi')
                <a href="{{ url('/cetak/'.$siswa->id) }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                    <i class="bi bi-printer me-2"></i> Cetak Kartu Peserta
                </a>
                @endif
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill" data-bs-target="#pills-1" type="button"><i class="bi bi-person-lines-fill me-2"></i> 1. Data Diri</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button"><i class="bi bi-building me-2"></i> 2. Sekolah Asal</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button"><i class="bi bi-geo-alt me-2"></i> 3. Alamat</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button"><i class="bi bi-people me-2"></i> 4. Orang Tua</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5" type="button"><i class="bi bi-cloud-arrow-up me-2"></i> 5. Berkas</button></li>
        </ul>

        <form action="{{ url('/siswa/update-data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="tab-content" id="pills-tabContent">
                
                <div class="tab-pane fade show active" id="pills-1" role="tabpanel">
                    <div class="card card-form p-4">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">Lengkapi Data Diri</h5>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" value="{{ $siswa->nama_lengkap }}"></div>
                            <div class="col-md-6"><label class="form-label">NIK</label><input type="number" name="nik" class="form-control" value="{{ $siswa->nik }}"></div>
                            <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="{{ $siswa->tempat_lahir }}"></div>
                            <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tgl_lahir" class="form-control" value="{{ $siswa->tgl_lahir }}"></div>
                            <div class="col-md-6"><label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="Laki-laki" {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3"><label class="form-label">Anak Ke</label><input type="number" name="anak_ke" class="form-control" value="{{ $siswa->anak_ke }}"></div>
                            <div class="col-md-3"><label class="form-label">Dari Bersaudara</label><input type="number" name="jumlah_saudara" class="form-control" value="{{ $siswa->jumlah_saudara }}"></div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4 next-tab">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-2" role="tabpanel">
                    <div class="card card-form p-4">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">Data Sekolah Asal</h5>
                        <div class="alert alert-info small">Jika jenjang PAUD/TK, isi dengan tanda strip ( - ).</div>
                        <div class="row g-3">
                            <div class="col-md-12"><label class="form-label">Nama Sekolah Asal</label><input type="text" name="asal_sekolah" class="form-control" value="{{ $siswa->asal_sekolah }}"></div>
                            <div class="col-md-6"><label class="form-label">Status</label>
                                <select name="status_sekolah_asal" class="form-select">
                                    <option value="Negeri" {{ $siswa->status_sekolah_asal == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                    <option value="Swasta" {{ $siswa->status_sekolah_asal == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label">NPSN</label><input type="number" name="npsn_sekolah_asal" class="form-control" value="{{ $siswa->npsn_sekolah_asal }}"></div>
                            <div class="col-md-12"><label class="form-label">Alamat Sekolah (Kabupaten)</label><input type="text" name="kabupaten_sekolah_asal" class="form-control" value="{{ $siswa->kabupaten_sekolah_asal }}"></div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary prev-tab me-2">Kembali</button>
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4 next-tab">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-3" role="tabpanel">
                    <div class="card card-form p-4">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">Alamat Domisili</h5>
                        <div class="row g-3">
                            <div class="col-md-12"><label class="form-label">Jalan / Kampung</label><input type="text" name="alamat_jalan" class="form-control" value="{{ $siswa->alamat_jalan }}"></div>
                            <div class="col-md-4"><label class="form-label">RT / RW</label><input type="text" name="rt_rw" class="form-control" value="{{ $siswa->rt_rw }}"></div>
                            <div class="col-md-4"><label class="form-label">Desa / Kelurahan</label><input type="text" name="desa" class="form-control" value="{{ $siswa->desa }}"></div>
                            <div class="col-md-4"><label class="form-label">Kecamatan</label><input type="text" name="kecamatan" class="form-control" value="{{ $siswa->kecamatan }}"></div>
                            <div class="col-md-6"><label class="form-label">Kabupaten/Kota</label><input type="text" name="kabupaten" class="form-control" value="{{ $siswa->kabupaten }}"></div>
                            <div class="col-md-6"><label class="form-label">Provinsi</label><input type="text" name="provinsi" class="form-control" value="{{ $siswa->provinsi }}"></div>
                            <div class="col-md-4"><label class="form-label">Kode Pos</label><input type="number" name="kode_pos" class="form-control" value="{{ $siswa->kode_pos }}"></div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary prev-tab me-2">Kembali</button>
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4 next-tab">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-4" role="tabpanel">
                    <div class="card card-form p-4">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">Data Orang Tua</h5>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">No. Kartu Keluarga (KK)</label><input type="number" name="no_kk" class="form-control" value="{{ $siswa->no_kk }}"></div>
                            <div class="col-md-6"><label class="form-label">No. WA Ortu</label><input type="number" name="no_wa" class="form-control" value="{{ $siswa->no_wa }}"></div>
                            
                            <div class="col-12"><hr></div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Nama Ayah</label><input type="text" name="nama_ayah" class="form-control" value="{{ $siswa->nama_ayah }}">
                                <label class="form-label mt-2">Pekerjaan Ayah</label><input type="text" name="pekerjaan_ayah" class="form-control" value="{{ $siswa->pekerjaan_ayah }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Ibu</label><input type="text" name="nama_ibu" class="form-control" value="{{ $siswa->nama_ibu }}">
                                <label class="form-label mt-2">Pekerjaan Ibu</label><input type="text" name="pekerjaan_ibu" class="form-control" value="{{ $siswa->pekerjaan_ibu }}">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary prev-tab me-2">Kembali</button>
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4 next-tab">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-5" role="tabpanel">
                    <div class="card card-form p-4">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">Upload Berkas</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">1. KK & Akta Kelahiran</label>
                            @if($siswa->file_kk_akta) <span class="badge bg-success mb-2">Sudah Terupload</span> @endif
                            <input type="file" name="file_kk_akta" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">2. Ijazah / SKL</label>
                            @if($siswa->foto_ijazah) <span class="badge bg-success mb-2">Sudah Terupload</span> @endif
                            <input type="file" name="file_ijazah" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">3. KIP / KTP Ortu</label>
                            @if($siswa->file_kip_ktp) <span class="badge bg-success mb-2">Sudah Terupload</span> @endif
                            <input type="file" name="file_kip_ktp" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">4. Pas Foto</label>
                            @if($siswa->file_foto) <span class="badge bg-success mb-2">Sudah Terupload</span> @endif
                            <input type="file" name="file_foto" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">5. SKKB Sekolah Asal</label>
                            @if($siswa->file_skkb) <span class="badge bg-success mb-2">Sudah Terupload</span> @endif
                            <input type="file" name="file_skkb" class="form-control">
                        </div>

                        <div class="mt-5 text-end border-top pt-3">
                            <button type="button" class="btn btn-secondary prev-tab me-2">Kembali</button>
                            <button type="submit" class="btn btn-primary fw-bold px-5 py-2 shadow">
                                <i class="bi bi-save2-fill me-2"></i> SIMPAN SEMUA DATA
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script Sederhana untuk Tombol Lanjut/Kembali
        const tabEls = document.querySelectorAll('button[data-bs-toggle="pill"]');
        
        document.querySelectorAll('.next-tab').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const nextTab = new bootstrap.Tab(tabEls[index + 1]);
                nextTab.show();
                window.scrollTo(0, 0);
            });
        });

        document.querySelectorAll('.prev-tab').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const prevTab = new bootstrap.Tab(tabEls[index]);
                prevTab.show();
                window.scrollTo(0, 0);
            });
        });
    </script>
</body>
</html>