@extends('layout_admin')

@section('content')
@php
    $isPaud = in_array($pendaftar->jenjang, ['PAUD', 'TK', 'KB', 'RA', 'RA/TK', 'MDU', 'SDIT']);
    $isTk = in_array($pendaftar->jenjang, ['TK', 'RA', 'RA/TK']);
    $isMdu = ($pendaftar->jenjang == 'MDU');
    $isSdit = ($pendaftar->jenjang == 'SDIT');
    $isMts = ($pendaftar->jenjang == 'MTS');
    $isMa = ($pendaftar->jenjang == 'MA');
    $isMtsOrMa = ($isMts || $isMa);
    $showSekolahAsal = !$isTk;
    $showPeriodik = !$isTk && !$isMdu && !$isSdit && !$isMtsOrMa;
    $showPrestasi = $isMtsOrMa;
@endphp
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Edit Data Lengkap</h3>
            <p class="text-muted small mb-0">Perbarui biodata, sekolah asal, orang tua, dan berkas santri.</p>
        </div>
        <a href="{{ url('/admin') }}" class="btn btn-light border fw-bold rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <form action="{{ url('/pendaftar/' . $pendaftar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            <div class="col-xl-8">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-primary"><i class="bi bi-person-circle me-2"></i> 1. DATA PRIBADI</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="{{ $pendaftar->nama_lengkap }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted fw-bold text-uppercase">NIK</label>
                                <input type="number" name="nik" class="form-control" value="{{ $pendaftar->nik }}">
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted fw-bold text-uppercase">Password (Login)</label>
                                <input type="text" name="password" class="form-control border-warning" value="{{ $pendaftar->password }}" placeholder="Min 6 Karakter">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="Laki-laki" {{ $pendaftar->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $pendaftar->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ $pendaftar->tempat_lahir }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="{{ $pendaftar->tgl_lahir }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Anak Ke</label>
                                <input type="number" name="anak_ke" class="form-control" value="{{ $pendaftar->anak_ke }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Jml Saudara</label>
                                <input type="number" name="jumlah_saudara" class="form-control" value="{{ $pendaftar->jumlah_saudara }}">
                            </div>

                            @if($isMa)
                            <div class="col-md-3"><label class="small text-muted fw-bold text-uppercase">Jml Adik</label><input type="number" name="jumlah_adik" class="form-control" value="{{ $pendaftar->jumlah_adik }}"></div>
                            <div class="col-md-3"><label class="small text-muted fw-bold text-uppercase">Jml Kakak</label><input type="number" name="jumlah_kakak" class="form-control" value="{{ $pendaftar->jumlah_kakak }}"></div>
                            @endif

                            @if($isMtsOrMa)
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Hobi</label><input type="text" name="hobi" class="form-control" value="{{ $pendaftar->hobi }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Cita-cita</label><input type="text" name="cita_cita" class="form-control" value="{{ $pendaftar->cita_cita }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Ranking Sem. Lalu</label><input type="number" name="ranking_semester_lalu" class="form-control" value="{{ $pendaftar->ranking_semester_lalu }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Dari Jumlah Siswa</label><input type="number" name="jumlah_siswa_ranking" class="form-control" value="{{ $pendaftar->jumlah_siswa_ranking }}"></div>
                            @endif
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Jenjang</label>
                                <select name="jenjang" class="form-select bg-warning bg-opacity-10">
                                    @foreach(['PAUD', 'TK', 'KB', 'RA', 'RA/TK', 'SDIT', 'MDU', 'MTS', 'MA'] as $j)
                                        <option value="{{ $j }}" {{ $pendaftar->jenjang == $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            @if($isPaud)
                            <div class="col-12"><hr class="my-1"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Nama Panggilan</label><input type="text" name="nama_panggilan" class="form-control" value="{{ $pendaftar->nama_panggilan }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Warga Negara</label><input type="text" name="warga_negara" class="form-control" value="{{ $pendaftar->warga_negara }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Agama</label><input type="text" name="agama" class="form-control" value="{{ $pendaftar->agama }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Bahasa Sehari-hari</label><input type="text" name="bahasa_sehari_hari" class="form-control" value="{{ $pendaftar->bahasa_sehari_hari }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Status Anak</label>
                                <select name="status_anak" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Lengkap" {{ $pendaftar->status_anak == 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                                    <option value="Yatim" {{ $pendaftar->status_anak == 'Yatim' ? 'selected' : '' }}>Yatim</option>
                                    <option value="Piatu" {{ $pendaftar->status_anak == 'Piatu' ? 'selected' : '' }}>Piatu</option>
                                    <option value="Yatim Piatu" {{ $pendaftar->status_anak == 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Berkebutuhan Khusus</label><input type="text" name="berkebutuhan_khusus" class="form-control" value="{{ $pendaftar->berkebutuhan_khusus }}" placeholder="Tidak Ada (jika normal)"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Jml Sdr Kandung</label><input type="number" name="jumlah_saudara_kandung" class="form-control" value="{{ $pendaftar->jumlah_saudara_kandung }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Jml Sdr Tiri</label><input type="number" name="jumlah_saudara_tiri" class="form-control" value="{{ $pendaftar->jumlah_saudara_tiri }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Jml Sdr Angkat</label><input type="number" name="jumlah_saudara_angkat" class="form-control" value="{{ $pendaftar->jumlah_saudara_angkat }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">No Telp Rumah</label><input type="text" name="no_telp_rumah" class="form-control" value="{{ $pendaftar->no_telp_rumah }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Status Tpt Tinggal</label><input type="text" name="status_tempat_tinggal" class="form-control" value="{{ $pendaftar->status_tempat_tinggal }}" placeholder="Milik Sendiri/Sewa"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Moda Transportasi</label><input type="text" name="moda_transportasi" class="form-control" value="{{ $pendaftar->moda_transportasi }}"></div>
                            
                            @if($isMdu || $isSdit)
                            <div class="col-12"><hr class="my-1"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Tinggi Badan (cm)</label><input type="number" step="0.01" name="tinggi_badan" class="form-control" value="{{ $pendaftar->tinggi_badan }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Berat Badan (kg)</label><input type="number" step="0.01" name="berat_badan" class="form-control" value="{{ $pendaftar->berat_badan }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Lingkar Kepala (cm)</label><input type="number" step="0.01" name="lingkar_kepala" class="form-control" value="{{ $pendaftar->lingkar_kepala }}"></div>
                            
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Jarak ke Sekolah</label>
                                <select name="jarak_ke_sekolah" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Kurang dari 1 km" {{ $pendaftar->jarak_ke_sekolah == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                                    <option value="Lebih dari 1 km" {{ $pendaftar->jarak_ke_sekolah == 'Lebih dari 1 km' ? 'selected' : '' }}>Lebih dari 1 km</option>
                                </select>
                            </div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Jarak (km) - Jika lebih dari 1 km</label><input type="number" step="0.01" name="jarak_ke_sekolah_km" class="form-control" value="{{ $pendaftar->jarak_ke_sekolah_km }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Waktu Tempuh (Jam/Menit)</label><input type="text" name="waktu_tempuh" class="form-control" value="{{ $pendaftar->waktu_tempuh }}"></div>

                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Golongan Darah</label>
                                <select name="golongan_darah" class="form-select">
                                    <option value="">- Pilih -</option>
                                    @foreach(['A','B','AB','O'] as $gd)
                                        <option value="{{ $gd }}" {{ $pendaftar->golongan_darah == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8"><label class="small text-muted fw-bold text-uppercase">Riwayat Penyakit</label><textarea name="riwayat_penyakit" class="form-control" rows="2">{{ $pendaftar->riwayat_penyakit }}</textarea></div>
                            @endif

                            @endif
                        </div>
                    </div>
                </div>

                @if(!$isTk)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-success"><i class="bi bi-building me-2"></i> 2. SEKOLAH ASAL</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @if($isMtsOrMa)
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">Jenjang Sekolah Asal</label>
                                <select name="jenjang_sekolah_asal" class="form-select">
                                    <option value="">- Pilih -</option>
                                    @if($isMts)
                                    <option value="SD" {{ $pendaftar->jenjang_sekolah_asal == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="MI" {{ $pendaftar->jenjang_sekolah_asal == 'MI' ? 'selected' : '' }}>MI</option>
                                    <option value="SLB" {{ $pendaftar->jenjang_sekolah_asal == 'SLB' ? 'selected' : '' }}>SLB</option>
                                    <option value="Paket A" {{ $pendaftar->jenjang_sekolah_asal == 'Paket A' ? 'selected' : '' }}>Paket A</option>
                                    @elseif($isMa)
                                    <option value="SMP" {{ $pendaftar->jenjang_sekolah_asal == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="MTs" {{ $pendaftar->jenjang_sekolah_asal == 'MTs' ? 'selected' : '' }}>MTs</option>
                                    <option value="SMP IT" {{ $pendaftar->jenjang_sekolah_asal == 'SMP IT' ? 'selected' : '' }}>SMP IT</option>
                                    <option value="Paket B" {{ $pendaftar->jenjang_sekolah_asal == 'Paket B' ? 'selected' : '' }}>Paket B</option>
                                    <option value="Wustho" {{ $pendaftar->jenjang_sekolah_asal == 'Wustho' ? 'selected' : '' }}>Wustho</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">{{ $isMa ? 'No. SKHUN' : 'NISN' }}</label>
                                <input type="text" name="{{ $isMa ? 'no_skhun' : 'nisn' }}" class="form-control" value="{{ $isMa ? $pendaftar->no_skhun : $pendaftar->nisn }}">
                            </div>
                            @endif
                            <div class="col-md-12">
                                <label class="small text-muted fw-bold text-uppercase">Nama Sekolah Asal</label>
                                <input type="text" name="asal_sekolah" class="form-control" value="{{ $pendaftar->asal_sekolah }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Status</label>
                                <select name="status_sekolah_asal" class="form-select">
                                    <option value="Negeri" {{ $pendaftar->status_sekolah_asal == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                                    <option value="Swasta" {{ $pendaftar->status_sekolah_asal == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                                    <option value="-" {{ $pendaftar->status_sekolah_asal == '-' ? 'selected' : '' }}>-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">NPSN</label>
                                <input type="number" name="npsn_sekolah_asal" class="form-control" value="{{ $pendaftar->npsn_sekolah_asal }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Kabupaten (Alamat Sekolah)</label>
                                <input type="text" name="kabupaten_sekolah_asal" class="form-control" value="{{ $pendaftar->kabupaten_sekolah_asal }}">
                            </div>
                            
                            @if($isSdit)
                            <div class="col-md-12"><label class="small text-muted fw-bold text-uppercase">No. Ijazah Sebelumnya (TK/RA)</label><input type="text" name="no_ijazah_sebelumnya" class="form-control" value="{{ $pendaftar->no_ijazah_sebelumnya }}"></div>
                            @endif

                            @if($isMdu || $isSdit)
                            <div class="col-12"><hr class="my-1"></div>

                            @if($isSdit)
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Asal Anak</label>
                                <select name="asal_anak" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Rumah Tangga" {{ $pendaftar->asal_anak == 'Rumah Tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                                    <option value="Taman Kanak-kanak" {{ $pendaftar->asal_anak == 'Taman Kanak-kanak' ? 'selected' : '' }}>Taman Kanak-kanak</option>
                                </select>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">Masuk Sebagai</label>
                                <select name="status_masuk_sekolah" class="form-select">
                                    <option value="Siswa Baru" {{ $pendaftar->status_masuk_sekolah == 'Siswa Baru' ? 'selected' : '' }}>Siswa Baru</option>
                                    <option value="Pindahan" {{ $pendaftar->status_masuk_sekolah == 'Pindahan' ? 'selected' : '' }}>Pindahan</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Pindahan Dari Sekolah</label><input type="text" name="pindahan_dari_sekolah" class="form-control" value="{{ $pendaftar->pindahan_dari_sekolah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Tanggal Pindah</label><input type="date" name="pindahan_dari_tanggal" class="form-control" value="{{ $pendaftar->pindahan_dari_tanggal }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Dari Kelas</label><input type="text" name="pindahan_dari_kelas" class="form-control" value="{{ $pendaftar->pindahan_dari_kelas }}"></div>
                            
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Diterima Tanggal</label><input type="date" name="diterima_tanggal" class="form-control" value="{{ $pendaftar->diterima_tanggal }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Diterima Di Kelas</label><input type="text" name="diterima_kelas" class="form-control" value="{{ $pendaftar->diterima_kelas }}"></div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-info"><i class="bi bi-geo-alt-fill me-2"></i> 3. ALAMAT DOMISILI</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="small text-muted fw-bold text-uppercase">Jalan / Kampung</label>
                                <input type="text" name="alamat_jalan" class="form-control" value="{{ $pendaftar->alamat_jalan }}">
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted fw-bold text-uppercase">RT / RW</label>
                                <input type="text" name="rt_rw" class="form-control" value="{{ $pendaftar->rt_rw }}">
                            </div>
                            <div class="col-md-5">
                                <label class="small text-muted fw-bold text-uppercase">Desa/Kelurahan</label>
                                <input type="text" name="desa" class="form-control" value="{{ $pendaftar->desa }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" value="{{ $pendaftar->kecamatan }}">
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">Kabupaten/Kota</label>
                                <input type="text" name="kabupaten" class="form-control" value="{{ $pendaftar->kabupaten }}">
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control" value="{{ $pendaftar->provinsi }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Kode Pos</label>
                                <input type="number" name="kode_pos" class="form-control" value="{{ $pendaftar->kode_pos }}">
                            </div>
                            @if(!$isPaud)
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Jarak Sekolah</label>
                                <select name="jarak_ke_sekolah" class="form-select">
                                    <option value="< 1 km" {{ $pendaftar->jarak_ke_sekolah == '< 1 km' ? 'selected' : '' }}>< 1 Km</option>
                                    <option value="1 - 5 km" {{ $pendaftar->jarak_ke_sekolah == '1 - 5 km' ? 'selected' : '' }}>1 - 5 Km</option>
                                    <option value="> 5 km" {{ $pendaftar->jarak_ke_sekolah == '> 5 km' ? 'selected' : '' }}>> 5 Km</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Transportasi</label>
                                <input type="text" name="transportasi" class="form-control" value="{{ $pendaftar->transportasi }}">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-warning text-dark"><i class="bi bi-people-fill me-2"></i> 4. DATA ORANG TUA</h6>
                    </div>
                    <div class="card-body">
                        @if($isPaud || $isMts)
                        <div class="row g-3">
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">No. Kartu Keluarga (KK)</label><input type="number" name="no_kk" class="form-control" value="{{ $pendaftar->no_kk }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">No. WA Ortu</label><input type="number" name="no_wa" class="form-control" value="{{ $pendaftar->no_wa }}"></div>
                            
                            <!-- DATA AYAH -->
                            <div class="col-12"><h6 class="fw-bold text-success mt-3 border-bottom pb-2">A. DATA AYAH KANDUNG</h6></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Nama Lengkap Ayah</label><input type="text" name="nama_ayah" class="form-control" value="{{ $pendaftar->nama_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">NIK Ayah</label><input type="number" name="nik_ayah" class="form-control" value="{{ $pendaftar->nik_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Tempat Lahir</label><input type="text" name="tempat_lahir_ayah" class="form-control" value="{{ $pendaftar->tempat_lahir_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Tanggal Lahir</label><input type="date" name="tgl_lahir_ayah" class="form-control" value="{{ $pendaftar->tgl_lahir_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Agama</label><input type="text" name="agama_ayah" class="form-control" value="{{ $pendaftar->agama_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Warga Negara</label><input type="text" name="warga_negara_ayah" class="form-control" value="{{ $pendaftar->warga_negara_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Pendidikan Terakhir</label><input type="text" name="pendidikan_ayah" class="form-control" value="{{ $pendaftar->pendidikan_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Pekerjaan</label><input type="text" name="pekerjaan_ayah" class="form-control" value="{{ $pendaftar->pekerjaan_ayah }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Penghasilan Bulanan</label><input type="text" name="penghasilan_ayah" class="form-control" value="{{ $pendaftar->penghasilan_ayah }}"></div>
                            <div class="col-md-12"><label class="small text-muted fw-bold text-uppercase">Alamat Rumah</label><input type="text" name="alamat_rumah_ayah" class="form-control" value="{{ $pendaftar->alamat_rumah_ayah }}"></div>
                            <div class="col-md-12"><label class="small text-muted fw-bold text-uppercase">Alamat Kantor (jika ada)</label><input type="text" name="alamat_kantor_ayah" class="form-control" value="{{ $pendaftar->alamat_kantor_ayah }}"></div>
                            
                            <!-- DATA IBU -->
                            <div class="col-12"><h6 class="fw-bold text-success mt-3 border-bottom pb-2">B. DATA IBU KANDUNG</h6></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Nama Lengkap Ibu</label><input type="text" name="nama_ibu" class="form-control" value="{{ $pendaftar->nama_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">NIK Ibu</label><input type="number" name="nik_ibu" class="form-control" value="{{ $pendaftar->nik_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Tempat Lahir</label><input type="text" name="tempat_lahir_ibu" class="form-control" value="{{ $pendaftar->tempat_lahir_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Tanggal Lahir</label><input type="date" name="tgl_lahir_ibu" class="form-control" value="{{ $pendaftar->tgl_lahir_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Agama</label><input type="text" name="agama_ibu" class="form-control" value="{{ $pendaftar->agama_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Warga Negara</label><input type="text" name="warga_negara_ibu" class="form-control" value="{{ $pendaftar->warga_negara_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Pendidikan Terakhir</label><input type="text" name="pendidikan_ibu" class="form-control" value="{{ $pendaftar->pendidikan_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Pekerjaan</label><input type="text" name="pekerjaan_ibu" class="form-control" value="{{ $pendaftar->pekerjaan_ibu }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Penghasilan Bulanan</label><input type="text" name="penghasilan_ibu" class="form-control" value="{{ $pendaftar->penghasilan_ibu }}"></div>
                            <div class="col-md-12"><label class="small text-muted fw-bold text-uppercase">Alamat Rumah</label><input type="text" name="alamat_rumah_ibu" class="form-control" value="{{ $pendaftar->alamat_rumah_ibu }}"></div>
                            <div class="col-md-12"><label class="small text-muted fw-bold text-uppercase">Alamat Kantor (jika ada)</label><input type="text" name="alamat_kantor_ibu" class="form-control" value="{{ $pendaftar->alamat_kantor_ibu }}"></div>

                            @if($isMts)
                            <div class="col-md-12"><label class="small text-muted fw-bold text-uppercase">Penghasilan Keluarga / Bulan</label><input type="text" name="penghasilan_keluarga" class="form-control" value="{{ $pendaftar->penghasilan_keluarga }}"></div>
                            @endif

                            @if($isMdu || $isSdit)
                            <!-- DATA WALI -->
                            <div class="col-12"><h6 class="fw-bold text-success mt-3 border-bottom pb-2">C. DATA WALI (Jika ada)</h6></div>
                            <div class="col-md-12"><label class="small text-muted fw-bold text-uppercase">Nama Wali</label><input type="text" name="nama_wali" class="form-control" value="{{ $pendaftar->nama_wali }}"></div>
                            
                            @if($isSdit)
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">NIK Wali</label><input type="number" name="nik_wali" class="form-control" value="{{ $pendaftar->nik_wali }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Pekerjaan Wali</label><input type="text" name="pekerjaan_wali" class="form-control" value="{{ $pendaftar->pekerjaan_wali }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Penghasilan Wali</label><input type="text" name="penghasilan_wali" class="form-control" value="{{ $pendaftar->penghasilan_wali }}"></div>
                            @endif

                            @endif
                        </div>
                        @else
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">Nomor KK</label>
                                <input type="number" name="no_kk" class="form-control" value="{{ $pendaftar->no_kk }}">
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase">No. WhatsApp</label>
                                <input type="number" name="no_wa" class="form-control" value="{{ $pendaftar->no_wa }}">
                            </div>
                            
                            <div class="col-md-12"><hr class="my-1"> <small class="fw-bold text-success">DATA AYAH</small></div>
                            <div class="col-md-6">
                                <input type="text" name="nama_ayah" class="form-control" placeholder="Nama Ayah" value="{{ $pendaftar->nama_ayah }}">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="nik_ayah" class="form-control" placeholder="NIK Ayah" value="{{ $pendaftar->nik_ayah }}">
                            </div>
                            <div class="col-md-6">
                                <select name="pendidikan_ayah" class="form-select">
                                    <option value="">- Pendidikan Ayah -</option>
                                    @foreach(['SD','SMP','SMA','S1','S2','Lainnya'] as $p)
                                        <option value="{{ $p }}" {{ $pendaftar->pendidikan_ayah == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="pekerjaan_ayah" class="form-control" placeholder="Pekerjaan Ayah" value="{{ $pendaftar->pekerjaan_ayah }}">
                            </div>

                            <div class="col-md-12"><hr class="my-1"> <small class="fw-bold text-success">DATA IBU</small></div>
                            <div class="col-md-6">
                                <input type="text" name="nama_ibu" class="form-control" placeholder="Nama Ibu" value="{{ $pendaftar->nama_ibu }}">
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="nik_ibu" class="form-control" placeholder="NIK Ibu" value="{{ $pendaftar->nik_ibu }}">
                            </div>
                            <div class="col-md-6">
                                <select name="pendidikan_ibu" class="form-select">
                                    <option value="">- Pendidikan Ibu -</option>
                                    @foreach(['SD','SMP','SMA','S1','S2','Lainnya'] as $p)
                                        <option value="{{ $p }}" {{ $pendaftar->pendidikan_ibu == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="pekerjaan_ibu" class="form-control" placeholder="Pekerjaan Ibu" value="{{ $pendaftar->pekerjaan_ibu }}">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @if($showPeriodik && $isPaud)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-danger"><i class="bi bi-graph-up me-2"></i> 5. DATA PERIODIK</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Tinggi Badan (cm)</label><input type="number" step="0.01" name="tinggi_badan" class="form-control" value="{{ $pendaftar->tinggi_badan }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Berat Badan (kg)</label><input type="number" step="0.01" name="berat_badan" class="form-control" value="{{ $pendaftar->berat_badan }}"></div>
                            <div class="col-md-4"><label class="small text-muted fw-bold text-uppercase">Lingkar Kepala (cm)</label><input type="number" step="0.01" name="lingkar_kepala" class="form-control" value="{{ $pendaftar->lingkar_kepala }}"></div>
                            
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Jarak ke Sekolah</label>
                                <select name="jarak_ke_sekolah" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Kurang dari 1 km" {{ $pendaftar->jarak_ke_sekolah == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                                    <option value="Lebih dari 1 km" {{ $pendaftar->jarak_ke_sekolah == 'Lebih dari 1 km' ? 'selected' : '' }}>Lebih dari 1 km</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Jarak (km) > 1km</label><input type="number" step="0.01" name="jarak_ke_sekolah_km" class="form-control" value="{{ $pendaftar->jarak_ke_sekolah_km }}"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Waktu Tempuh</label><input type="text" name="waktu_tempuh" class="form-control" value="{{ $pendaftar->waktu_tempuh }}"></div>
                        </div>
                    </div>
                </div>
                @endif

                @if($showPrestasi)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-success"><i class="bi bi-trophy-fill me-2"></i> 5. DATA PRESTASI</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Bidang Prestasi</label><input type="text" name="prestasi_bidang" class="form-control" value="{{ $pendaftar->prestasi_bidang }}" placeholder="Contoh: Matematika, Renang"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Tingkat Prestasi</label><input type="text" name="prestasi_tingkat" class="form-control" value="{{ $pendaftar->prestasi_tingkat }}" placeholder="Contoh: Kecamatan, Kabupaten"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Peringkat</label><input type="text" name="prestasi_peringkat" class="form-control" value="{{ $pendaftar->prestasi_peringkat }}" placeholder="Contoh: Juara 1"></div>
                            <div class="col-md-6"><label class="small text-muted fw-bold text-uppercase">Tahun</label><input type="text" name="prestasi_tahun" class="form-control" value="{{ $pendaftar->prestasi_tahun }}" placeholder="Contoh: 2024"></div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <div class="col-xl-4">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h6 class="m-0 fw-bold"><i class="bi bi-gear-fill me-2"></i> STATUS & ASRAMA</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small text-muted fw-bold">Status Penerimaan</label>
                            <select name="status_lulus" class="form-select fw-bold border-2 border-primary">
                                <option value="Proses Seleksi" {{ $pendaftar->status_lulus == 'Proses Seleksi' ? 'selected' : '' }}>⏳ Proses Seleksi</option>
                                <option value="LULUS" {{ $pendaftar->status_lulus == 'LULUS' ? 'selected' : '' }}>✅ LULUS</option>
                                <option value="CADANGAN" {{ $pendaftar->status_lulus == 'CADANGAN' ? 'selected' : '' }}>⚠️ CADANGAN</option>
                                <option value="TIDAK DITERIMA" {{ $pendaftar->status_lulus == 'TIDAK DITERIMA' ? 'selected' : '' }}>❌ DITOLAK</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted fw-bold">Pilihan Asrama</label>
                            <select name="pilihan_asrama" class="form-select">
                                <option value="Non-Asrama" {{ $pendaftar->pilihan_asrama == 'Non-Asrama' ? 'selected' : '' }}>🏠 Pulang Pergi (Non-Asrama)</option>
                                <option value="Asrama" {{ $pendaftar->pilihan_asrama == 'Asrama' ? 'selected' : '' }}>🏢 Mukim (Asrama)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold w-100 py-2">
                            <i class="bi bi-save2-fill me-2"></i> SIMPAN SEMUA DATA
                        </button>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-dark"><i class="bi bi-cloud-arrow-up-fill me-2"></i> UPDATE BERKAS</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3 pb-3 border-bottom">
                            <label class="small text-muted fw-bold">1. KK & Akta Kelahiran</label>
                            @if($pendaftar->file_kk_akta)
                                <div class="mb-1">
                                    <a href="{{ url('/admin/download/'.$pendaftar->id.'/kk_akta') }}" class="badge bg-success text-decoration-none">
                                        <i class="bi bi-check-circle"></i> File Ada (Klik Download)
                                    </a>
                                </div>
                            @else
                                <div class="badge bg-secondary mb-1">Belum ada file</div>
                            @endif
                            <input type="file" name="file_kk_akta" class="form-control form-control-sm mt-1">
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <label class="small text-muted fw-bold">2. Ijazah / SKL</label>
                            @if($pendaftar->foto_ijazah)
                                <div class="mb-1">
                                    <a href="{{ url('/admin/download/'.$pendaftar->id.'/ijazah') }}" class="badge bg-success text-decoration-none">
                                        <i class="bi bi-check-circle"></i> File Ada
                                    </a>
                                </div>
                            @else
                                <div class="badge bg-secondary mb-1">Belum ada file</div>
                            @endif
                            <input type="file" name="file_ijazah" class="form-control form-control-sm mt-1">
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <label class="small text-muted fw-bold">3. KIP & KTP Ortu</label>
                            @if($pendaftar->file_kip_ktp)
                                <div class="mb-1">
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> File Ada</span>
                                </div>
                            @else
                                <div class="badge bg-secondary mb-1">Belum ada file</div>
                            @endif
                            <input type="file" name="file_kip_ktp" class="form-control form-control-sm mt-1">
                        </div>

                        <div class="mb-3 pb-3 border-bottom">
                            <label class="small text-muted fw-bold">4. Pas Foto</label>
                            @if($pendaftar->file_foto)
                                <div class="mb-1">
                                    <a href="{{ url('/admin/download/'.$pendaftar->id.'/foto') }}" class="badge bg-success text-decoration-none">
                                        <i class="bi bi-check-circle"></i> File Ada
                                    </a>
                                </div>
                            @else
                                <div class="badge bg-secondary mb-1">Belum ada file</div>
                            @endif
                            <input type="file" name="file_foto" class="form-control form-control-sm mt-1">
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted fw-bold">5. SKKB Sekolah Asal</label>
                            @if($pendaftar->file_skkb)
                                <div class="mb-1">
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> File Ada</span>
                                </div>
                            @else
                                <div class="badge bg-secondary mb-1">Belum ada file</div>
                            @endif
                            <input type="file" name="file_skkb" class="form-control form-control-sm mt-1">
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </form>
</div>
@endsection