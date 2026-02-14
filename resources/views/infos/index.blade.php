@extends('layout_admin')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<div class="container-fluid px-4 mt-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold text-dark mb-1">Kelola Informasi Website</h3>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary btn-sm fw-bold rounded-pill px-3">
            <i class="bi bi-globe me-1"></i> Lihat Website
        </a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-success text-white py-3"><h6 class="m-0 fw-bold">Konten Per Jenjang</h6></div>
        <div class="card-body">
            
            <ul class="nav nav-pills justify-content-center mb-4">
                @foreach($allowed_jenjangs as $index => $jenjang)
                <li class="nav-item">
                    <button class="nav-link {{ $index == 0 ? 'active' : '' }} fw-bold px-4 rounded-pill border mx-1" 
                            data-bs-toggle="pill" data-bs-target="#pills-{{ Str::slug($jenjang) }}">{{ $jenjang }}</button>
                </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($allowed_jenjangs as $index => $jenjang)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="pills-{{ Str::slug($jenjang) }}">
                    
                    @php 
                        // Ambil info khusus jenjang ini
                        $infoJenjang = $infos->where('jenjang', $jenjang); 
                    @endphp
                    
                    @foreach($infoJenjang as $item)
                    <div class="card border mb-4 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-uppercase text-primary">{{ $item->kategori }} ({{ $jenjang }})</h6>
                            
                            @if($item->kategori == 'Biaya')
                                {{-- Tombol ke Halaman Kelola Biaya (BiayaController) --}}
                                @if($jenjang != 'SDIT')
                                    <a href="{{ route('biaya.index', ['jenjang' => $item->jenjang]) }}" class="btn btn-warning btn-sm fw-bold text-dark">
                                        <i class="bi bi-gear-fill me-1"></i> Kelola Rincian (Asrama/Gender)
                                    </a>
                                @endif
                            @else
                                {{-- DEFAULT: Tombol Modal Edit Biasa --}}
                                <button type="button" class="btn btn-warning btn-sm fw-bold text-dark btn-edit-trigger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditInfo"
                                    data-id="{{ $item->id }}"
                                    data-kategori="{{ $item->kategori }}"
                                    data-jenjang="{{ $item->jenjang }}"
                                    
                                    data-bp="{{ $item->biaya_pendaftaran }}"
                                    data-bu="{{ $item->biaya_uang_pangkal }}"
                                    data-bs="{{ $item->biaya_seragam }}"
                                    data-infotambah="{{ htmlspecialchars($item->info_tambahan ?? '') }}"

                                    data-jp1="{{ $item->jadwal_pendaftaran_1 }}"
                                    data-jt1="{{ $item->jadwal_tes_1 }}"
                                    data-jg1="{{ $item->jadwal_pengumuman_1 }}"
                                    data-jp2="{{ $item->jadwal_pendaftaran_2 }}"
                                    data-jt2="{{ $item->jadwal_tes_2 }}"
                                    data-jg2="{{ $item->jadwal_pengumuman_2 }}"

                                    data-jadwal-json="{{ $item->kategori == 'Jadwal' ? json_encode($item->jadwal_json ?? []) : '[]' }}"
                                    
                                    data-syarat-json="{{ $item->kategori == 'Syarat' ? json_encode($item->syarat_json ?? []) : '[]' }}"
                                    data-beasiswa-json="{{ $item->kategori == 'Beasiswa' ? json_encode($item->beasiswa_json ?? []) : '[]' }}"

                                    data-images="{{ $item->kategori == 'Profile' ? json_encode($item->images ?? []) : '[]' }}"

                                    data-raw="{{ htmlspecialchars($item->kategori == 'Syarat' ? $item->syarat_raw : $item->beasiswa_raw) }}"
                                    data-isi="{{ htmlspecialchars($item->deskripsi) }}">
                                    <i class="bi bi-pencil-fill me-1"></i> Edit
                                </button>
                            @endif
                        </div>

                        <div class="card-body bg-light">
                            
                            {{-- TAMPILAN TABEL BIAYA --}}
                            @if($item->kategori == 'Biaya')
                                @if($jenjang == 'SDIT')
                                    <div class="alert alert-info text-center small mb-0">
                                        <i class="bi bi-info-circle me-1"></i> Informasi rincian biaya untuk SDIT tidak ditampilkan.
                                    </div>
                                @else
                                    @php
                                        // Ambil data biaya dinamis yang dikirim dari InfoController
                                        $dataBiaya = isset($biayaItems) ? $biayaItems->where('jenjang', $item->jenjang) : collect([]);
                                    @endphp
    
                                    @if($dataBiaya->count() > 0)
                                        <div class="bg-white p-3 border rounded">
                                            @foreach($dataBiaya->groupBy('kategori') as $kategori => $genders)
                                                @php
                                                    $displayKategori = $kategori;
                                                    // Jika merged view (PAUD, RA/TK, MDU)
                                                    if(in_array($item->jenjang, ['PAUD', 'RA/TK', 'MDU'])) {
                                                        // Hapus Asrama / Non Asrama jika ada
                                                        $displayKategori = str_replace(['Asrama', 'Non-Asrama', 'Non Asrama'], '', $kategori);
                                                        if(trim($displayKategori) == '') $displayKategori = 'Biaya Pendidikan';
                                                    }
                                                @endphp

                                                <div class="mb-3 p-2 bg-light border rounded">
                                                    <strong class="text-dark text-uppercase small ls-1"><i class="bi bi-building"></i> {{ $displayKategori }}</strong>
                                                    <div class="row mt-2">
                                                        @foreach($genders->groupBy('gender') as $gender => $listBiaya)
                                                            <div class="col-md-6">
                                                                <div class="card border mb-2">
                                                                    <div class="card-header py-1 bg-secondary bg-opacity-10 text-dark fw-bold" style="font-size: 0.8rem;">
                                                                        {{ in_array($item->jenjang, ['PAUD', 'RA/TK', 'MDU']) ? 'Nominal' : $gender }}
                                                                    </div>
                                                                    <ul class="list-group list-group-flush small">
                                                                        @foreach($listBiaya as $b)
                                                                            <li class="list-group-item d-flex justify-content-between px-2 py-1">
                                                                                <span class="text-dark">{{ $b->nama_item }}</span>
                                                                                <span class="fw-bold text-dark">Rp {{ number_format($b->nominal, 0, ',', '.') }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                        <li class="list-group-item d-flex justify-content-between px-2 py-1 bg-white border-top">
                                                                            <strong class="text-dark">TOTAL</strong>
                                                                            <strong class="text-dark">Rp {{ number_format($listBiaya->sum('nominal'), 0, ',', '.') }}</strong>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-info text-center small mb-0">
                                            <i class="bi bi-info-circle me-1"></i> Data rincian biaya belum diinput.
                                        </div>
                                    @endif
                                @endif

                            {{-- TAMPILAN HTML BIASA (JADWAL, SYARAT, DLL) --}}
                            @else
                                <div class="bg-white p-3 border rounded">
                                    {!! $item->deskripsi !!}
                                </div>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditInfo" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark" id="modalTitle">Edit Informasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="formEditInfo" method="POST" action="" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    
                    {{-- Area Biaya (Hanya muncul untuk SDIT/PAUD/RA) --}}
                    <div id="areaBiaya" class="form-area" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-4"><label class="fw-bold small">Pendaftaran</label><div class="input-group"><span class="input-group-text">Rp</span><input type="number" name="biaya_pendaftaran" id="in_bp" class="form-control hitung-total"></div></div>
                            <div class="col-md-4"><label class="fw-bold small">Uang Pangkal</label><div class="input-group"><span class="input-group-text">Rp</span><input type="number" name="biaya_uang_pangkal" id="in_bu" class="form-control hitung-total"></div></div>
                            <div class="col-md-4"><label class="fw-bold small">Seragam</label><div class="input-group"><span class="input-group-text">Rp</span><input type="number" name="biaya_seragam" id="in_bs" class="form-control hitung-total"></div></div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded mt-3 border border-success d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-success">TOTAL:</h5><h3 class="mb-0 fw-bold text-success" id="displayTotal">Rp 0</h3>
                        </div>
                        <div class="mt-3"><label class="fw-bold small">Info Tambahan</label><textarea name="info_tambahan" id="in_info" class="form-control" rows="2"></textarea></div>
                    </div>

                    {{-- Area Jadwal --}}
                    <div id="areaJadwal" class="form-area" style="display: none;">
                        <div class="alert alert-info small mb-3">
                            <i class="bi bi-info-circle me-1"></i> Masukkan jadwal kegiatan satu per satu. Klik tombol "+" untuk menambah baris.
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tableJadwal">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th style="width: 160px;">Dari Tanggal</th>
                                        <th style="width: 160px;">Sampai Tanggal</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyJadwal">
                                    {{-- Baris akan ditambahkan via JS --}}
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-success btn-sm mt-2" onclick="addJadwalRow()">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Kegiatan
                        </button>
                    </div>

                    {{-- Area Table List (Syarat/Beasiswa) --}}
                    <div id="areaTableList" class="form-area" style="display: none;">
                        <div class="alert alert-info small mb-3">
                            <i class="bi bi-info-circle me-1"></i> Masukkan poin-poin satu per satu.
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="tableList">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 30%;">Jenis / Judul</th>
                                        <th>Keterangan</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyList"></tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-success btn-sm mt-2" onclick="addListRow()">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Baris
                        </button>
                    </div>

                    {{-- Area Editor Umum --}}
                    <div id="areaEditor" class="form-area" style="display: none;">
                        <textarea id="summernote" name="deskripsi"></textarea>
                    </div>

                    {{-- Area Profile (Deskripsi + Gambar) --}}
                    <div id="areaProfile" class="form-area" style="display: none;">
                        <div class="mb-3">
                            <label class="fw-bold small">Deskripsi Profil</label>
                            <textarea id="summernoteProfile" name="deskripsi"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">Upload Gambar Carousel</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/jpeg, image/png, image/gif, image/webp">
                            <div class="form-text">Format: JPG, PNG, GIF, WEBP. Maks 2MB.</div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold small">Gambar Saat Ini (Centang untuk Hapus)</label>
                            <div id="currentImagesList" class="row g-2 mt-2"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Simpan & Update Website</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.addJadwalRow = function(kegiatan = '', tgl_mulai = '', tgl_selesai = '') {
        var html = `
            <tr>
                <td><input type="text" name="jadwal_kegiatan[]" class="form-control form-control-sm" value="${kegiatan}" required placeholder="Nama Kegiatan"></td>
                <td><input type="date" name="jadwal_tgl_mulai[]" class="form-control form-control-sm" value="${tgl_mulai}" required></td>
                <td><input type="date" name="jadwal_tgl_selesai[]" class="form-control form-control-sm" value="${tgl_selesai}"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm py-0 px-1" onclick="$(this).closest('tr').remove()"><i class="bi bi-x"></i></button>
                </td>
            </tr>
        `;
        $('#bodyJadwal').append(html);
    }

    window.addListRow = function(jenis = '', keterangan = '') {
        var html = `
            <tr>
                <td><input type="text" name="list_jenis[]" class="form-control form-control-sm" value="${jenis}" placeholder="Contoh: Fotokopi KK"></td>
                <td><input type="text" name="list_keterangan[]" class="form-control form-control-sm" value="${keterangan}" placeholder="Keterangan detail..."></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm py-0 px-1" onclick="$(this).closest('tr').remove()"><i class="bi bi-x"></i></button>
                </td>
            </tr>
        `;
        $('#bodyList').append(html);
    }

    $(document).ready(function() {
        $('#summernote').summernote({ height: 200 });
        $('#summernoteProfile').summernote({ height: 200 });

        $('.btn-edit-trigger').on('click', function() {
            var id = $(this).data('id');
            var kat = $(this).data('kategori');
            $('#modalTitle').text('Edit ' + kat + ' - ' + $(this).data('jenjang'));
            $('#formEditInfo').attr('action', "{{ url('/infos') }}/" + id);
            $('.form-area').hide();

            if(kat === 'Biaya') {
                $('#areaBiaya').show();
                $('#in_bp').val($(this).data('bp')); $('#in_bu').val($(this).data('bu')); $('#in_bs').val($(this).data('bs')); $('#in_info').val($(this).data('infotambah'));
                hitungTotal();
            } 
            else if(kat === 'Jadwal') {
                $('#areaJadwal').show();
                $('#bodyJadwal').empty();
                
                var jadwalJsonRaw = $(this).attr('data-jadwal-json') || '[]';
                var hasData = false;
                try {
                    var arr = JSON.parse(jadwalJsonRaw);
                    if (Array.isArray(arr) && arr.length > 0) {
                        arr.forEach(function(it){ 
                            addJadwalRow(it.kegiatan || '', it.tgl_mulai || '', it.tgl_selesai || '');
                            hasData = true;
                        });
                    }
                } catch(e) {}
                
                if (!hasData) {
                    addJadwalRow();
                }
            }
            else if(kat === 'Syarat' || kat === 'Beasiswa') {
                $('#areaTableList').show();
                $('#bodyList').empty();
                
                var jsonRaw = (kat === 'Syarat') ? $(this).attr('data-syarat-json') : $(this).attr('data-beasiswa-json');
                var hasData = false;
                try {
                    var arr = JSON.parse(jsonRaw);
                    if (Array.isArray(arr) && arr.length > 0) {
                        arr.forEach(function(it){ 
                            addListRow(it.jenis || '', it.keterangan || '');
                            hasData = true;
                        });
                    }
                } catch(e) {}
                
                // Fallback to raw text if json is empty (Migration logic)
                if (!hasData) {
                    var rawText = $(this).data('raw') || '';
                    if(rawText) {
                        var lines = rawText.toString().split('\n');
                        lines.forEach(function(line){
                            if(line.trim()) addListRow('', line.trim()); 
                        });
                    } else {
                        addListRow();
                    }
                }
            }
            else if(kat === 'Profile') {
                $('#areaProfile').show();
                // Set description to dedicated summernote
                $('#summernoteProfile').summernote('code', $(this).data('isi'));
                
                // Handle Images
                var images = $(this).data('images'); // Already JSON object/array
                var imgContainer = $('#currentImagesList');
                imgContainer.empty();
                
                if(Array.isArray(images) && images.length > 0) {
                    var baseUrl = "{{ asset('/') }}";
                    var storageUrl = "{{ asset('storage') }}";

                    images.forEach(function(img) {
                        var src = "";
                        if (img.indexOf('uploads/') === 0) {
                            src = baseUrl + img;
                        } else {
                            src = storageUrl + '/' + img;
                        }

                        var html = `
                            <div class="col-4 col-sm-3 position-relative">
                                <img src="${src}" class="img-thumbnail w-100" style="height: 80px; object-fit: cover;">
                                <div class="form-check position-absolute top-0 start-0 m-1 bg-white rounded p-1 shadow-sm">
                                    <input class="form-check-input" type="checkbox" name="delete_images[]" value="${img}">
                                    <label class="form-check-label small text-danger fw-bold">Hapus</label>
                                </div>
                            </div>
                        `;
                        imgContainer.append(html);
                    });
                } else {
                    imgContainer.append('<div class="col-12 text-muted small fst-italic">Belum ada gambar.</div>');
                }
            } 
            else { $('#areaEditor').show(); $('#summernote').summernote('code', $(this).data('isi')); }
        });

        $('.hitung-total').on('input', hitungTotal);
        function hitungTotal() {
            var total = (parseInt($('#in_bp').val())||0) + (parseInt($('#in_bu').val())||0) + (parseInt($('#in_bs').val())||0);
            $('#displayTotal').text('Rp ' + total.toLocaleString('id-ID'));
        }

        
    });
</script>
@endsection
