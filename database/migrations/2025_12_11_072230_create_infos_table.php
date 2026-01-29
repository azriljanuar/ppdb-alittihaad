<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('infos', function (Blueprint $table) {
        $table->id();
        $table->string('jenjang'); // SDIT, MTS, MA, dll
        $table->string('kategori'); // biaya, jadwal, ketentuan, beasiswa
        $table->string('judul'); // Contoh: "Rincian Biaya Masuk"
        $table->text('deskripsi')->nullable(); // Isinya (bisa panjang)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
