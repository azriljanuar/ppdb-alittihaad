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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable();
            $table->string('site_logo')->nullable(); // SVG or Image
            $table->string('site_icon')->nullable(); // Favicon
            $table->string('hero_title')->nullable();
            $table->string('hero_title_highlight')->nullable(); // Bagian warna warni
            $table->text('hero_description')->nullable();
            $table->string('hero_badge')->nullable(); // Teks badge di atas judul
            $table->string('hero_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
