<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PPDB Al-Ittihaad</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #064e3b;   /* Hijau Tua Utama */
            --sidebar-hover: #065f46; /* Hijau Sedikit Terang */
            --active-item: #34d399;   /* Hijau Mint (Highlight) */
            --text-light: #ecfdf5;    /* Teks Putih */
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 280px;
            background-color: var(--sidebar-bg);
            color: var(--text-light);
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar-heading {
            padding: 1.5rem;
            font-size: 1.25rem;
            font-weight: 800;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .list-group-item {
            background-color: transparent;
            color: rgba(255,255,255,0.7);
            border: none;
            padding: 12px 25px;
            font-weight: 500;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none; /* Penting agar tidak ada garis bawah */
        }
        .list-group-item:hover {
            background-color: var(--sidebar-hover);
            color: white;
            padding-left: 30px; /* Efek geser */
        }
        .list-group-item.active {
            background-color: rgba(52, 211, 153, 0.1);
            color: var(--active-item);
            border-right: 4px solid var(--active-item);
            font-weight: 700;
        }
        .list-group-item i { font-size: 1.1rem; }

        /* --- CONTENT WRAPPER --- */
        #page-content-wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            transition: all 0.3s;
        }
        
        /* Navbar Atas */
        .admin-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Tweak Mobile */
        @media (max-width: 768px) {
            #sidebar-wrapper { margin-left: -280px; }
            #page-content-wrapper { margin-left: 0; width: 100%; }
            .toggled #sidebar-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="d-flex" id="wrapper">
    
    <div id="sidebar-wrapper">
        <div class="sidebar-heading d-flex align-items-center justify-content-center py-4">
    {{-- LOGO OTOMATIS JADI PUTIH --}}
    <img src="{{ asset('assets/images/logo-ppdb.svg') }}" 
         alt="Logo Admin" 
         style="height: 40px; filter: brightness(0) invert(1);"> 
         
    {{-- Jika ingin tetap ada teks di sebelahnya --}}

</div>
        <div class="list-group list-group-flush mt-3">
            
            <a href="{{ url('/admin') }}" class="list-group-item {{ Request::is('admin') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            
            <a href="{{ route('pendaftar.index') }}" class="list-group-item {{ request()->routeIs('pendaftar.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Data Calon Santri
            </a>

            @if(auth()->user()->role == 'superadmin')
            <a href="{{ url('/users') }}" class="list-group-item {{ Request::is('users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Kelola User
            </a>
            <a href="{{ route('settings.index') }}" class="list-group-item {{ Request::is('settings*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i> Pengaturan Website
            </a>
            @endif

            <a href="{{ url('/infos') }}" class="list-group-item {{ Request::is('infos*') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i> Info Website
            </a>

            <a href="{{ route('brosur.index') }}" class="list-group-item {{ Request::is('brosur*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-pdf"></i> Kelola Brosur
            </a>

            <div class="mt-4 px-3 text-uppercase small opacity-50 fw-bold" style="font-size: 0.75rem;">Lainnya</div>
            
            <a href="{{ route('user.change-password') }}" class="list-group-item {{ Request::is('profile/change-password') ? 'active' : '' }}">
                <i class="bi bi-key"></i> Ganti Password
            </a>

            <a href="{{ url('/') }}" target="_blank" class="list-group-item">
                <i class="bi bi-globe"></i> Lihat Website
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="list-group-item text-danger w-100">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>
    <div id="page-content-wrapper">
        
        <nav class="admin-navbar sticky-top">
            <button class="btn btn-light border" id="menu-toggle"><i class="bi bi-list"></i></button>
            
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold text-dark small">{{ auth()->user()->name }}</div>
                    <div class="text-muted small" style="font-size: 0.75rem;">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                     style="width: 40px; height: 40px; font-size: 1.2rem;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            @yield('content')
        </div>
        
    </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    // Toggle Sidebar
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

@yield('scripts')
@stack('scripts')

</body>
</html>
