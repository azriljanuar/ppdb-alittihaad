<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('no_daftar')->unique(); // Kode unik (misal: REG-001)
            $table->string('nama_lengkap');
            $table->string('nik', 16)->nullable(); // NIK Santri
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenjang', ['PAUD', 'RA', 'SDIT', 'MDU', 'MTS', 'MA']);
            $table->enum('pilihan_asrama', ['Asrama', 'Non-Asrama'])->nullable(); // Khusus MTS/MA
            $table->string('asal_sekolah')->nullable(); // Khusus pendaftar baru
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('no_wa');
            $table->string('password')->nullable(); // Password untuk login siswa
            $table->string('file_kk_akta')->nullable(); // File KK/Akta
            $table->string('file_ijazah')->nullable(); // File Ijazah
            $table->string('file_kip_ktp')->nullable(); // File KIP/KTP
            $table->string('file_foto')->nullable(); // File Foto
            $table->string('file_skkb')->nullable(); // File SKKB
            $table->string('bukti_transfer')->nullable(); // Untuk upload foto
            $table->string('foto_kk')->nullable();      // Laci untuk KK
            $table->string('foto_ijazah')->nullable();  // Laci untuk Ijazah/Akta
            $table->enum('status_pembayaran', ['Belum Lunas', 'Menunggu Verifikasi', 'Lunas'])->default('Belum Lunas');
            $table->enum('status_lulus', ['Proses Seleksi', 'Diterima', 'Ditolak'])->default('Proses Seleksi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};