@extends('layout_admin')

@section('content')
<div class="container-fluid px-4 mt-4">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold text-dark mb-0">Kelola Data Calon Santri</h3>
        <a href="{{ url('/admin/export-excel') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success btn-sm shadow-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary mb-3">Filter & Pencarian</h6>
            <form action="{{ route('pendaftar.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    
                    {{-- 1. PENCARIAN (Lebar menyesuaikan) --}}
                    <div class="{{ auth()->user()->role == 'superadmin' ? 'col-md-6' : 'col-md-10' }}">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                            <input type="text" name="cari" class="form-control" placeholder="Cari Nama / No Daftar..." value="{{ request('cari') }}">
                        </div>
                    </div>

                    {{-- 2. FILTER JENJANG (Hanya Superadmin) --}}
                    @if(auth()->user()->role == 'superadmin')
                    <div class="col-md-4">
                        <select name="jenjang" class="form-select">
                            <option value="">- Semua Jenjang -</option>
                            @foreach(['PAUD', 'RA/TK', 'SDIT', 'MDU', 'MTS', 'MA'] as $j)
                                <option value="{{ $j }}" {{ request('jenjang') == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- 3. TOMBOL FILTER --}}
                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                            <a href="{{ route('pendaftar.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-body p-0">
            <form action="{{ route('pendaftar.bulk_update') }}" method="POST" id="bulkForm">
            @csrf
            
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom bg-light">
                <div class="form-check ms-2">
                    <input class="form-check-input" type="checkbox" id="checkAll">
                    <label class="form-check-label fw-bold text-muted small" for="checkAll">Pilih Semua</label>
                </div>
                <div>
                    <button type="submit" name="status" value="Diterima" class="btn btn-success btn-sm fw-bold shadow-sm" onclick="return confirm('Yakin TERIMA data yang dipilih?')">
                        <i class="bi bi-check-lg me-1"></i> Terima
                    </button>
                    <button type="submit" name="status" value="Ditolak" class="btn btn-danger btn-sm fw-bold shadow-sm ms-1" onclick="return confirm('Yakin TOLAK data yang dipilih?')">
                        <i class="bi bi-x-lg me-1"></i> Tolak
                    </button>
                    <button type="submit" name="status" value="Proses Seleksi" class="btn btn-secondary btn-sm fw-bold shadow-sm ms-1" onclick="return confirm('Reset status data yang dipilih?')">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 10px;">#</th>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Jenjang</th>
                            <th>Status</th>
                            <th>Asal Sekolah</th>
                            <th>Berkas Upload</th> <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftars as $index => $p)
                        <tr>
                            <td class="ps-4">
                                <input class="form-check-input checkItem" type="checkbox" name="ids[]" value="{{ $p->id }}">
                            </td>
                            <td>{{ $index + $pendaftars->firstItem() }}</td>
                            <td class="fw-bold text-dark">
                                {{ $p->nama_lengkap }} <br> 
                                <small class="text-muted fw-normal">{{ $p->no_daftar }}</small>
                            </td>
                            <td><span class="badge bg-info text-dark bg-opacity-10 border border-info">{{ $p->jenjang }}</span></td>
                            <td>
                                @if($p->status_lulus == 'Diterima')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Diterima</span>
                                @elseif($p->status_lulus == 'Ditolak')
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Proses</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($p->asal_sekolah, 20) }}</td>
                            
                            {{-- LOGIKA DOWNLOAD BERKAS (DROPDOWN) --}}
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-folder2-open me-1"></i> Lihat Berkas
                                    </button>
                                    <ul class="dropdown-menu shadow border-0">
                                        <li>
                                            @if($p->file_kk_akta)
                                                <a class="dropdown-item" href="{{ url('/admin/download/'.$p->id.'/kk_akta') }}">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> KK / Akta
                                                </a>
                                            @else
                                                <span class="dropdown-item text-muted disabled"><i class="bi bi-x-circle me-2"></i> KK / Akta (Kosong)</span>
                                            @endif
                                        </li>
                                        <li>
                                            @if($p->foto_ijazah)
                                                <a class="dropdown-item" href="{{ url('/admin/download/'.$p->id.'/ijazah') }}">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Ijazah
                                                </a>
                                            @else
                                                <span class="dropdown-item text-muted disabled"><i class="bi bi-x-circle me-2"></i> Ijazah (Kosong)</span>
                                            @endif
                                        </li>
                                        <li>
                                            @if($p->file_kip_ktp)
                                                <a class="dropdown-item" href="{{ url('/admin/download/'.$p->id.'/kip_ktp') }}">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> KIP / KTP
                                                </a>
                                            @else
                                                <span class="dropdown-item text-muted disabled"><i class="bi bi-x-circle me-2"></i> KIP / KTP (Kosong)</span>
                                            @endif
                                        </li>
                                        <li>
                                            @if($p->file_foto)
                                                <a class="dropdown-item" href="{{ url('/admin/download/'.$p->id.'/foto') }}">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Pas Foto
                                                </a>
                                            @else
                                                <span class="dropdown-item text-muted disabled"><i class="bi bi-x-circle me-2"></i> Pas Foto (Kosong)</span>
                                            @endif
                                        </li>
                                        <li>
                                            @if($p->file_skkb)
                                                <a class="dropdown-item" href="{{ url('/admin/download/'.$p->id.'/skkb') }}">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i> SKKB
                                                </a>
                                            @else
                                                <span class="dropdown-item text-muted disabled"><i class="bi bi-x-circle me-2"></i> SKKB (Kosong)</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <a href="{{ route('pendaftar.edit', $p->id) }}" class="btn btn-light border btn-sm text-primary" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ url('/cetak/' . $p->id) }}" class="btn btn-light border btn-sm text-dark" target="_blank" title="Cetak Bukti">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <a href="{{ url('/pendaftar/'.$p->id.'/delete') }}" class="btn btn-light border btn-sm text-danger" onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                <p class="mb-0 fw-bold">Tidak ada data ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </form>

            <div class="px-4 py-3 border-top">
                {{ $pendaftars->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.checkItem');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
@endsection
