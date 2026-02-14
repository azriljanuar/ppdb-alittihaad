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
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('feature1_title')->nullable()->default('Kurikulum Terpadu');
            $table->string('feature1_desc')->nullable()->default('Memadukan kurikulum nasional dan kepesantrenan.');
            $table->string('feature2_title')->nullable()->default('Prestasi Santri');
            $table->string('feature2_desc')->nullable()->default('Mencetak juara di tingkat regional hingga nasional.');
            $table->string('feature3_title')->nullable()->default('Lingkungan Islami');
            $table->string('feature3_desc')->nullable()->default('Pembiasaan akhlak mulia dan ibadah sehari-hari.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn([
                'feature1_title', 'feature1_desc',
                'feature2_title', 'feature2_desc',
                'feature3_title', 'feature3_desc'
            ]);
        });
    }
};
