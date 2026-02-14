@extends('layout_admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-gear-fill me-2"></i>Pengaturan Website</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- KOLOM KIRI: Identitas Website --}}
                            <div class="col-md-6">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">Identitas Website</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Tab Browser (Site Title)</label>
                                    <input type="text" name="site_title" class="form-control" value="{{ old('site_title', $setting->site_title) }}">
                                    <div class="form-text">Teks yang muncul di tab browser.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Logo Website (Header)</label>
                                    @if($setting->site_logo)
                                        <div class="mb-2">
                                            <img src="{{ asset($setting->site_logo) }}" alt="Logo" height="50" class="border p-1 rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="site_logo" class="form-control" accept="image/*,.svg">
                                    <div class="form-text">Format: PNG, JPG, SVG. Disarankan background transparan.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Icon Website (Favicon)</label>
                                    @if($setting->site_icon)
                                        <div class="mb-2">
                                            <img src="{{ asset($setting->site_icon) }}" alt="Icon" height="32" class="border p-1 rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="site_icon" class="form-control" accept="image/*,.ico,.svg">
                                    <div class="form-text">Icon kecil di tab browser. Format: ICO, PNG, SVG.</div>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: Hero Section (Halaman Utama) --}}
                            <div class="col-md-6">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">Halaman Utama (Hero Section)</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Badge Teks (Atas Judul)</label>
                                    <input type="text" name="hero_badge" class="form-control" value="{{ old('hero_badge', $setting->hero_badge) }}">
                                    <div class="form-text">Contoh: Pendaftaran 2025/2026 Dibuka</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Judul Utama (Baris 1)</label>
                                            <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $setting->hero_title) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Judul Highlight (Warna Hijau)</label>
                                            <input type="text" name="hero_title_highlight" class="form-control" value="{{ old('hero_title_highlight', $setting->hero_title_highlight) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi Singkat</label>
                                    <textarea name="hero_description" rows="3" class="form-control">{{ old('hero_description', $setting->hero_description) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar Hero (Samping Kanan)</label>
                                    @if($setting->hero_image)
                                        <div class="mb-2">
                                            @php
                                                $heroSrc = Str::startsWith($setting->hero_image, 'http') ? $setting->hero_image : asset($setting->hero_image);
                                            @endphp
                                            <img src="{{ $heroSrc }}" alt="Hero Image" class="img-fluid rounded" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" name="hero_image" class="form-control" accept="image/*,.webp">
                                    <div class="form-text">Gambar besar di halaman depan. Format: JPG, PNG, WEBP.</div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: Fitur Unggulan (3 Kartu) --}}
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">Fitur Unggulan (3 Kartu)</h6>
                            </div>
                            
                            {{-- Fitur 1 --}}
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-danger"><i class="bi bi-book-half me-2"></i>Fitur 1 (Merah)</h6>
                                        <div class="mb-2">
                                            <label class="form-label small">Judul</label>
                                            <input type="text" name="feature1_title" class="form-control form-control-sm" value="{{ old('feature1_title', $setting->feature1_title) }}">
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label small">Deskripsi</label>
                                            <textarea name="feature1_desc" rows="2" class="form-control form-control-sm">{{ old('feature1_desc', $setting->feature1_desc) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Fitur 2 --}}
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-warning"><i class="bi bi-trophy-fill me-2"></i>Fitur 2 (Kuning)</h6>
                                        <div class="mb-2">
                                            <label class="form-label small">Judul</label>
                                            <input type="text" name="feature2_title" class="form-control form-control-sm" value="{{ old('feature2_title', $setting->feature2_title) }}">
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label small">Deskripsi</label>
                                            <textarea name="feature2_desc" rows="2" class="form-control form-control-sm">{{ old('feature2_desc', $setting->feature2_desc) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Fitur 3 --}}
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-success"><i class="bi bi-heart-fill me-2"></i>Fitur 3 (Hijau)</h6>
                                        <div class="mb-2">
                                            <label class="form-label small">Judul</label>
                                            <input type="text" name="feature3_title" class="form-control form-control-sm" value="{{ old('feature3_title', $setting->feature3_title) }}">
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label small">Deskripsi</label>
                                            <textarea name="feature3_desc" rows="2" class="form-control form-control-sm">{{ old('feature3_desc', $setting->feature3_desc) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
