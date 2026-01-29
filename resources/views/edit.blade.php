@extends('layout_admin')

@section('content')
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
                            <div class="col-md-8">
                                <label class="small text-muted fw-bold text-uppercase">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="{{ $pendaftar->nama_lengkap }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">NIK</label>
                                <input type="number" name="nik" class="form-control" value="{{ $pendaftar->nik }}">
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
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold text-uppercase">Jenjang</label>
                                <select name="jenjang" class="form-select bg-warning bg-opacity-10">
                                    @foreach(['PAUD', 'RA/TA', 'SDIT', 'MDU', 'MTS', 'MA'] as $j)
                                        <option value="{{ $j }}" {{ $pendaftar->jenjang == $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-success"><i class="bi bi-building me-2"></i> 2. SEKOLAH ASAL</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
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
                                <label class="small text-muted fw-bold text-uppercase">Kabupaten</label>
                                <input type="text" name="kabupaten_sekolah_asal" class="form-control" value="{{ $pendaftar->kabupaten_sekolah_asal }}">
                            </div>
                        </div>
                    </div>
                </div>

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
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold text-warning text-dark"><i class="bi bi-people-fill me-2"></i> 4. DATA ORANG TUA</h6>
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>

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