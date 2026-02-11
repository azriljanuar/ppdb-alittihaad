<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            // Data Fisik / Kesehatan
            $table->string('golongan_darah')->nullable()->after('berat_badan');
            $table->text('riwayat_penyakit')->nullable()->after('golongan_darah');
            
            // Data Wali (selain Ayah/Ibu)
            $table->string('nama_wali')->nullable()->after('nama_ibu');

            // Asal Mula Anak
            $table->string('status_masuk_sekolah')->nullable()->comment('Siswa Baru / Pindahan')->after('asal_sekolah'); // letakkan dekat asal sekolah
            $table->string('pindahan_dari_sekolah')->nullable()->after('status_masuk_sekolah');
            $table->date('pindahan_dari_tanggal')->nullable()->after('pindahan_dari_sekolah');
            $table->string('pindahan_dari_kelas')->nullable()->after('pindahan_dari_tanggal');
            
            // Diterima Di Sekolah Ini
            $table->date('diterima_tanggal')->nullable()->after('pindahan_dari_kelas');
            $table->string('diterima_kelas')->nullable()->after('diterima_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn([
                'golongan_darah',
                'riwayat_penyakit',
                'nama_wali',
                'status_masuk_sekolah',
                'pindahan_dari_sekolah',
                'pindahan_dari_tanggal',
                'pindahan_dari_kelas',
                'diterima_tanggal',
                'diterima_kelas'
            ]);
        });
    }
};
