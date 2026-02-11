<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiayaItem; 
use Illuminate\Support\Facades\Auth;

class BiayaController extends Controller
{
    // Fungsi untuk menampilkan Halaman Edit Biaya
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Cek Hak Akses
        if ($user->role == 'superadmin') {
            $allowed_jenjangs = ['PAUD', 'RA/TK', 'SDIT', 'MDU', 'MTS', 'MA'];
        } else {
            $allowed_jenjangs = [$user->jenjang_access]; 
        }

        // Tentukan jenjang yang sedang diedit (datang dari tombol pada Info per jenjang)
        $selectedJenjang = $request->query('jenjang');

        // PROTEKSI KHUSUS: SDIT tidak boleh edit biaya
        if ($selectedJenjang == 'SDIT') {
            return redirect()->route('infos.index')->with('error', 'Fitur edit biaya untuk SDIT dinonaktifkan.');
        }

        if (!$selectedJenjang) {
            // Fallback: gunakan akses jenjang admin jika bukan superadmin
            $selectedJenjang = $user->role == 'superadmin' ? ($allowed_jenjangs[0] ?? null) : $user->jenjang_access;
            
            // Jika fallback kena SDIT, cari yang lain
            if ($selectedJenjang == 'SDIT' && $user->role == 'superadmin') {
                 // Cari jenjang pertama yang bukan SDIT
                 foreach ($allowed_jenjangs as $j) {
                     if ($j != 'SDIT') {
                         $selectedJenjang = $j;
                         break;
                     }
                 }
            }
        }

        // Ambil data biaya
        $biaya_items = BiayaItem::whereIn('jenjang', $allowed_jenjangs)->get();

        // PENTING: Memanggil file 'resources/views/biaya.blade.php'
        return view('biaya', compact('biaya_items', 'allowed_jenjangs', 'selectedJenjang'));
    }

    // Fungsi untuk Menyimpan/Update Biaya
    public function simpan(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'jenjang' => 'required',
            'kategori' => 'required', // Asrama / Non-Asrama
            'gender' => 'required',   // Putra / Putri
            'nama_item' => 'required|array',
            'nominal' => 'required|array',
        ]);

        $user = Auth::user();
        
        // Proteksi: Admin Jenjang tidak boleh edit jenjang lain
        if ($user->role != 'superadmin' && $request->jenjang != $user->jenjang_access) {
            return back()->with('error', 'Anda tidak berhak mengubah jenjang ini!');
        }

        // 2. HAPUS DATA LAMA (Reset untuk kategori yang sedang diedit)
        // Agar data bersih dan tidak duplikat saat disave ulang
        BiayaItem::where('jenjang', $request->jenjang)
            ->where('kategori', $request->kategori)
            ->where('gender', $request->gender)
            ->delete();

        // 3. SIMPAN DATA BARU
        $items = $request->nama_item;
        $nominals = $request->nominal;

        foreach ($items as $index => $nama) {
            if (!empty($nama) && isset($nominals[$index])) {
                // Hapus "Rp " dan "." agar jadi angka murni untuk database
                $nominalBersih = str_replace(['Rp', '.', ' '], '', $nominals[$index]);

                BiayaItem::create([
                    'jenjang' => $request->jenjang,
                    'kategori' => $request->kategori,
                    'gender' => $request->gender,
                    'nama_item' => $nama,
                    'nominal' => $nominalBersih,
                ]);
            }
        }

        return back()->with('success', 'Data Biaya Berhasil Disimpan!');
    }
}
