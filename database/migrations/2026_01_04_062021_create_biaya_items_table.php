<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('biaya_items', function (Blueprint $table) {
            $table->id();

            // 3 Kolom Penentu (Kunci Pembeda)
            $table->string('jenjang');   // Contoh: 'MTS' atau 'MA'
            $table->string('kategori');  // Contoh: 'Asrama' atau 'Non-Asrama'
            $table->string('gender');    // Contoh: 'Putra' atau 'Putri'

            // Data Biayanya
            $table->string('nama_item'); // Contoh: 'Seragam', 'Kitab', 'SPP Bulan Juli'
            $table->integer('nominal');  // Contoh: 1500000 (Gunakan integer/bigInteger, jangan string)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya_items');
    }
};
