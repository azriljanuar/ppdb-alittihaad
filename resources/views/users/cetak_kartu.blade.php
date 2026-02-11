<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-login {
            width: 450px;
            border: 2px solid #000;
            margin: 50px auto;
            background: #fff;
            position: relative;
            overflow: hidden;
        }
        .card-header-custom {
            background-color: #198754; /* Green like PPDB */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .card-body-custom {
            padding: 30px;
        }
        .logo-area {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        .login-info {
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .info-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 15px;
            font-family: 'Courier New', Courier, monospace;
        }
        .info-value:last-child {
            margin-bottom: 0;
        }
        .footer-note {
            font-size: 11px;
            color: #6c757d;
            text-align: center;
            margin-top: 20px;
        }
        @media print {
            body {
                background-color: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
            .card-login {
                margin: 0;
                border: 1px solid #000;
                page-break-inside: avoid;
                page-break-after: always; /* Agar setiap kartu di halaman baru (opsional) atau biarkan mengalir */
                margin-bottom: 20px;
            }
            .card-wrapper {
                page-break-inside: avoid;
                padding-top: 10px;
                padding-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg shadow">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill me-2" viewBox="0 0 16 16">
                <path d="M0 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6zm11-3a1 1 0 0 1 1 1v2H4V4a1 1 0 0 1 1-1h6z"/>
                <path d="M5 12h6v2H5v-2z"/>
            </svg>
            Cetak Kartu
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-lg shadow ms-2">Tutup</button>
    </div>

    @php
        // Normalisasi data agar selalu array/collection
        $items = isset($data_collection) ? $data_collection : collect([$data]);
    @endphp

    @foreach($items as $item)
    <div class="card-wrapper">
        <div class="card-login">
            <div class="card-header-custom">
                <div class="logo-area">PPDB AL-ITTIHAAD</div>
                <div class="subtitle">KARTU AKSES LOGIN {{ strtoupper($type) }}</div>
            </div>
            <div class="card-body-custom">
                <div class="text-center mb-4">
                    @if($type == 'admin')
                        <h4 class="fw-bold">{{ $item->name }}</h4>
                        <span class="badge bg-secondary">{{ ucfirst($item->role) }}</span>
                    @else
                        <h4 class="fw-bold">{{ $item->nama_lengkap }}</h4>
                        <span class="badge bg-secondary">{{ $item->jenjang }}</span>
                    @endif
                </div>

                <div class="login-info">
                    <div class="info-label">Username / ID Login</div>
                    <div class="info-value">
                        @if($type == 'admin')
                            {{ $item->email }}
                        @else
                            {{ $item->no_daftar }}
                        @endif
                    </div>

                    <div class="info-label">Password</div>
                    <div class="info-value">
                        @if($type == 'admin')
                            <span class="text-muted fst-italic" style="font-size: 14px;">(Terenkripsi)</span>
                        @else
                            {{ $item->password }}
                        @endif
                    </div>
                </div>

                <div class="footer-note">
                    @if($type == 'admin')
                        Harap jaga kerahasiaan akun Anda. Password tidak ditampilkan demi keamanan.
                    @else
                        Gunakan Username dan Password di atas untuk login ke Dashboard Calon Santri.
                    @endif
                    <br>
                    <em>Dicetak pada: {{ date('d-m-Y H:i') }}</em>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</body>
</html>