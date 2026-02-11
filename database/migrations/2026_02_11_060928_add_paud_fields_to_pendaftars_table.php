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
            // I. IDENTITAS ANAK
            $table->string('nama_panggilan')->nullable();
            $table->string('no_telp_rumah')->nullable();
            $table->string('status_tempat_tinggal')->nullable(); // Milik Sendiri, Sewa, dll
            $table->string('moda_transportasi')->nullable();
            $table->integer('jumlah_saudara_kandung')->nullable();
            $table->integer('jumlah_saudara_tiri')->nullable();
            $table->integer('jumlah_saudara_angkat')->nullable();
            $table->string('status_anak')->nullable(); // Yatim/Piatu/Yatim Piatu
            $table->string('bahasa_sehari_hari')->nullable();
            $table->string('warga_negara')->nullable();
            $table->string('agama')->nullable();
            $table->string('berkebutuhan_khusus')->nullable();

            // II. IDENTITAS ORANG TUA/WALI (Ayah)
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tgl_lahir_ayah')->nullable();
            $table->string('agama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('warga_negara_ayah')->nullable();
            $table->string('alamat_rumah_ayah')->nullable();
            $table->string('alamat_kantor_ayah')->nullable();

            // II. IDENTITAS ORANG TUA/WALI (Ibu)
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tgl_lahir_ibu')->nullable();
            $table->string('agama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('warga_negara_ibu')->nullable();
            $table->string('alamat_rumah_ibu')->nullable();
            $table->string('alamat_kantor_ibu')->nullable();

            // III. DATA PERIODIK
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
            $table->decimal('berat_badan', 5, 2)->nullable(); // kg
            $table->decimal('lingkar_kepala', 5, 2)->nullable(); // cm
            $table->string('jarak_ke_sekolah')->nullable(); // Kurang dari 1 km / Lebih dari 1 km
            $table->decimal('jarak_ke_sekolah_km', 5, 2)->nullable(); // km
            $table->string('waktu_tempuh')->nullable(); // Jam/menit
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn([
                'nama_panggilan',
                'no_telp_rumah',
                'status_tempat_tinggal',
                'moda_transportasi',
                'jumlah_saudara_kandung',
                'jumlah_saudara_tiri',
                'jumlah_saudara_angkat',
                'status_anak',
                'bahasa_sehari_hari',
                'warga_negara',
                'agama',
                'berkebutuhan_khusus',
                'tempat_lahir_ayah',
                'tgl_lahir_ayah',
                'agama_ayah',
                'nik_ayah',
                'pendidikan_ayah',
                'penghasilan_ayah',
                'warga_negara_ayah',
                'alamat_rumah_ayah',
                'alamat_kantor_ayah',
                'tempat_lahir_ibu',
                'tgl_lahir_ibu',
                'agama_ibu',
                'nik_ibu',
                'pendidikan_ibu',
                'penghasilan_ibu',
                'warga_negara_ibu',
                'alamat_rumah_ibu',
                'alamat_kantor_ibu',
                'tinggi_badan',
                'berat_badan',
                'lingkar_kepala',
                'jarak_ke_sekolah',
                'jarak_ke_sekolah_km',
                'waktu_tempuh',
            ]);
        });
    }
};
