@extends('layout_admin') 

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Dashboard Admin</h3>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
        <span class="badge bg-success px-3 py-2">Status System: Online</span>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-uppercase mb-1 small fw-bold text-muted">Total Pendaftar</h6>
                            <h2 class="mb-0 fw-bold text-primary">{{ $total_pendaftar }}</h2>
                        </div>
                        <span class="rounded-circle bg-primary bg-opacity-10 text-primary p-3">
                            <i class="bi bi-people fs-4"></i>
                        </span>
                    </div>
                    <p class="mb-0 small text-muted">Rekap total seluruh pendaftar pada periode berjalan sesuai hak akses Anda.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="text-uppercase mb-3 small fw-bold text-muted">Komposisi Jenjang</h6>
                    <div class="d-flex flex-column gap-2">
                        @foreach($per_jenjang as $row)
                            @php
                                $persen = $total_pendaftar > 0 ? round(($row->total / $total_pendaftar) * 100) : 0;
                                $widthClass = $persen >= 80 ? 'w-100' : ($persen >= 60 ? 'w-75' : ($persen >= 40 ? 'w-50' : ($persen >= 20 ? 'w-25' : 'w-10')));
                            @endphp
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small fw-semibold">{{ $row->jenjang ?: '-' }}</span>
                                    <span class="small text-muted">{{ $row->total }} santri • {{ $persen }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success {{ $widthClass }}" role="progressbar"></div>
                                </div>
                            </div>
                        @endforeach
                        @if($per_jenjang->isEmpty())
                            <p class="small text-muted mb-0">Belum ada data pendaftar.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="text-uppercase mb-3 small fw-bold text-muted">Komposisi Laki-laki / Perempuan</h6>
                    <div class="d-flex align-items-center justify-content-center" style="min-height: 160px;">
                        <canvas id="genderChart" style="max-height: 140px;"></canvas>
                    </div>
                    <div class="d-flex justify-content-center gap-3 small text-muted mt-2">
                        @foreach($by_gender as $row)
                            <span>
                                <span class="badge rounded-pill {{ $loop->index == 0 ? 'bg-info text-white' : 'bg-warning text-dark' }}">
                                    {{ $row->jenis_kelamin ?: 'Tidak diisi' }} • {{ $row->total }}
                                </span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase mb-0 small fw-bold text-muted">Status Seleksi</h6>
                        <span class="badge bg-light text-muted">Rekap per status kelulusan</span>
                    </div>
                    <div style="min-height: 220px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase mb-2 small fw-bold text-muted">Panduan Singkat</h6>
                    <p class="small text-muted mb-2">
                        Gunakan menu <strong>Data Calon Santri</strong> untuk melihat detail, mengedit, mencetak, atau mengelola berkas pendaftar.
                    </p>
                    <ul class="small text-muted mb-0">
                        <li>Lihat distribusi pendaftar per jenjang pada panel kiri tengah.</li>
                        <li>Perhatikan komposisi jenis kelamin di panel kanan.</li>
                        <li>Grafik bawah menampilkan sebaran status kelulusan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="dashboard-data"
         data-gender='@json($by_gender->pluck("total"))'
         data-gender-labels='@json($by_gender->pluck("jenis_kelamin"))'
         data-status='@json($by_status_lulus->pluck("total"))'
         data-status-labels='@json($by_status_lulus->pluck("status_lulus"))'>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    const statusCtx = document.getElementById('statusChart').getContext('2d');

    const dataRoot = document.getElementById('dashboard-data');

    let genderData = [];
    let genderLabels = [];
    let statusData = [];
    let statusLabels = [];

    if (dataRoot) {
        try {
            genderData = JSON.parse(dataRoot.dataset.gender || '[]');
            genderLabels = JSON.parse(dataRoot.dataset.genderLabels || '[]');
            statusData = JSON.parse(dataRoot.dataset.status || '[]');
            statusLabels = JSON.parse(dataRoot.dataset.statusLabels || '[]');
        } catch (e) {
            console.error('Gagal parsing data dashboard', e);
        }
    }

    if (genderLabels.length > 0 && genderData.length > 0) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderLabels.map(l => l || 'Tidak diisi'),
                datasets: [{
                    data: genderData,
                    backgroundColor: ['#0ea5e9', '#f97316', '#22c55e'],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '60%'
            }
        });
    }

    if (statusLabels.length > 0 && statusData.length > 0) {
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: statusLabels.map(l => l || 'Belum diatur'),
                datasets: [{
                    data: statusData,
                    backgroundColor: '#22c55e',
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e5e7eb' }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection
