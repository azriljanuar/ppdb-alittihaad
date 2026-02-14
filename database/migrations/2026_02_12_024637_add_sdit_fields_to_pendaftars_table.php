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
            // Tambahan Field SDIT
            $table->string('nik_wali')->nullable()->after('nama_wali');
            $table->string('pekerjaan_wali')->nullable()->after('nik_wali');
            $table->string('penghasilan_wali')->nullable()->after('pekerjaan_wali');
            
            $table->string('asal_anak')->nullable()->comment('Rumah Tangga / Taman Kanak-kanak')->after('status_masuk_sekolah');
            $table->string('no_ijazah_sebelumnya')->nullable()->after('asal_anak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn([
                'nik_wali',
                'pekerjaan_wali',
                'penghasilan_wali',
                'asal_anak',
                'no_ijazah_sebelumnya',
            ]);
        });
    }
};
