<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendaftar; // <--- JANGAN LUPA INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'jenjang_access' => $request->role == 'superadmin' ? null : $request->jenjang_access,
        ]);

        return redirect()->back()->with('success', 'User Admin berhasil ditambahkan!');
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
}