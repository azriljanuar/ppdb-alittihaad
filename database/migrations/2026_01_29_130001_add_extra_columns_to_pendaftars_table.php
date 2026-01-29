<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            // Data diri tambahan
            $table->string('jenis_kelamin')->nullable();
            $table->unsignedInteger('anak_ke')->nullable();
            $table->unsignedInteger('jumlah_saudara')->nullable();
            $table->string('ukuran_seragam')->nullable();

            // Sekolah asal detail
            $table->string('status_sekolah_asal')->nullable(); // Negeri / Swasta
            $table->string('npsn_sekolah_asal')->nullable();
            $table->string('kabupaten_sekolah_asal')->nullable();

            // Alamat domisili
            $table->string('alamat_jalan')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();

            // Orang tua
            $table->string('no_kk')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'anak_ke',
                'jumlah_saudara',
                'ukuran_seragam',
                'status_sekolah_asal',
                'npsn_sekolah_asal',
                'kabupaten_sekolah_asal',
                'alamat_jalan',
                'rt_rw',
                'desa',
                'kecamatan',
                'kabupaten',
                'provinsi',
                'kode_pos',
                'no_kk',
                'pekerjaan_ayah',
                'pekerjaan_ibu',
            ]);
        });
    }
};
