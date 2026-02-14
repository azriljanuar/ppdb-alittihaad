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
            $table->string('nisn')->nullable();
            $table->string('hobi')->nullable();
            $table->string('cita_cita')->nullable();
            $table->string('jenjang_sekolah_asal')->nullable();
            $table->string('ranking_semester_lalu')->nullable();
            $table->string('jumlah_siswa_ranking')->nullable();
            $table->string('penghasilan_keluarga')->nullable();
            $table->string('prestasi_bidang')->nullable();
            $table->string('prestasi_tingkat')->nullable();
            $table->string('prestasi_peringkat')->nullable();
            $table->string('prestasi_tahun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn([
                'nisn',
                'hobi',
                'cita_cita',
                'jenjang_sekolah_asal',
                'ranking_semester_lalu',
                'jumlah_siswa_ranking',
                'penghasilan_keluarga',
                'prestasi_bidang',
                'prestasi_tingkat',
                'prestasi_peringkat',
                'prestasi_tahun'
            ]);
        });
    }
};
