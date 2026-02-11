<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\BrosurController;

/*
|--------------------------------------------------------------------------
| AREA BEBAS (Bisa Diakses Tanpa Login)
|--------------------------------------------------------------------------
*/

// --- AREA SISWA ---
Route::get('/siswa/login', [PendaftarController::class, 'formLoginSiswa']);
Route::post('/siswa/login', [PendaftarController::class, 'prosesLoginSiswa']);
Route::get('/siswa/dashboard', [PendaftarController::class, 'dashboardSiswa']);
Route::post('/siswa/logout', [PendaftarController::class, 'logoutSiswa']);
Route::post('/siswa/update-data', [PendaftarController::class, 'updateDataSiswa']);

// 1. Halaman Depan (Landing Page)
Route::get('/', function () {
    // Mengirim data biaya ke halaman depan agar tabel muncul
    $biayaItems = \App\Models\BiayaItem::all();
    $infos = \App\Models\Info::all();
    $brosurs = \App\Models\Brosur::latest()->get(); // Tambahan untuk dropdown
    return view('welcome', compact('infos', 'biayaItems', 'brosurs'));
});

// Download Brosur (Publik)
Route::get('/download-brosur/{id}', [BrosurController::class, 'download'])->name('brosur.download');

// 2. Form Pendaftaran
// Ganti 'index' menjadi 'create'
Route::get('/daftar', [PendaftarController::class, 'create']);
Route::post('/proses-daftar', [PendaftarController::class, 'store']);

// 3. Halaman Login Admin
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.proses');


/*
|--------------------------------------------------------------------------
| AREA TERKUNCI ADMIN (Harus Login Dulu)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth'])->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Home Redirect (Default Laravel)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // --- DASHBOARD ADMIN UTAMA (Statistik) ---
    // Ini halaman "Dashboard Admin" yang berisi angka-angka pendaftar
    Route::get('/admin', [PendaftarController::class, 'dashboard'])->name('admin.index');
    Route::get('/admin/export-excel', [PendaftarController::class, 'exportExcel']);

    // --- KELOLA BIAYA (Halaman Terpisah) ---
    // Ini halaman khusus untuk edit tabel biaya (MTS/MA)
    // Diakses lewat tombol di menu Info Website
    Route::get('/biaya-pendidikan', [BiayaController::class, 'index'])->name('biaya.index');
    Route::post('/biaya-pendidikan/simpan', [BiayaController::class, 'simpan'])->name('biaya.simpan');

    // --- INFO WEBSITE ---
    Route::resource('infos', InfoController::class);
    // Ini penting agar tombol 'Kembali' bekerja:
    Route::get('/infos', [InfoController::class, 'index'])->name('infos.index');

    // --- KELOLA BROSUR ---
    Route::resource('brosur', BrosurController::class)->except(['create', 'edit', 'update', 'show']);

    // --- GANTI PASSWORD (ADMIN SENDIRI) ---
    Route::get('/profile/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::put('/profile/change-password', [UserController::class, 'updateCurrentPassword'])->name('user.update-password');

    // --- KELOLA USER & PENDAFTAR ---
    Route::get('/users/cetak-kartu', [UserController::class, 'cetakKartu']);
    Route::post('/users/cetak-kartu-massal', [UserController::class, 'cetakKartuMassal']);
    Route::resource('users', UserController::class);
    Route::put('/users/siswa/{id}', [UserController::class, 'updateAkunSiswa']); // Update password siswa

    // Hapus 'index' dari except, karena sekarang kita butuh halaman index-nya
    Route::resource('pendaftar', PendaftarController::class)->except(['store']);
    Route::get('/cetak/{id}', [PendaftarController::class, 'cetak']);
    Route::get('/pendaftar/{id}/delete', [PendaftarController::class, 'destroy']);
    Route::get('/admin/download/{id}/{jenis}', [PendaftarController::class, 'download']);

    // --- DARURAT: PERBAIKAN DATABASE (Opsional, boleh dihapus nanti) ---
    Route::get('/perbaiki-database-null', function () {
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE pendaftars MODIFY nik VARCHAR(255) NULL");
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE pendaftars MODIFY tempat_lahir VARCHAR(255) NULL");
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE pendaftars MODIFY tgl_lahir DATE NULL");
            // ... tambahkan kolom lain jika perlu ...
            return "<h1>SUKSES!</h1> Database sudah diperbaiki (Nullable).";
        } catch (\Exception $e) {
            return "Gagal: " . $e->getMessage();
        }
    });


});