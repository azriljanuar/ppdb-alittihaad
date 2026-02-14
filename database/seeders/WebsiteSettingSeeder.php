<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\WebsiteSetting::create([
            'site_title' => 'PPDB Al-Ittihaad - Generasi Qurani',
            'site_logo' => null, // Default: null (use hardcoded or fallback)
            'site_icon' => null,
            'hero_title' => 'Membangun Generasi',
            'hero_title_highlight' => 'Qurani & Berprestasi',
            'hero_description' => 'Bergabunglah bersama kami di Al-Ittihaad. Kurikulum terpadu berbasis Al-Qur\'an dan Sains untuk masa depan gemilang buah hati Anda.',
            'hero_badge' => 'Pendaftaran 2025/2026 Dibuka',
            'hero_image' => 'https://img.freepik.com/free-photo/group-diverse-grads-throwing-caps-up-sky_53876-56031.jpg',
        ]);
    }
}
