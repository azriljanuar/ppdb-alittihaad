<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Tampilkan Halaman Login
    public function index()
    {
        // PERBAIKAN 1: Cek dulu, kalau sudah login, jangan kasih masuk halaman login lagi
        // Langsung lempar ke Dashboard Admin
        if (Auth::check()) {
            return redirect('/admin');
        }

        return view('login');
    }

    // 2. Proses Cek Password (Satpam)
    public function login(Request $request)
    {
        // Validasi input wajib diisi
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email & password cocok dengan database
        if (Auth::attempt($credentials)) {
            
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // PERBAIKAN 2: Ganti 'intended' menjadi langsung '/admin'
            // Ini memaksa sistem untuk SELALU masuk ke dashboard setelah login sukses
            // Tidak peduli riwayat sebelumnya apa.
            return redirect('/admin');
        }

        // Kalau salah, tendang balik
        return back()->withErrors([
            'email' => 'Maaf, Email atau Password salah.',
        ])->onlyInput('email'); // Biar emailnya gak hilang pas salah password
    }

    // 3. Fungsi Keluar (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Hapus sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Balik ke halaman login
        return redirect('/login');
    }
}