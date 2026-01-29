<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // PENTING: Tambahkan ini untuk format tanggal
use App\Models\BiayaItem; // <--- PENTING

class InfoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'superadmin') {
            $allowed_jenjangs = ['PAUD', 'RA/TK', 'SDIT', 'MDU', 'MTS', 'MA'];
        } else {
            $allowed_jenjangs = [$user->jenjang_access];
        }

        // Ensure 'Profile' category exists for each jenjang
        foreach ($allowed_jenjangs as $jenjang) {
            Info::firstOrCreate(
                ['jenjang' => $jenjang, 'kategori' => 'Profile'],
                ['judul' => 'Profil ' . $jenjang, 'deskripsi' => '']
            );
        }

        $infos = Info::whereIn('jenjang', $allowed_jenjangs)->get();

        // TAMBAHAN BARU: Ambil data biaya dinamis juga
        $biayaItems = BiayaItem::whereIn('jenjang', $allowed_jenjangs)->get();

        return view('infos.index', compact('infos', 'allowed_jenjangs', 'biayaItems'));
    }

    // Fungsi Bantuan: Ubah 2026-05-05 jadi 5 Mei 2026
    private function formatTgl($tgl)
    {
        if (!$tgl)
            return '-';
        return Carbon::parse($tgl)->locale('id')->translatedFormat('d F Y');
    }

    public function update(Request $request, $id)
    {
        $info = Info::findOrFail($id);

        $user = Auth::user();
        if ($user->role != 'superadmin' && $info->jenjang != $user->akses_jenjang) {
            return back()->with('error', 'Akses Ditolak!');
        }

        // --- 1. LOGIKA BIAYA ---
        if ($info->kategori == 'Biaya') {
            $pdf = $request->input('biaya_pendaftaran', 0);
            $up = $request->input('biaya_uang_pangkal', 0);
            $srg = $request->input('biaya_seragam', 0);
            $add = $request->input('info_tambahan', '-');
            $total = $pdf + $up + $srg;

            $htmlContent = "
                <div style='font-family: sans-serif;'>
                    <table style='width: 100%; border-collapse: collapse; margin-bottom: 15px;'>
                        <tr style='background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;'>
                            <th style='text-align: left; padding: 12px; color: #495057;'>Komponen Biaya</th>
                            <th style='text-align: right; padding: 12px; color: #495057;'>Nominal</th>
                        </tr>
                        <tr><td style='padding: 10px; border-bottom: 1px solid #eee;'>Pendaftaran</td><td style='text-align: right; padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;'>Rp " . number_format($pdf, 0, ',', '.') . "</td></tr>
                        <tr><td style='padding: 10px; border-bottom: 1px solid #eee;'>Uang Pangkal</td><td style='text-align: right; padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;'>Rp " . number_format($up, 0, ',', '.') . "</td></tr>
                        <tr><td style='padding: 10px; border-bottom: 1px solid #eee;'>Seragam</td><td style='text-align: right; padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;'>Rp " . number_format($srg, 0, ',', '.') . "</td></tr>
                        <tr style='background-color: #d1fae5;'>
                            <td style='padding: 12px; font-weight: bold; color: #064e3b;'>TOTAL ESTIMASI</td>
                            <td style='text-align: right; padding: 12px; font-weight: bold; color: #064e3b; font-size: 1.1em;'>Rp " . number_format($total, 0, ',', '.') . "</td>
                        </tr>
                    </table>
                    <div style='background-color: #fffbeb; border: 1px solid #fcd34d; padding: 15px; border-radius: 8px; font-size: 0.9em; color: #92400e;'><strong>ℹ️ Info Tambahan:</strong><br>" . nl2br($add) . "</div>
                </div>";

            $info->update([
                'biaya_pendaftaran' => $pdf,
                'biaya_uang_pangkal' => $up,
                'biaya_seragam' => $srg,
                'info_tambahan' => $add,
                'deskripsi' => $htmlContent
            ]);

            // --- 2. LOGIKA JADWAL (UPDATE: DINAMIS JSON) ---
        } elseif ($info->kategori == 'Jadwal') {
            $raw = $request->input('jadwal_raw', '');
            $jadwalData = [];
            $htmlRows = '';

            if (is_string($raw) && strlen(trim($raw)) > 0) {
                $lines = preg_split("/\\r\\n|\\n|\\r/", $raw);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '') continue;
                    $parts = array_map('trim', explode('|', $line, 2));
                    $kgt = $parts[0] ?? '';
                    $tgl = $parts[1] ?? '-';
                    if ($kgt !== '') {
                        $jadwalData[] = ['kegiatan' => $kgt, 'tanggal' => $tgl];
                        $htmlRows .= "
                            <tr style='border-bottom: 1px solid #f0f0f0;'>
                                <td style='padding: 12px 5px; color: #6c757d; width: 40%;'>{$kgt}</td>
                                <td style='padding: 12px 5px; font-weight: 700; color: #333; text-align: right;'>{$tgl}</td>
                            </tr>";
                    }
                }
            }

            if ($htmlRows === '') {
                $kegiatan = $request->input('kegiatan', []);
                $tanggal = $request->input('tanggal', []);
                if (!is_array($kegiatan)) $kegiatan = [];
                if (!is_array($tanggal)) $tanggal = [];
                foreach ($kegiatan as $index => $kgt) {
                    $kgt = trim($kgt);
                    $tgl = trim($tanggal[$index] ?? '-');
                    if ($kgt !== '') {
                        $jadwalData[] = ['kegiatan' => $kgt, 'tanggal' => $tgl];
                        $htmlRows .= "
                            <tr style='border-bottom: 1px solid #f0f0f0;'>
                                <td style='padding: 12px 5px; color: #6c757d; width: 40%;'>{$kgt}</td>
                                <td style='padding: 12px 5px; font-weight: 700; color: #333; text-align: right;'>{$tgl}</td>
                            </tr>";
                    }
                }
            }

            if ($htmlRows === '') {
                $htmlRows = "<tr><td colspan='2' style='text-align:center; padding: 20px; color: #999; font-style: italic;'>Belum ada jadwal kegiatan yang diatur.</td></tr>";
            }

            $htmlContent = "
                <div style='font-family: sans-serif;'>
                    <h5 style='color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 5px; margin-top: 10px;'>Jadwal Kegiatan</h5>
                    <table style='width: 100%; border-collapse: separate; border-spacing: 0;'>
                        <tbody>
                            {$htmlRows}
                        </tbody>
                    </table>
                </div>";

            $info->update([
                'jadwal_json' => $jadwalData,
                'deskripsi' => $htmlContent
            ]);

            // --- 3. SYARAT/BEASISWA ---
        } elseif ($info->kategori == 'Syarat' || $info->kategori == 'Beasiswa') {
            $raw = ($info->kategori == 'Syarat') ? $request->syarat_raw : $request->beasiswa_raw;
            $lines = explode("\n", $raw);
            $listHtml = "<ul style='padding-left: 20px; line-height: 1.6;'>";
            foreach ($lines as $line) {
                if (trim($line) != "")
                    $listHtml .= "<li style='margin-bottom: 5px;'>" . trim($line) . "</li>";
            }
            $listHtml .= "</ul>";

            $dataUpdate = ['deskripsi' => $listHtml];
            if ($info->kategori == 'Syarat')
                $dataUpdate['syarat_raw'] = $raw;
            else
                $dataUpdate['beasiswa_raw'] = $raw;
            $info->update($dataUpdate);
            
            // --- 4. LOGIKA PROFILE (GAMBAR & DESKRIPSI) ---
        } elseif ($info->kategori == 'Profile') {
            $request->validate([
                'deskripsi' => 'nullable|string',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $currentImages = $info->images ?? [];

            // Hapus gambar yang dicentang
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $img) {
                    if (($key = array_search($img, $currentImages)) !== false) {
                        unset($currentImages[$key]);
                        // Opsional: Hapus file fisik jika perlu
                    }
                }
                $currentImages = array_values($currentImages);
            }

            // Upload gambar baru
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('jenjang_images', 'public');
                    $currentImages[] = $path;
                }
            }

            $info->update([
                'deskripsi' => $request->deskripsi,
                'images' => $currentImages
            ]);

        } else {
            $info->update(['deskripsi' => $request->deskripsi]);
        }

        return back()->with('success', 'Data Informasi Berhasil Diupdate!');
    }
}
