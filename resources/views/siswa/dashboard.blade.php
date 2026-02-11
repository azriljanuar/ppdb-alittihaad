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
        @php
            $jenjang = $siswa->jenjang;
            $isPaud = in_array($jenjang, ['PAUD', 'TK', 'KB', 'RA', 'RA/TK', 'MDU']);
            $isTk = in_array($jenjang, ['TK', 'RA', 'RA/TK']);
            $isMdu = ($jenjang == 'MDU');
            $showSekolahAsal = !$isTk; // Hide Sekolah Asal for TK/RA, Show for MDU
            $showPeriodik = !$isTk && !$isMdu; // Hide Data Periodik tab for TK/RA and MDU (MDU moved to Data Diri)

            // Navigation Logic
            $renderPeriodik = $showPeriodik && $isPaud;
            
            // Nav 1 (Data Diri) Next
            // MDU: -> Alamat (#pills-3)
            // TK: -> Orang Tua (#pills-4)
            // Std: -> Sekolah Asal (#pills-2)
            $nav_1_next = $isMdu ? '#pills-3' : ($isTk ? '#pills-4' : '#pills-2');

            // Nav 2 (Sekolah Asal)
            // MDU: Prev -> Orang Tua (#pills-4), Next -> Berkas (#pills-5)
            // Std: Prev -> Data Diri (#pills-1), Next -> Alamat (#pills-3)
            $nav_2_prev = $isMdu ? '#pills-4' : '#pills-1';
            $nav_2_next = $isMdu ? '#pills-5' : '#pills-3';

            // Nav 3 (Alamat)
            // MDU: Prev -> Data Diri (#pills-1), Next -> Orang Tua (#pills-4)
            // TK: Prev -> Orang Tua (#pills-4), Next -> Berkas (#pills-5)
            // Std: Prev -> Sekolah Asal (#pills-2), Next -> Orang Tua (#pills-4)
            $nav_3_prev = $isMdu ? '#pills-1' : ($isTk ? '#pills-4' : '#pills-2');
            $nav_3_next = $isMdu ? '#pills-4' : ($isTk ? '#pills-5' : '#pills-4');

            // Nav 4 (Orang Tua)
            // MDU: Prev -> Alamat (#pills-3), Next -> Sekolah Asal (#pills-2)
            // TK: Prev -> Data Diri (#pills-1), Next -> Alamat (#pills-3)
            // Std: Prev -> Alamat (#pills-3), Next -> Periodik (#pills-periodik) or Berkas (#pills-5)
            $nav_4_prev = $isMdu ? '#pills-3' : ($isTk ? '#pills-1' : '#pills-3');
            $nav_4_next = $isMdu ? '#pills-2' : ($isTk ? '#pills-3' : ($renderPeriodik ? '#pills-periodik' : '#pills-5'));
            
            // Nav 5 (Berkas)
            // MDU: Prev -> Sekolah Asal (#pills-2)
            // TK: Prev -> Alamat (#pills-3)
            // Std: Prev -> Periodik or Orang Tua
            $nav_5_prev = $isMdu ? '#pills-2' : ($renderPeriodik ? '#pills-periodik' : ($isTk ? '#pills-3' : '#pills-4'));
        @endphp
        
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
            
            @if($isMdu)
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button"><i class="bi bi-geo-alt me-2"></i> 2. Alamat</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button"><i class="bi bi-people me-2"></i> 3. Orang Tua</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button"><i class="bi bi-building me-2"></i> 4. Sekolah Asal</button></li>
            @elseif(!$isTk)
                @if($showSekolahAsal)
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2" type="button"><i class="bi bi-building me-2"></i> 2. Sekolah Asal</button></li>
                @endif
                
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button"><i class="bi bi-geo-alt me-2"></i> 3. Alamat</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button"><i class="bi bi-people me-2"></i> 4. Orang Tua</button></li>
            @else
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-4-tab" data-bs-toggle="pill" data-bs-target="#pills-4" type="button"><i class="bi bi-people me-2"></i> 2. Orang Tua</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="pills-3-tab" data-bs-toggle="pill" data-bs-target="#pills-3" type="button"><i class="bi bi-geo-alt me-2"></i> 3. Alamat</button></li>
            @endif
            
            @if($showPeriodik && $isPaud)
            <li class="nav-item" role="presentation"><button class="nav-link" id="pills-periodik-tab" data-bs-toggle="pill" data-bs-target="#pills-periodik" type="button"><i class="bi bi-graph-up me-2"></i> 5. Data Periodik</button></li>
            @endif

            <li class="nav-item" role="presentation"><button class="nav-link" id="pills-5-tab" data-bs-toggle="pill" data-bs-target="#pills-5" type="button"><i class="bi bi-cloud-arrow-up me-2"></i> {{ ($isMdu) ? '5. Berkas' : (($isTk || !$showSekolahAsal) ? '4. Berkas' : ($showPeriodik ? '6. Berkas' : '5. Berkas')) }}</button></li>
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
                            
                            @if($isPaud)
                            <div class="col-12"><hr class="my-2"></div>
                            <div class="col-md-6"><label class="form-label">Nama Panggilan</label><input type="text" name="nama_panggilan" class="form-control" value="{{ $siswa->nama_panggilan }}"></div>
                            <div class="col-md-6"><label class="form-label">Warga Negara</label><input type="text" name="warga_negara" class="form-control" value="{{ $siswa->warga_negara }}"></div>
                            <div class="col-md-6"><label class="form-label">Agama</label><input type="text" name="agama" class="form-control" value="{{ $siswa->agama }}"></div>
                            <div class="col-md-6"><label class="form-label">Bahasa Sehari-hari</label><input type="text" name="bahasa_sehari_hari" class="form-control" value="{{ $siswa->bahasa_sehari_hari }}"></div>
                            <div class="col-md-6"><label class="form-label">Status Anak</label>
                                <select name="status_anak" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Lengkap" {{ $siswa->status_anak == 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                                    <option value="Yatim" {{ $siswa->status_anak == 'Yatim' ? 'selected' : '' }}>Yatim</option>
                                    <option value="Piatu" {{ $siswa->status_anak == 'Piatu' ? 'selected' : '' }}>Piatu</option>
                                    <option value="Yatim Piatu" {{ $siswa->status_anak == 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label">Berkebutuhan Khusus</label><input type="text" name="berkebutuhan_khusus" class="form-control" value="{{ $siswa->berkebutuhan_khusus }}" placeholder="Tidak Ada (jika normal)"></div>
                            <div class="col-md-4"><label class="form-label">Jml Sdr Kandung</label><input type="number" name="jumlah_saudara_kandung" class="form-control" value="{{ $siswa->jumlah_saudara_kandung }}"></div>
                            <div class="col-md-4"><label class="form-label">Jml Sdr Tiri</label><input type="number" name="jumlah_saudara_tiri" class="form-control" value="{{ $siswa->jumlah_saudara_tiri }}"></div>
                            <div class="col-md-4"><label class="form-label">Jml Sdr Angkat</label><input type="number" name="jumlah_saudara_angkat" class="form-control" value="{{ $siswa->jumlah_saudara_angkat }}"></div>
                            <div class="col-md-4"><label class="form-label">No Telp Rumah</label><input type="text" name="no_telp_rumah" class="form-control" value="{{ $siswa->no_telp_rumah }}"></div>
                            <div class="col-md-4"><label class="form-label">Status Tpt Tinggal</label><input type="text" name="status_tempat_tinggal" class="form-control" value="{{ $siswa->status_tempat_tinggal }}" placeholder="Milik Sendiri/Sewa"></div>
                            <div class="col-md-4"><label class="form-label">Moda Transportasi</label><input type="text" name="moda_transportasi" class="form-control" value="{{ $siswa->moda_transportasi }}"></div>
                            
                            @if($isMdu)
                            <div class="col-12"><hr class="my-2"><h6 class="text-success fw-bold">Data Fisik & Jarak</h6></div>
                            <div class="col-md-4"><label class="form-label">Tinggi Badan (cm)</label><input type="number" step="0.01" name="tinggi_badan" class="form-control" value="{{ $siswa->tinggi_badan }}"></div>
                            <div class="col-md-4"><label class="form-label">Berat Badan (kg)</label><input type="number" step="0.01" name="berat_badan" class="form-control" value="{{ $siswa->berat_badan }}"></div>
                            <div class="col-md-4"><label class="form-label">Lingkar Kepala (cm)</label><input type="number" step="0.01" name="lingkar_kepala" class="form-control" value="{{ $siswa->lingkar_kepala }}"></div>
                            
                            <div class="col-md-6"><label class="form-label">Jarak ke Sekolah</label>
                                <select name="jarak_ke_sekolah" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Kurang dari 1 km" {{ $siswa->jarak_ke_sekolah == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                                    <option value="Lebih dari 1 km" {{ $siswa->jarak_ke_sekolah == 'Lebih dari 1 km' ? 'selected' : '' }}>Lebih dari 1 km</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label">Jarak (km) - Jika lebih dari 1 km</label><input type="number" step="0.01" name="jarak_ke_sekolah_km" class="form-control" value="{{ $siswa->jarak_ke_sekolah_km }}"></div>
                            <div class="col-md-6"><label class="form-label">Waktu Tempuh (Jam/Menit)</label><input type="text" name="waktu_tempuh" class="form-control" value="{{ $siswa->waktu_tempuh }}"></div>
                            
                            <div class="col-md-6"><label class="form-label">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select">
                                    <option value="">- Pilih -</option>
                                    @foreach(['A','B','AB','O'] as $gd)
                                        <option value="{{ $gd }}" {{ $siswa->golongan_darah == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12"><label class="form-label">Riwayat Penyakit</label><textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Tuliskan jika ada...">{{ $siswa->riwayat_penyakit }}</textarea></div>
                            @endif

                            @endif
                        </div>
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4" onclick="switchTab('{{ $nav_1_next }}')">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                @if($showSekolahAsal)
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
                            
                            @if($isMdu)
                            <div class="col-12"><hr class="my-2"><h6 class="text-success fw-bold">Asal Mula Anak & Penerimaan</h6></div>
                            <div class="col-md-6"><label class="form-label">Masuk Sebagai</label>
                                <select name="status_masuk_sekolah" class="form-select">
                                    <option value="Siswa Baru" {{ $siswa->status_masuk_sekolah == 'Siswa Baru' ? 'selected' : '' }}>Siswa Baru</option>
                                    <option value="Pindahan" {{ $siswa->status_masuk_sekolah == 'Pindahan' ? 'selected' : '' }}>Pindahan</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label">Pindahan Dari Sekolah</label><input type="text" name="pindahan_dari_sekolah" class="form-control" value="{{ $siswa->pindahan_dari_sekolah }}" placeholder="Isi jika pindahan"></div>
                            <div class="col-md-6"><label class="form-label">Tanggal Pindah</label><input type="date" name="pindahan_dari_tanggal" class="form-control" value="{{ $siswa->pindahan_dari_tanggal }}"></div>
                            <div class="col-md-6"><label class="form-label">Dari Kelas</label><input type="text" name="pindahan_dari_kelas" class="form-control" value="{{ $siswa->pindahan_dari_kelas }}"></div>
                            
                            <div class="col-md-6"><label class="form-label">Diterima Tanggal</label><input type="date" name="diterima_tanggal" class="form-control" value="{{ $siswa->diterima_tanggal }}"></div>
                            <div class="col-md-6"><label class="form-label">Diterima Di Kelas</label><input type="text" name="diterima_kelas" class="form-control" value="{{ $siswa->diterima_kelas }}"></div>
                            @endif
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="switchTab('{{ $nav_2_prev }}')">Kembali</button>
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4" onclick="switchTab('{{ $nav_2_next }}')">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                @endif

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
                            <button type="button" class="btn btn-secondary me-2" onclick="switchTab('{{ $nav_3_prev }}')">Kembali</button>
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4" onclick="switchTab('{{ $nav_3_next }}')">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-4" role="tabpanel">
                    <div class="card card-form p-4">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">Data Orang Tua</h5>
                        @if($isPaud)
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">No. Kartu Keluarga (KK)</label><input type="number" name="no_kk" class="form-control" value="{{ $siswa->no_kk }}"></div>
                            <div class="col-md-6"><label class="form-label">No. WA Ortu</label><input type="number" name="no_wa" class="form-control" value="{{ $siswa->no_wa }}"></div>
                            
                            <!-- DATA AYAH -->
                            <div class="col-12"><h6 class="fw-bold text-success mt-3 border-bottom pb-2">A. DATA AYAH KANDUNG</h6></div>
                            <div class="col-md-6"><label class="form-label">Nama Lengkap Ayah</label><input type="text" name="nama_ayah" class="form-control" value="{{ $siswa->nama_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">NIK Ayah</label><input type="number" name="nik_ayah" class="form-control" value="{{ $siswa->nik_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir_ayah" class="form-control" value="{{ $siswa->tempat_lahir_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tgl_lahir_ayah" class="form-control" value="{{ $siswa->tgl_lahir_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">Agama</label><input type="text" name="agama_ayah" class="form-control" value="{{ $siswa->agama_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">Warga Negara</label><input type="text" name="warga_negara_ayah" class="form-control" value="{{ $siswa->warga_negara_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">Pendidikan Terakhir</label><input type="text" name="pendidikan_ayah" class="form-control" value="{{ $siswa->pendidikan_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan_ayah" class="form-control" value="{{ $siswa->pekerjaan_ayah }}"></div>
                            <div class="col-md-6"><label class="form-label">Penghasilan Bulanan</label><input type="text" name="penghasilan_ayah" class="form-control" value="{{ $siswa->penghasilan_ayah }}"></div>
                            <div class="col-md-12"><label class="form-label">Alamat Rumah</label><input type="text" name="alamat_rumah_ayah" class="form-control" value="{{ $siswa->alamat_rumah_ayah }}"></div>
                            <div class="col-md-12"><label class="form-label">Alamat Kantor (jika ada)</label><input type="text" name="alamat_kantor_ayah" class="form-control" value="{{ $siswa->alamat_kantor_ayah }}"></div>

                            <!-- DATA IBU -->
                            <div class="col-12"><h6 class="fw-bold text-success mt-3 border-bottom pb-2">B. DATA IBU KANDUNG</h6></div>
                            <div class="col-md-6"><label class="form-label">Nama Lengkap Ibu</label><input type="text" name="nama_ibu" class="form-control" value="{{ $siswa->nama_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">NIK Ibu</label><input type="number" name="nik_ibu" class="form-control" value="{{ $siswa->nik_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir_ibu" class="form-control" value="{{ $siswa->tempat_lahir_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" name="tgl_lahir_ibu" class="form-control" value="{{ $siswa->tgl_lahir_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">Agama</label><input type="text" name="agama_ibu" class="form-control" value="{{ $siswa->agama_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">Warga Negara</label><input type="text" name="warga_negara_ibu" class="form-control" value="{{ $siswa->warga_negara_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">Pendidikan Terakhir</label><input type="text" name="pendidikan_ibu" class="form-control" value="{{ $siswa->pendidikan_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan_ibu" class="form-control" value="{{ $siswa->pekerjaan_ibu }}"></div>
                            <div class="col-md-6"><label class="form-label">Penghasilan Bulanan</label><input type="text" name="penghasilan_ibu" class="form-control" value="{{ $siswa->penghasilan_ibu }}"></div>
                            <div class="col-md-12"><label class="form-label">Alamat Rumah</label><input type="text" name="alamat_rumah_ibu" class="form-control" value="{{ $siswa->alamat_rumah_ibu }}"></div>
                            <div class="col-md-12"><label class="form-label">Alamat Kantor (jika ada)</label><input type="text" name="alamat_kantor_ibu" class="form-control" value="{{ $siswa->alamat_kantor_ibu }}"></div>
                            
                            @if($isMdu)
                            <!-- DATA WALI -->
                            <div class="col-12"><h6 class="fw-bold text-success mt-3 border-bottom pb-2">C. DATA WALI (Jika ada)</h6></div>
                            <div class="col-md-12"><label class="form-label">Nama Wali</label><input type="text" name="nama_wali" class="form-control" value="{{ $siswa->nama_wali }}"></div>
                            @endif
                        </div>
                        @else
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
                        @endif
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="switchTab('{{ $nav_4_prev }}')">Kembali</button>
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4" onclick="switchTab('{{ $nav_4_next }}')">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                @if($showPeriodik && $isPaud)
                <div class="tab-pane fade" id="pills-periodik" role="tabpanel">
                    <div class="card card-form p-4">
                        <h5 class="fw-bold text-success border-bottom pb-3 mb-4">Data Periodik</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Tinggi Badan (cm)</label><input type="number" step="0.01" name="tinggi_badan" class="form-control" value="{{ $siswa->tinggi_badan }}"></div>
                            <div class="col-md-4"><label class="form-label">Berat Badan (kg)</label><input type="number" step="0.01" name="berat_badan" class="form-control" value="{{ $siswa->berat_badan }}"></div>
                            <div class="col-md-4"><label class="form-label">Lingkar Kepala (cm)</label><input type="number" step="0.01" name="lingkar_kepala" class="form-control" value="{{ $siswa->lingkar_kepala }}"></div>
                            
                            <div class="col-md-6"><label class="form-label">Jarak ke Sekolah</label>
                                <select name="jarak_ke_sekolah" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Kurang dari 1 km" {{ $siswa->jarak_ke_sekolah == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                                    <option value="Lebih dari 1 km" {{ $siswa->jarak_ke_sekolah == 'Lebih dari 1 km' ? 'selected' : '' }}>Lebih dari 1 km</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label">Jarak (km) - Jika lebih dari 1 km</label><input type="number" step="0.01" name="jarak_ke_sekolah_km" class="form-control" value="{{ $siswa->jarak_ke_sekolah_km }}"></div>
                            <div class="col-md-6"><label class="form-label">Waktu Tempuh (Jam/Menit)</label><input type="text" name="waktu_tempuh" class="form-control" value="{{ $siswa->waktu_tempuh }}"></div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="switchTab('#pills-4')">Kembali</button>
                            <button type="submit" class="btn btn-primary px-3 me-2">
                                <i class="bi bi-save2-fill me-1"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-success px-4" onclick="switchTab('#pills-5')">Lanjut <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                @endif

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
                            <button type="button" class="btn btn-secondary me-2" onclick="switchTab('{{ $nav_5_prev }}')">Kembali</button>
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
        function switchTab(targetId) {
            // Find the tab button that targets this pane
            const triggerEl = document.querySelector(`button[data-bs-target="${targetId}"]`);
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
                window.scrollTo(0, 0);
            }
        }
    </script>
</body>
</html>