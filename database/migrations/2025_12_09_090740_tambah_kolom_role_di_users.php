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
    Schema::table('users', function (Blueprint $table) {
        // Kolom 'role' untuk jabatan: superadmin, admin, atau kepsek
        $table->string('role')->default('admin'); 

        // Kolom 'jenjang_access' untuk tahu dia admin bagian apa (SDIT, MTS, atau MA)
        // Kita buat 'nullable' (boleh kosong) karena Super Admin tidak terikat jenjang
        $table->string('jenjang_access')->nullable(); 
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'jenjang_access']);
    });
}
};
