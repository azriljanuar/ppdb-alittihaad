<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Al-Ittihaad - Generasi Qurani</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* --- VARIABLE WARNA --- */
        :root {
            --brand-green: #017443;
            --primary-dark: #064e3b;
            --primary-light: #065f46;
            --accent-lime: #d1fae5;
            --btn-color: #34d399;
            --text-light: #ecfdf5;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            overflow-x: hidden; /* Mencegah scroll samping */
        }

        /* --- NAVBAR --- */
        .navbar-custom {
            background-color: #ffffff;
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .navbar-brand img { height: 45px; }
        .nav-link {
            color: var(--primary-dark) !important;
            font-weight: 700;
            margin: 0 10px;
            font-size: 0.95rem;
        }
        .nav-link:hover { color: var(--btn-color) !important; }
        .btn-nav-siswa {
            background-color: var(--brand-green);
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 700;
            font-size: 0.9rem;
            border: 2px solid var(--brand-green);
            transition: 0.3s;
        }
        .btn-nav-siswa:hover {
            background-color: transparent;
            color: var(--brand-green);
        }

        /* --- HERO HEADER --- */
        .hero-section {
            background-color: var(--primary-dark);
            color: white;
            padding: 100px 0 180px 0; /* Padding bawah besar untuk tempat fitur */
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
            position: relative;
            z-index: 1;
        }
        .hero-title { font-size: 3rem; font-weight: 800; line-height: 1.2; margin-bottom: 1.5rem; }
        .hero-subtitle { font-size: 1.1rem; color: #d1d5db; margin-bottom: 2rem; max-width: 550px; }
        .btn-hero-primary {
            background-color: var(--btn-color);
            color: var(--primary-dark);
            font-weight: 800;
            padding: 12px 40px;
            border-radius: 50px;
            border: none;
            transition: 0.3s;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); background-color: #10b981; }

        /* --- FEATURES (KARTU KEUNGGULAN) --- */
        .features-wrapper {
            margin-top: -100px; /* Menarik ke atas menimpa hero */
            position: relative;
            z-index: 10;
            margin-bottom: 80px;
        }
        .feature-card {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .feature-card:hover { transform: translateY(-10px); }
        .icon-box {
            width: 60px; height: 60px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 15px;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        /* --- INFO SECTION --- */
        .section-title { font-weight: 800; color: var(--primary-dark); margin-bottom: 10px; }
        .nav-pills .nav-link {
            color: #64748b; background-color: #fff; border: 1px solid #cbd5e1;
            margin: 0 5px; border-radius: 50px; font-weight: 600; padding: 10px 25px;
        }
        .nav-pills .nav-link.active {
            background-color: var(--primary-dark); color: #fff; border-color: var(--primary-dark);
        }

        /* --- CARD STYLE (DIPAKAI UNTUK BIAYA & JADWAL AGAR KEMBAR) --- */
        .info-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 30px;
            background: white;
        }
        .info-card-header {
            background: #fff;
            padding: 20px 30px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
        }
        .info-card-icon {
            width: 45px; height: 45px;
            background: #dcfce7; /* Hijau muda banget */
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        .info-card-title {
            font-weight: 800; font-size: 1.2rem; color: #1e293b; margin: 0;
        }
        .info-card-body { padding: 30px; }

        /* HEADER SUB-SECTION (ABU-ABU) */
        .sub-header {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
            margin-top: 10px;
            letter-spacing: 0.5px;
            border: 1px solid #e2e8f0;
        }

        /* TABEL STYLE (BERSIH) */
        .table-custom th {
            font-size: 0.85rem; text-transform: uppercase; color: #64748b; font-weight: 700; border-bottom: 2px solid #f1f5f9;
        }
        .table-custom td {
            vertical-align: middle; padding: 12px 10px; border-bottom: 1px solid #f8fafc; font-size: 0.95rem;
        }
        .table-custom tr:last-child td { border-bottom: none; }
        
        /* FOOTER */
        footer {
            background-color: var(--primary-dark);
            color: white;
            padding-top: 80px;
            padding-bottom: 40px;
            border-top-left-radius: 60px;
            border-top-right-radius: 60px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
    {{-- GANTI 'assets/logo.svg' DENGAN LOKASI FILE LOGO ANDA --}}
    <img src="{{ asset('assets/images/logo-ppdb.svg') }}" alt="Logo PPDB" height="50">
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#informasi">Informasi</a></li>
                    
                    {{-- DROPDOWN UNDUH BROSUR --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Unduh Brosur
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-3 mt-2">
                            @if(isset($brosurs) && $brosurs->count() > 0)
                                @foreach($brosurs as $b)
                                    <li>
                                        <a class="dropdown-item py-2 small" href="{{ route('brosur.download', $b->id) }}" target="_blank">
                                            <i class="bi bi-file-pdf me-2 text-danger"></i> {{ $b->judul }} 
                                            @if($b->jenjang) <span class="badge bg-light text-dark ms-1 border">{{ $b->jenjang }}</span> @endif
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li><span class="dropdown-item text-muted small">Belum ada brosur</span></li>
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a href="{{ url('/siswa/login') }}" class="btn btn-nav-siswa text-decoration-none">Login Siswa</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="badge bg-white text-success px-3 py-2 rounded-pill mb-3 fw-bold shadow-sm">
                        <i class="bi bi-stars me-1"></i> Pendaftaran 2025/2026 Dibuka
                    </div>
                    <h1 class="hero-title">Membangun Generasi <br><span style="color: var(--btn-color);">Qurani & Berprestasi</span></h1>
                    <p class="hero-subtitle">
                        Bergabunglah bersama kami di Al-Ittihaad. Kurikulum terpadu berbasis Al-Qur'an dan Sains untuk masa depan gemilang buah hati Anda.
                    </p>
                    <a href="{{ url('/daftar') }}" class="btn btn-hero-primary shadow-lg">
                        Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <img src="https://img.freepik.com/free-photo/group-diverse-grads-throwing-caps-up-sky_53876-56031.jpg" 
                        alt="Siswa" class="img-fluid rounded-4 shadow-lg" style="transform: rotate(2deg); border: 5px solid rgba(255,255,255,0.2); width: 85%;">
                </div>
            </div>
        </div>
    </section>

    <section class="features-wrapper container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger mx-auto">
                        <i class="bi bi-book-half"></i>
                    </div>
                    <h5 class="fw-bold">Kurikulum Terpadu</h5>
                    <p class="text-muted small">Memadukan kurikulum nasional dan kepesantrenan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning mx-auto">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <h5 class="fw-bold">Prestasi Santri</h5>
                    <p class="text-muted small">Mencetak juara di tingkat regional hingga nasional.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success mx-auto">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h5 class="fw-bold">Lingkungan Islami</h5>
                    <p class="text-muted small">Pembiasaan akhlak mulia dan ibadah sehari-hari.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container pb-5" id="informasi">
        
        @php $jenjangs = ['PAUD', 'RA/TK', 'SDIT', 'MDU', 'MTS', 'MA']; @endphp
        
        <ul class="nav nav-pills justify-content-center mb-5" id="pills-tab" role="tablist">
            @foreach($jenjangs as $index => $j)
                <li class="nav-item">
                    <button class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                        id="pills-{{ Str::slug($j) }}-tab"
                        data-bs-toggle="pill" 
                        data-bs-target="#pills-{{ Str::slug($j) }}" 
                        type="button" role="tab">{{ $j }}</button>
                </li>
            @endforeach
        </ul>

        <div class="text-center mb-5">
            <h6 class="text-success fw-bold text-uppercase ls-1">Informasi Pendaftaran</h6>
            <h2 class="section-title">Informasi & Biaya Pendidikan</h2>
        </div>

        <div class="tab-content" id="pills-tabContent">
            @foreach($jenjangs as $index => $j)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="pills-{{ Str::slug($j) }}">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">

                            @php
                                $dataJenjang = isset($biayaItems) ? $biayaItems->where('jenjang', $j) : collect([]);
                                $otherInfos = $infos->where('jenjang', $j);
                                
                                // KHUSUS SDIT: Hapus informasi biaya (Request User)
                                if($j == 'SDIT') {
                                    $dataJenjang = collect([]);
                                    $otherInfos = $otherInfos->where('kategori', '!=', 'Biaya');
                                }

                                $profile = $infos->where('jenjang', $j)->where('kategori', 'Profile')->first();
                            @endphp

                            {{-- A. PROFILE (CAROUSEL & DESKRIPSI) --}}
                            @if($profile)
                                {{-- DEBUG --}}
                                {{-- <div class="alert alert-warning">{{ json_encode($profile->images) }}</div> --}}
                                
                                <div class="mb-5">
                                    {{-- Carousel --}}
                                    @if(!empty($profile->images) && count($profile->images) > 0)
                                        <div id="carousel-{{ Str::slug($j) }}" class="carousel slide mb-4" data-bs-ride="carousel">
                                            <div class="carousel-inner rounded-4 shadow-sm overflow-hidden">
                                                @foreach($profile->images as $k => $img)
                                                    <div class="carousel-item {{ $k==0?'active':'' }}">
                                                        <img src="{{ asset('storage/' . $img) }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Foto {{ $j }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(count($profile->images) > 1)
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ Str::slug($j) }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ Str::slug($j) }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Deskripsi --}}
                                    @if(!empty($profile->deskripsi))
                                        <div class="content-reset text-center mb-4">
                                            {!! $profile->deskripsi !!}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- B. KARTU RINCIAN BIAYA --}}
                            @if($dataJenjang->count() > 0)
                                <div class="info-card">
                                    <div class="info-card-header">
                                        <div class="info-card-icon"><i class="bi bi-wallet2"></i></div>
                                        <h5 class="info-card-title">Rincian Biaya</h5>
                                    </div>
                                    <div class="info-card-body">
                                        @foreach($dataJenjang->groupBy('kategori') as $kategori => $items)
                                            @php
                                                // Tentukan apakah jenjang ini perlu digabung (PAUD, RA/TK, MDU)
                                                $mergedView = in_array($j, ['PAUD', 'RA/TK', 'MDU']);
                                                
                                                // Jika jenjang PAUD/RA/TK/MDU, ubah label 'Asrama/Non Asrama' menjadi lebih umum jika perlu, 
                                                // atau biarkan judul kategori tapi nanti kolomnya satu saja.
                                                // User minta: "hilangkan kata kata tentang asrama dan non asrama"
                                                // Jadi kita bisa ubah label $kategori kalau mengandung kata Asrama
                                                $displayKategori = $kategori;
                                                if($mergedView) {
                                                    $displayKategori = str_replace(['Asrama', 'Non Asrama'], '', $kategori);
                                                    if(trim($displayKategori) == '') $displayKategori = 'Biaya Pendidikan';
                                                }

                                                $uniqueNames = $items->pluck('nama_item')->unique();
                                                $totalPutra = $items->where('gender', 'Putra')->sum('nominal');
                                                $totalPutri = $items->where('gender', 'Putri')->sum('nominal');
                                                // Jika merged, kita ambil salah satu saja (misal Putra) sebagai total umum
                                                $totalUmum = $totalPutra; 
                                            @endphp

                                            <div class="sub-header">{{ $displayKategori }}</div>
                                            
                                            <div class="table-responsive mb-4">
                                                <table class="table table-custom mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th width="40%">Komponen</th>
                                                            @if($mergedView)
                                                                <th width="60%" class="text-end text-primary">Nominal</th>
                                                            @else
                                                                <th width="30%" class="text-end text-primary">Putra</th>
                                                                <th width="30%" class="text-end text-danger">Putri</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($uniqueNames as $namaItem)
                                                            @php
                                                                $valPutra = $items->where('gender', 'Putra')->where('nama_item', $namaItem)->first()->nominal ?? 0;
                                                                $valPutri = $items->where('gender', 'Putri')->where('nama_item', $namaItem)->first()->nominal ?? 0;
                                                            @endphp
                                                            <tr>
                                                                <td class="text-secondary fst-italic">{{ $namaItem }}</td>
                                                                @if($mergedView)
                                                                    {{-- Tampilkan satu kolom saja (ambil nilai Putra asumsi sama) --}}
                                                                    <td class="text-end fw-bold text-dark">{{ $valPutra > 0 ? number_format($valPutra,0,',','.') : '-' }}</td>
                                                                @else
                                                                    <td class="text-end fw-bold text-dark">{{ $valPutra > 0 ? number_format($valPutra,0,',','.') : '-' }}</td>
                                                                    <td class="text-end fw-bold text-dark">{{ $valPutri > 0 ? number_format($valPutri,0,',','.') : '-' }}</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="bg-light">
                                                        <tr>
                                                            <td class="fw-bold text-success text-uppercase ps-2">TOTAL</td>
                                                            @if($mergedView)
                                                                <td class="text-end fw-bold text-success fs-6">Rp {{ number_format($totalUmum,0,',','.') }}</td>
                                                            @else
                                                                <td class="text-end fw-bold text-success fs-6">Rp {{ number_format($totalPutra,0,',','.') }}</td>
                                                                <td class="text-end fw-bold text-success fs-6">Rp {{ number_format($totalPutri,0,',','.') }}</td>
                                                            @endif
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- B. KARTU INFORMASI LAIN (JADWAL, DLL) --}}
                            @if($otherInfos->count() > 0)
                                @foreach($otherInfos as $info)
                                    @if($info->kategori == 'Biaya' && $dataJenjang->count() > 0) @continue @endif

                                    <div class="info-card">
                                        <div class="info-card-header">
                                            <div class="info-card-icon">
                                                @if($info->kategori == 'Jadwal') <i class="bi bi-calendar-check"></i>
                                                @elseif($info->kategori == 'Syarat') <i class="bi bi-card-checklist"></i>
                                                @else <i class="bi bi-info-lg"></i> @endif
                                            </div>
                                            <h5 class="info-card-title">{{ $info->kategori }}</h5>
                                        </div>
                                        <div class="info-card-body">
                                            <div class="content-reset">
                                                {!! $info->deskripsi !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- C. JIKA KOSONG --}}
                            @if($dataJenjang->count() == 0 && $otherInfos->count() == 0)
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted fw-bold">Belum Ada Informasi</h5>
                                    <p class="small text-secondary">Data untuk jenjang ini akan segera tersedia.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-5">
                    <h4 class="fw-bold mb-3"><i class="bi bi-flower1 me-2"></i>Al-Ittihaad</h4>
                    <p class="opacity-75">Membentuk generasi pemimpin yang hafal Al-Qur'an, berwawasan luas, dan siap menghadapi tantangan global dengan akhlak mulia.</p>
                </div>
                <div class="col-md-3">
                    <h5 class="fw-bold mb-3">Tautan</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="{{ url('/daftar') }}" class="text-white text-decoration-none">Daftar Sekarang</a></li>
                        <li class="mb-2"><a href="{{ url('/siswa/login') }}" class="text-white text-decoration-none">Login Siswa</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><i class="bi bi-whatsapp me-2"></i> 0812-3456-7890</li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Raya Pendidikan No. 104</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@alittihaad.sch.id</li>
                    </ul>
                </div>
            </div>
            <hr class="opacity-25 my-4">
            <div class="text-center opacity-50 small">&copy; 2025 PPDB Al-Ittihaad. All Rights Reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.querySelectorAll('.content-reset table').forEach(function(table) {
            table.classList.add('table', 'table-custom', 'mb-0');
            // Bungkus tabel dengan responsive div biar ga jebol di HP
            var wrapper = document.createElement('div');
            wrapper.classList.add('table-responsive', 'mb-3');
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        });
        
        // Merapikan header (Gelombang 1, dll) dari Summernote
        document.querySelectorAll('.content-reset h5, .content-reset h6').forEach(function(header) {
            header.classList.add('sub-header');
            header.style.backgroundColor = '#f1f5f9'; // Paksa style
        });
    </script>
</body>
</html>
