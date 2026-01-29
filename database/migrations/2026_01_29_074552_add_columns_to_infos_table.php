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
        Schema::table('infos', function (Blueprint $table) {
            // Kolom Biaya
            $table->integer('biaya_pendaftaran')->nullable();
            $table->integer('biaya_uang_pangkal')->nullable();
            $table->integer('biaya_seragam')->nullable();
            $table->text('info_tambahan')->nullable();

            // Kolom Jadwal
            $table->string('jadwal_pendaftaran_1')->nullable(); // format: start|end
            $table->date('jadwal_tes_1')->nullable();
            $table->date('jadwal_pengumuman_1')->nullable();
            
            $table->string('jadwal_pendaftaran_2')->nullable(); // format: start|end
            $table->date('jadwal_tes_2')->nullable();
            $table->date('jadwal_pengumuman_2')->nullable();

            // Kolom Syarat & Beasiswa (Raw Text)
            $table->text('syarat_raw')->nullable();
            $table->text('beasiswa_raw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('infos', function (Blueprint $table) {
            $table->dropColumn([
                'biaya_pendaftaran',
                'biaya_uang_pangkal',
                'biaya_seragam',
                'info_tambahan',
                'jadwal_pendaftaran_1',
                'jadwal_tes_1',
                'jadwal_pengumuman_1',
                'jadwal_pendaftaran_2',
                'jadwal_tes_2',
                'jadwal_pengumuman_2',
                'syarat_raw',
                'beasiswa_raw'
            ]);
        });
    }
};
