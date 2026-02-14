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
            $table->string('no_skhun')->nullable();
            $table->string('jumlah_adik')->nullable();
            $table->string('jumlah_kakak')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->dropColumn(['no_skhun', 'jumlah_adik', 'jumlah_kakak']);
        });
    }
};
