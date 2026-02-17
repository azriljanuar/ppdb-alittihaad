<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->text('footer_about')->nullable()->after('feature3_desc');
            $table->string('footer_whatsapp')->nullable()->after('footer_about');
            $table->string('footer_address')->nullable()->after('footer_whatsapp');
            $table->string('footer_email')->nullable()->after('footer_address');
            $table->string('footer_links_label')->nullable()->after('footer_email');
            $table->string('footer_copyright')->nullable()->after('footer_links_label');
        });
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_about',
                'footer_whatsapp',
                'footer_address',
                'footer_email',
                'footer_links_label',
                'footer_copyright',
            ]);
        });
    }
};

