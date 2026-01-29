<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Info;

class InfoSeeder extends Seeder
{
    public function run()
    {
        // 1. Kosongkan tabel info dulu agar tidak duplikat
        Info::truncate();

        // 2. Daftar Jenjang & Kategori
        $jenjangs = ['PAUD', 'RA/TK', 'SDIT', 'MDU', 'MTS', 'MA'];
        $kategoris = ['Biaya', 'Jadwal', 'Syarat', 'Beasiswa'];

        // 3. Template HTML (Baku)
        
        // A. Template JADWAL (Header Abu-abu)
        $templateJadwal = <<<EOD
<div style="font-family: 'Poppins', sans-serif;">
    <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
        <tbody>
            <tr>
                <td colspan="2" style="background-color: #e9ecef; padding: 12px 15px; font-weight: 700; color: #6c757d; text-align: center; border-radius: 4px;">
                    Gelombang 1 / Jalur Internal
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d; font-style: italic; width: 40%;">Pendaftaran</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">1 Januari - 30 Januari 2026</td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d; font-style: italic;">Tes Seleksi</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">5 Februari 2026</td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d; font-style: italic;">Pengumuman</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">10 Februari 2026</td>
            </tr>
            <tr><td colspan="2" style="height: 20px;"></td></tr>
            <tr>
                <td colspan="2" style="background-color: #e9ecef; padding: 12px 15px; font-weight: 700; color: #6c757d; text-align: center; border-radius: 4px;">
                    Gelombang 2 / Jalur Umum
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d; font-style: italic;">Pendaftaran</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">1 Maret - 30 April 2026</td>
            </tr>
             <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d; font-style: italic;">Tes Seleksi</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">5 Mei 2026</td>
            </tr>
        </tbody>
    </table>
</div>
EOD;

        // B. Template BIAYA (Header Hijau)
        $templateBiaya = <<<EOD
<div style="font-family: 'Poppins', sans-serif;">
    <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
        <tbody>
            <tr>
                <td colspan="2" style="background-color: #d1e7dd; padding: 12px 15px; font-weight: 700; color: #0f5132; text-align: center; border-radius: 4px;">
                    Estimasi Biaya Masuk
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d; width: 50%;">Pendaftaran</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">Rp 250.000</td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d;">Uang Pangkal</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">Rp 5.000.000</td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 15px 5px; color: #6c757d;">Seragam</td>
                <td style="padding: 15px 5px; font-weight: 700; color: #333; text-align: right;">Rp 1.000.000</td>
            </tr>
            <tr>
                <td style="padding: 15px 5px; font-weight: 700; color: #198754;">TOTAL</td>
                <td style="padding: 15px 5px; font-weight: 800; color: #198754; text-align: right; font-size: 1.1em;">Rp 6.250.000</td>
            </tr>
        </tbody>
    </table>
</div>
EOD;

        // C. Template SYARAT (List)
        $templateSyarat = <<<EOD
<ul>
    <li>Mengisi Formulir Pendaftaran Online/Offline.</li>
    <li>Melampirkan Fotokopi Kartu Keluarga (KK) & Akta Kelahiran.</li>
    <li>Melampirkan Ijazah terakhir (Legalisir).</li>
    <li>Pas Foto ukuran 3x4 (Background Merah/Biru).</li>
    <li>Lulus Tes Seleksi (Baca Al-Qur'an & Wawancara).</li>
</ul>
EOD;

        // D. Template BEASISWA
        $templateBeasiswa = <<<EOD
<p>Pesantren menyediakan beasiswa bagi santri yang memenuhi kriteria:</p>
<ol>
    <li><strong>Beasiswa Tahfidz:</strong> Hafal minimal 3 Juz Al-Qur'an (Bebas SPP 6 Bulan).</li>
    <li><strong>Beasiswa Prestasi:</strong> Juara 1-3 Tingkat Kabupaten/Kota (Potongan Uang Pangkal 50%).</li>
    <li><strong>Beasiswa Yatim/Dhuafa:</strong> Menyertakan SKTM (Keringanan Biaya sesuai kebijakan).</li>
</ol>
EOD;

        // 4. LOOPING: Masukkan data ke Database
        foreach ($jenjangs as $jenjang) {
            foreach ($kategoris as $kategori) {
                
                // Tentukan isi berdasarkan kategori
                $isi = '';
                if ($kategori == 'Biaya') $isi = $templateBiaya;
                elseif ($kategori == 'Jadwal') $isi = $templateJadwal;
                elseif ($kategori == 'Syarat') $isi = $templateSyarat;
                elseif ($kategori == 'Beasiswa') $isi = $templateBeasiswa;

                Info::create([
                    'jenjang' => $jenjang,
                    'kategori' => $kategori,
                    'judul' => $kategori, // <--- INI PERBAIKANNYA (Menambahkan kolom Judul)
                    'deskripsi' => $isi
                ]);
            }
        }
    }
}
