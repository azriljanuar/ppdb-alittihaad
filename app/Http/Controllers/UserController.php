<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendaftar; // <--- JANGAN LUPA INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. TAMPILKAN HALAMAN KELOLA USER
    public function index()
    {
        // Ambil data admin
        $users = User::latest()->get();
        
        // Ambil data siswa (Hanya ambil yg kolomnya penting aja biar ringan)
        $siswas = Pendaftar::select('id', 'nama_lengkap', 'no_daftar', 'password', 'jenjang')->latest()->get();

        return view('users.index', compact('users', 'siswas'));
    }

    // 2. SIMPAN ADMIN BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required'
        ]);

        $generatedPassword = Str::random(8);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($generatedPassword),
            'password_text' => $generatedPassword,
            'role' => $request->role,
            'jenjang_access' => $request->role == 'superadmin' ? null : $request->jenjang_access,
        ]);

        return redirect()->back()->with('success', 'User Admin berhasil ditambahkan! Password: ' . $generatedPassword);
    }

    // 3. UPDATE DATA ADMIN (Fitur Edit)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id, // Cek unik kecuali punya sendiri
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'jenjang_access' => $request->role == 'superadmin' ? null : $request->jenjang_access,
        ];

        // Kalau password diisi, baru kita update. Kalau kosong, biarkan password lama.
        if($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_text'] = $request->password;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Data Admin berhasil diperbarui!');
    }

    // 4. HAPUS ADMIN
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Admin berhasil dihapus!');
    }

    // 5. UPDATE AKUN SISWA (Ganti Password)
    public function updateAkunSiswa(Request $request, $id)
    {
        $siswa = Pendaftar::findOrFail($id);
        
        // Update password (disimpan text biasa sesuai request sebelumnya)
        if($request->filled('password_baru')) {
            $siswa->update([
                'password' => $request->password_baru
            ]);
            return redirect()->back()->with('success', 'Password siswa berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Password tidak boleh kosong!');
    }

    // 6. CETAK KARTU USER
    public function cetakKartu(Request $request) {
        $type = $request->query('type');
        $id = $request->query('id');
        
        $data = null;
        if($type == 'admin') {
            $data = User::findOrFail($id);
            // Password admin diambil dari password_text
            $data->password_plain = $data->password_text; 
        } else {
            $data = Pendaftar::findOrFail($id);
            // Password siswa sudah plain di kolom password (sesuai implementasi sebelumnya)
            $data->password_plain = $data->password;
        }
        
        return view('users.cetak_kartu', compact('data', 'type'));
    }

    // 7. CETAK KARTU MASSAL
    public function cetakKartuMassal(Request $request) {
        $type = $request->input('type');
        $ids = $request->input('ids');

        if(empty($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu data untuk dicetak!');
        }

        $data_collection = [];
        if($type == 'admin') {
            $data_collection = User::whereIn('id', $ids)->get();
            // Map password plain
            $data_collection->map(function($user) {
                $user->password_plain = $user->password_text;
                return $user;
            });
        } else {
            $data_collection = Pendaftar::whereIn('id', $ids)->get();
            // Map password plain
            $data_collection->map(function($siswa) {
                $siswa->password_plain = $siswa->password;
                return $siswa;
            });
        }

        // Kita kirim sebagai 'data_collection' agar view bisa looping
        return view('users.cetak_kartu', compact('data_collection', 'type'));
    }

    // 8. GANTI PASSWORD SENDIRI (Admin Login)
    public function showChangePasswordForm()
    {
        return view('users.change_password');
    }

    public function updateCurrentPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        /** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->password),
            'password_text' => $request->password
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}