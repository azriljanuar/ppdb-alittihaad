@extends('layout_admin')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-pdf me-2"></i>Kelola Brosur</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Form Upload -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold text-success mb-0">Upload Brosur Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('brosur.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Judul Brosur</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Brosur SDIT 2025" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Untuk Jenjang (Opsional)</label>
                            <select name="jenjang" class="form-select">
                                <option value="">- Umum / Semua Jenjang -</option>
                                <option value="PAUD">PAUD</option>
                                <option value="RA/TA">RA/TA</option>
                                <option value="SDIT">SDIT</option>
                                <option value="MDU">MDU</option>
                                <option value="MTS">MTS</option>
                                <option value="MA">MA</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">File Brosur (PDF/Gambar)</label>
                            <input type="file" name="file_brosur" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text text-muted small">Maksimal ukuran file 5MB.</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold py-2 rounded-pill">
                                <i class="bi bi-cloud-upload me-2"></i> Upload Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Brosur -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">Daftar Brosur Tersedia</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Judul</th>
                                    <th class="px-4 py-3">Jenjang</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brosurs as $index => $item)
                                <tr>
                                    <td class="px-4">{{ $index + 1 }}</td>
                                    <td class="px-4 fw-bold text-dark">{{ $item->judul }}</td>
                                    <td class="px-4">
                                        @if($item->jenjang)
                                            <span class="badge bg-info text-dark">{{ $item->jenjang }}</span>
                                        @else
                                            <span class="badge bg-secondary">Umum</span>
                                        @endif
                                    </td>
                                    <td class="px-4 text-center">
                                        <a href="{{ route('brosur.download', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1" title="Download">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <form action="{{ route('brosur.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus brosur ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder-x fs-1 d-block mb-2 opacity-50"></i>
                                        Belum ada brosur yang diupload.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
