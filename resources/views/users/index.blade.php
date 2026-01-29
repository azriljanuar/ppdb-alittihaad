@extends('layout_admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manajemen Akun</h3>
            <p class="text-muted small mb-0">Kelola akun Admin dan akun Login Siswa.</p>
        </div>
        <button class="btn btn-primary fw-bold shadow-sm px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Admin
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 rounded-pill border" id="pills-admin-tab" data-bs-toggle="pill" data-bs-target="#pills-admin" type="button" role="tab">
                <i class="bi bi-shield-lock me-2"></i> Akun Admin
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4 rounded-pill border ms-2" id="pills-siswa-tab" data-bs-toggle="pill" data-bs-target="#pills-siswa" type="button" role="tab">
                <i class="bi bi-mortarboard me-2"></i> Akun Siswa
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        <div class="tab-pane fade show active" id="pills-admin" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama & Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Akses</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-center text-muted fw-bold">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $user->role == 'superadmin' ? 'bg-warning text-dark' : 'bg-primary' }} rounded-pill px-3">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $user->akses_jenjang ?? 'Semua' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning text-white me-1 btn-edit-admin" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditAdmin"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}"
                                            data-jenjang="{{ $user->akses_jenjang }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        @if($user->id != auth()->id()) 
                                            <form action="{{ url('/users/' . $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus admin ini?');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-light text-danger border"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-siswa" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info bg-opacity-10 small">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Gunakan fitur ini jika siswa lupa password mereka. Username siswa adalah <strong>Nomor Pendaftaran</strong>.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No Pendaftaran (Username)</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenjang</th>
                                    <th>Password Saat Ini</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $s)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $s->no_daftar }}</td>
                                    <td class="fw-bold">{{ $s->nama_lengkap }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $s->jenjang }}</span></td>
                                    <td class="text-danger fw-bold font-monospace">{{ $s->password }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary fw-bold btn-edit-siswa"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditSiswa"
                                            data-id="{{ $s->id }}"
                                            data-nama="{{ $s->nama_lengkap }}"
                                            data-nodaftar="{{ $s->no_daftar }}">
                                            <i class="bi bi-key me-1"></i> Ganti Password
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Tambah Admin Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/users') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" id="roleSelectAdd" onchange="toggleJenjang('Add')">
                            <option value="admin">Admin Unit</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>
                    <div class="mb-3" id="boxJenjangAdd">
                        <label class="form-label">Akses Jenjang</label>
                        <select name="akses_jenjang" class="form-select">
                            <option value="">Semua</option>
                            @foreach(['PAUD','RA/TK','SDIT','MDU','MTS','MA'] as $j) <option value="{{$j}}">{{$j}}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAdmin" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark">Edit Data Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditAdmin" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak diganti)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="******">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" id="roleSelectEdit" onchange="toggleJenjang('Edit')">
                            <option value="admin">Admin Unit</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>
                    <div class="mb-3" id="boxJenjangEdit">
                        <label class="form-label">Akses Jenjang</label>
                        <select name="akses_jenjang" id="edit_jenjang" class="form-select">
                            <option value="">Semua</option>
                            @foreach(['PAUD','RA/TK','SDIT','MDU','MTS','MA'] as $j) <option value="{{$j}}">{{$j}}</option> @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning fw-bold">Update Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditSiswa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Ganti Password Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditSiswa" method="POST">
                @csrf @method('PUT')
                <div class="modal-body text-center">
                    <h5 class="fw-bold" id="namaSiswaDisplay">Nama Siswa</h5>
                    <p class="text-muted mb-4">Username: <span id="userSiswaDisplay" class="fw-bold text-dark"></span></p>
                    
                    <div class="form-floating mb-3">
                        <input type="text" name="password_baru" class="form-control text-center fw-bold fs-4 text-primary" placeholder="Password Baru" required>
                        <label>Masukkan Password Baru</label>
                    </div>
                    <small class="text-muted">Masukkan angka/huruf untuk password baru siswa.</small>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success fw-bold w-100">Simpan Password Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleJenjang(mode) {
        let role = document.getElementById("roleSelect" + mode).value;
        let box = document.getElementById("boxJenjang" + mode);
        box.style.display = (role === 'superadmin') ? 'none' : 'block';
    }

    // 1. Script Edit Admin
    document.querySelectorAll('.btn-edit-admin').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let name = this.getAttribute('data-name');
            let email = this.getAttribute('data-email');
            let role = this.getAttribute('data-role');
            let jenjang = this.getAttribute('data-jenjang');

            // Isi Form
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('roleSelectEdit').value = role;
            document.getElementById('edit_jenjang').value = jenjang ? jenjang : "";
            
            // Set Action URL
            document.getElementById('formEditAdmin').action = "{{ url('/users') }}/" + id;
            
            toggleJenjang('Edit');
        });
    });

    // 2. Script Edit Siswa
    document.querySelectorAll('.btn-edit-siswa').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let nama = this.getAttribute('data-nama');
            let nodaftar = this.getAttribute('data-nodaftar');

            document.getElementById('namaSiswaDisplay').innerText = nama;
            document.getElementById('userSiswaDisplay').innerText = nodaftar;
            
            // Set Action URL
            document.getElementById('formEditSiswa').action = "{{ url('/users/siswa') }}/" + id;
        });
    });
</script>
@endsection
