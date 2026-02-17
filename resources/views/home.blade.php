<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Al-Ittihaad - Generasi Qurani</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            /* Warna Logo Baru */
            --brand-green: #017443; 
            
            --primary-dark: #064e3b;
            /* Hijau Tua (Background Utama) */
            --primary-light: #065f46;
            /* Hijau Tua Terang (Card) */
            --accent-lime: #d1fae5;
            /* Hijau Muda (Aksen) */
            --btn-color: #34d399;
            /* Warna Tombol */
            --text-light: #ecfdf5;
            /* Teks Putih Kehijauan */
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        /* --- NAVBAR (HEADER) --- */
        .navbar-custom {
            background-color: #ffffff; /* UBAH: Jadi Putih */
            padding: 0.8rem 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* TAMBAH: Bayangan halus agar header terlihat jelas */
        }

        .navbar-brand {
            /* Area Logo */
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: var(--brand-green) !important; /* UBAH: Warna teks jadi hijau logo (#017443) */
            font-weight: 600; /* Sedikit dipertebal agar terbaca jelas di background putih */
            margin: 0 10px;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #10b981 !important; /* Warna hover sedikit lebih terang */
        }

        /* Tombol Mobile (Hamburger Menu) */
        .navbar-toggler {
            border-color: var(--brand-green);
        }
        
        .navbar-toggler-icon {
            /* UBAH: Menggunakan filter CSS untuk mengubah warna icon hamburger jadi hijau logo */
            filter: invert(28%) sepia(93%) saturate(389%) hue-rotate(105deg) brightness(91%) contrast(93%);
        }

        /* Tombol Login Siswa */
        .btn-nav-siswa {
            background-color: var(--brand-green); /* Sesuaikan dengan warna logo */
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 700;
            border: 1px solid var(--brand-green);
            transition: 0.3s;
        }

        .btn-nav-siswa:hover {
            background-color: white;
            color: var(--brand-green);
            border-color: var(--brand-green);
        }

        /* --- HERO SECTION (HEADER BAWAH) --- */
        .hero-section {
            background-color: var(--primary-dark);
            color: white;
            padding: 80px 0 120px 0;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
        }

        .hero-blob {
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(52, 211, 153, 0.1);
            filter: blur(80px);
            border-radius: 50%;
            z-index: 0;
        }

        .blob-1 {
            top: -100px;
            right: -100px;
        }

        .blob-2 {
            bottom: -100px;
            left: -100px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
            max-width: 600px;
        }

        .btn-hero-primary {
            background-color: var(--btn-color);
            color: var(--primary-dark);
            font-weight: 700;
            padding: 12px 35px;
            border-radius: 50px;
            border: none;
            transition: 0.3s;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(52, 211, 153, 0.3);
            background-color: #10b981;
        }

        /* --- FEATURES & TABS --- */
        .features-container {
            margin-top: -80px;
            position: relative;
            z-index: 10;
        }

        .feature-card {
            border: none;
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            transition: transform 0.3s;
            color: #1e293b;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .card-pink { background-color: #fecaca; }
        .card-orange { background-color: #fed7aa; }
        .card-green { background-color: #bbf7d0; }

        .feature-title {
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 15px;
            display: block;
        }

        .info-section {
            padding: 80px 0;
        }

        .section-title {
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .nav-pills .nav-link {
            color: var(--primary-dark);
            background-color: white;
            border: 1px solid #e2e8f0;
            margin-right: 10px;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-dark);
            color: var(--btn-color);
            border-color: var(--primary-dark);
        }

        .info-detail-card {
            border: 1px solid #f1f5f9;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border-left: 5px solid var(--btn-color);
        }

        footer {
            background-color: var(--primary-dark);
            color: var(--text-light);
            padding: 50px 0;
            border-top-left-radius: 60px;
            border-top-right-radius: 60px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo-ppdb.svg') }}" alt="Logo" height="55">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#informasi">Informasi</a></li>
                    
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

                    <li class="nav-item ms-lg-3">
                        <a href="{{ url('/siswa/login') }}" class="btn btn-nav-siswa text-decoration-none">
                            <i class="bi bi-person-circle me-1"></i> Login Siswa
                        </a>
                    </li>
                  
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-blob blob-1"></div>
        <div class="hero-blob blob-2"></div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="badge bg-white text-success rounded-pill px-3 py-2 mb-3 fw-bold">
                        🚀 PPDB Online 2025/2026 Dibuka!
                    </span>
                    <h1 class="hero-title">Mendidik Generasi Tafaqquh Fiddin, <br><span style="color: var(--btn-color);">Berkhidmat
                            untuk Ummat</span></h1>
                    <p class="hero-subtitle">
                        Bergabunglah bersama kami di Al-Ittihaad. Pendidikan berbasis Al-Qur'an dengan fasilitas modern
                        untuk masa depan buah hati Anda.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ url('/daftar') }}" class="btn btn-hero-primary">
                            Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </a>

                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="https://img.freepik.com/free-photo/group-diverse-grads-throwing-caps-up-sky_53876-56031.jpg"
                        alt="Siswa Bahagia"
                        style="width: 100%; max-width: 500px; border-radius: 30px; border: 5px solid rgba(255,255,255,0.1); transform: rotate(2deg);">
                </div>
            </div>
        </div>
    </section>

    <section class="container features-container" id="fitur">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card card-pink">
                    <i class="bi bi-book-half feature-icon text-danger"></i>
                    <h3 class="feature-title">{{ optional($setting)->feature1_title ?? 'Kurikulum Terpadu' }}</h3>
                    <p class="small mb-0">
                        {{ optional($setting)->feature1_desc ?? 'Memadukan kurikulum nasional dan kepesantrenan.' }}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card-orange">
                    <i class="bi bi-star-fill feature-icon text-warning"></i>
                    <h3 class="feature-title">{{ optional($setting)->feature2_title ?? 'Prestasi Santri' }}</h3>
                    <p class="small mb-0">
                        {{ optional($setting)->feature2_desc ?? 'Mencetak juara di tingkat regional hingga nasional.' }}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card card-green">
                    <i class="bi bi-heart-fill feature-icon text-success"></i>
                    <h3 class="feature-title">{{ optional($setting)->feature3_title ?? 'Lingkungan Islami' }}</h3>
                    <p class="small mb-0">
                        {{ optional($setting)->feature3_desc ?? 'Pembiasaan akhlak mulia dan ibadah sehari-hari.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="info-section container" id="informasi">
        <div class="text-center mb-5">
            <h6 class="text-success fw-bold text-uppercase ls-1">Informasi Pendaftaran</h6>
            <h2 class="section-title">Semua yang Perlu Anda Tahu</h2>
            <p class="text-muted">Pilih jenjang pendidikan untuk melihat detail biaya dan persyaratan.</p>
        </div>

        <ul class="nav nav-pills justify-content-center mb-4" id="pills-tab" role="tablist">
            @php $jenjangs = ['PAUD', 'RA/TA', 'SDIT', 'MDU', 'MTS', 'MA']; @endphp
            @foreach($jenjangs as $index => $j)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="pills-{{ Str::slug($j) }}-tab"
                        data-bs-toggle="pill" data-bs-target="#pills-{{ Str::slug($j) }}" type="button" role="tab">
                        {{ $j }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="pills-tabContent">
            @foreach($jenjangs as $index => $j)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="pills-{{ Str::slug($j) }}"
                    role="tabpanel">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            @php $infoJenjang = $infos->where('jenjang', $j); @endphp
                            @if($infoJenjang->count() > 0)
                                @foreach($infoJenjang as $info)
                                    <div class="info-detail-card">
                                        <div class="d-flex align-items-center mb-3">
                                            @if($info->kategori == 'Biaya')
                                                <div class="bg-success text-white rounded-circle p-2 me-3"><i
                                                        class="bi bi-cash fs-5"></i></div>
                                            @elseif($info->kategori == 'Jadwal')
                                                <div class="bg-warning text-dark rounded-circle p-2 me-3"><i
                                                        class="bi bi-calendar fs-5"></i></div>
                                            @else
                                                <div class="bg-primary text-white rounded-circle p-2 me-3"><i
                                                        class="bi bi-file-text fs-5"></i></div>
                                            @endif
                                            <h5 class="fw-bold mb-0 text-dark">{{ $info->kategori }} - {{ $j }}</h5>
                                        </div>
                                        <div class="text-muted">{!! $info->deskripsi !!}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5 text-muted border rounded bg-light">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    Belum ada informasi spesifik untuk jenjang {{ $j }} saat ini.
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
            <div class="row">
                <div class="col-md-5 mb-4">
                    <h4 class="fw-bold mb-3"><i class="bi bi-flower1 me-2"></i>Pesantren Persatuan Islam 104 Al-Ittihaad</h4>
                    <p class="opacity-75">Berkomitmen mendidik generasi yang Tafaqquh Fiddin dan berkhidmat kepada umat melalui pendidikan berbasis Al-Qur’an dan Sunnah. Kami mengintegrasikan ilmu syar’i dan teknologi untuk membentuk santri berakhlak mulia yang siap berkontribusi bagi masyarakat..</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="fw-bold mb-3 text-white">Tautan Cepat</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="{{ url('/daftar') }}"
                                class="text-white text-decoration-none">Pendaftaran</a></li>
                        <li class="mb-2"><a href="{{ url('/cek-kelulusan') }}"
                                class="text-white text-decoration-none">Pengumuman</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3 text-white">Hubungi Kami</h5>
                    <ul class="list-unstyled opacity-75">
                        <li class="mb-2"><i class="bi bi-whatsapp me-2"></i> +62 852-1404-9027</li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Raya Rancapandan Km.5 Cikajang</li>
                    </ul>
                </div>
            </div>
            <hr class="opacity-25 my-4">
            <div class="text-center opacity-50 small">&copy; 2025 PPDB Al-Ittihaad. All Rights Reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
