<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Exports\PendaftarExport;
use Maatwebsite\Excel\Facades\Excel;

class PendaftarController extends Controller
{
    // ==========================================
    // BAGIAN 1: PUBLIK (PENDAFTARAN BARU)
    // ==========================================

    /**
     * Menampilkan Form Pendaftaran (Halaman Depan)
     * NOTE: Di routes/web.php, pastikan route '/daftar' mengarah ke method 'create' ini.
     */
    public function create() 
    { 
        return view('pendaftaran'); 
    }

    // PROSES SIMPAN DATA (DAFTAR AWAL)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'no_wa' => 'required|numeric',
            'jenjang' => 'required',
            'pilihan_asrama' => 'nullable|in:Asrama,Non-Asrama',
        ]);

        $no_daftar = 'REG-' . date('Y') . '-' . rand(1000, 9999);
        $password_acak = rand(100000, 999999);

        // Normalisasi jenjang agar cocok dengan enum di DB (RA vs RA/TA)
        $jenjang = $request->jenjang;
        if ($jenjang === 'RA/TA') { $jenjang = 'RA'; }

        $pilihanAsrama = $request->pilihan_asrama;
        if (!$pilihanAsrama || $pilihanAsrama === '-') {
            $pilihanAsrama = 'Non-Asrama';
        }

        Pendaftar::create([
            'no_daftar' => $no_daftar,
            'password' => $password_acak,
            'nama_lengkap' => $request->nama_lengkap,
            // Kolom wajib non-null di DB, isi default jika tidak tersedia di form singkat
            'nama_ayah' => $request->input('nama_ayah', '-'),
            'nama_ibu' => $request->input('nama_ibu', '-'),
            'no_wa' => $request->no_wa,
            'jenjang' => $jenjang,
            'pilihan_asrama' => $pilihanAsrama,
            'status_lulus' => 'Proses Seleksi',
            'status_pembayaran' => 'Belum Lunas',
        ]);

        return view('registrasi_sukses', compact('no_daftar', 'password_acak', 'request'));
    }

    // ==========================================
    // BAGIAN 2: SISWA (LOGIN & UPDATE DATA)
    // ==========================================
    
    public function formLoginSiswa() { return view('siswa.login'); }
    
    public function prosesLoginSiswa(Request $request) {
        $cek = Pendaftar::where('no_daftar', $request->no_daftar)->where('password', $request->password)->first();
        if($cek) { Session::put('id_siswa', $cek->id); return redirect('/siswa/dashboard'); }
        return back()->with('error', 'Login Gagal! Cek Nomor Pendaftaran & Password.');
    }

    public function dashboardSiswa() {
        if(!Session::has('id_siswa')) return redirect('/siswa/login');
        $siswa = Pendaftar::find(Session::get('id_siswa'));
        return view('siswa.dashboard', compact('siswa'));
    }

    public function logoutSiswa() { Session::forget('id_siswa'); return redirect('/siswa/login'); }

    // UPDATE DATA LENGKAP OLEH SISWA
    public function updateDataSiswa(Request $request)
    {
        if(!Session::has('id_siswa')) return redirect('/siswa/login');
        
        $id = Session::get('id_siswa');
        $siswa = Pendaftar::findOrFail($id);
        
        $allowed = [
            'nama_lengkap',
            'password',
            'nik',
            'tempat_lahir',
            'tgl_lahir',
            'jenis_kelamin',
            'anak_ke',
            'jumlah_saudara',
            'asal_sekolah',
            'status_sekolah_asal',
            'npsn_sekolah_asal',
            'kabupaten_sekolah_asal',
            'alamat_jalan',
            'rt_rw',
            'desa',
            'kecamatan',
            'kabupaten',
            'provinsi',
            'kode_pos',
            'nama_ayah',
            'nama_ibu',
            'no_kk',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
            'no_wa',
            'pilihan_asrama',
            'ukuran_seragam',
            'status_pembayaran',
            
            // Tambahan Kolom PAUD
            'nama_panggilan',
            'no_telp_rumah',
            'status_tempat_tinggal',
            'moda_transportasi',
            'jumlah_saudara_kandung',
            'jumlah_saudara_tiri',
            'jumlah_saudara_angkat',
            'status_anak',
            'bahasa_sehari_hari',
            'warga_negara',
            'agama',
            'berkebutuhan_khusus',
            'tempat_lahir_ayah',
            'tgl_lahir_ayah',
            'agama_ayah',
            'nik_ayah',
            'pendidikan_ayah',
            'penghasilan_ayah',
            'warga_negara_ayah',
            'alamat_rumah_ayah',
            'alamat_kantor_ayah',
            'tempat_lahir_ibu',
            'tgl_lahir_ibu',
            'agama_ibu',
            'nik_ibu',
            'pendidikan_ibu',
            'penghasilan_ibu',
            'warga_negara_ibu',
            'alamat_rumah_ibu',
            'alamat_kantor_ibu',
            'tinggi_badan',
            'berat_badan',
            'lingkar_kepala',
            'jarak_ke_sekolah',
            'jarak_ke_sekolah_km',
            'waktu_tempuh',
            
            // Tambahan Field MDU
            'golongan_darah',
            'riwayat_penyakit',
            'nama_wali',
            'status_masuk_sekolah',
            'pindahan_dari_sekolah',
            'pindahan_dari_tanggal',
            'pindahan_dari_kelas',
            'diterima_tanggal',
            'diterima_kelas',

            // Tambahan Field SDIT
            'nik_wali',
            'pekerjaan_wali',
            'penghasilan_wali',
            'asal_anak',
            'no_ijazah_sebelumnya',

            // Tambahan Field MTS
            'nisn',
            'hobi',
            'cita_cita',
            'jenjang_sekolah_asal',
            'ranking_semester_lalu',
            'jumlah_siswa_ranking',
            'penghasilan_keluarga',
            'prestasi_bidang',
            'prestasi_tingkat',
            'prestasi_peringkat',
            'prestasi_tahun',

            // Tambahan Field MA
            'no_skhun',
            'jumlah_adik',
            'jumlah_kakak',
        ];
        $data = $request->only($allowed);

        try {
            Log::info('updateDataSiswa:start', [
                'siswa_id' => $id,
                'keys' => array_keys($data),
                'has_files' => [
                    'file_kk_akta' => $request->hasFile('file_kk_akta'),
                    'file_ijazah' => $request->hasFile('file_ijazah'),
                    'file_kip_ktp' => $request->hasFile('file_kip_ktp'),
                    'file_foto' => $request->hasFile('file_foto'),
                    'file_skkb' => $request->hasFile('file_skkb'),
                ],
            ]);

            $files = [
                'file_kk_akta' => 'uploads/berkas',
                'file_ijazah' => 'uploads/ijazah',
                'file_kip_ktp' => 'uploads/berkas',
                'file_foto' => 'uploads/foto_diri',
                'file_skkb' => 'uploads/berkas',
            ];
            
            foreach($files as $key => $path) {
                if ($request->hasFile($key)) {
                    if($siswa->$key) Storage::disk('public')->delete($siswa->$key);
                    $stored = $request->file($key)->store($path, 'public');
                    $data[$key] = $stored;
                }
            }
            if ($request->hasFile('file_ijazah')) {
                $data['foto_ijazah'] = $data['file_ijazah'];
                unset($data['file_ijazah']);
            }

            $siswa->update($data);

            Log::info('updateDataSiswa:success', [
                'siswa_id' => $id,
                'updated_fields_count' => count($data),
            ]);

            return back()->with('success', 'Data berhasil disimpan! Silakan lanjutkan mengisi tab lainnya.');
        } catch (\Throwable $e) {
            Log::error('updateDataSiswa:error', [
                'siswa_id' => $id,
                'message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    // ==========================================
    // BAGIAN 3: ADMIN (DASHBOARD & KELOLA DATA)
    // ==========================================

    /**
     * DASHBOARD ADMIN (Hanya Statistik Angka)
     * Diakses via route: /admin
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Filter Query Dashboard
        $query = Pendaftar::query();
        if ($user->role != 'superadmin') {
            $query->where('jenjang', $user->jenjang_access);
        }

        // Hitung Statistik
        $total_pendaftar = $query->count();
        $sudah_bayar     = $query->clone()->where('status_pembayaran', 'Lunas')->count();
        $belum_verifikasi = $query->clone()->where('status_pembayaran', 'Menunggu Verifikasi')->count();

        // Return ke view 'admin' (Dashboard Statistik)
        return view('admin', compact('total_pendaftar', 'sudah_bayar', 'belum_verifikasi'));
    }

    /**
     * HALAMAN KELOLA DATA CALON SANTRI (Tabel Lengkap)
     * Diakses via route: /pendaftar (Resource Index)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Pendaftar::query();

        // 1. FILTER HAK AKSES
        if ($user->role != 'superadmin') {
            $query->where('jenjang', $user->jenjang_access);
        }

        // 2. PENCARIAN
        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_lengkap', 'like', '%' . $keyword . '%')
                  ->orWhere('no_daftar', 'like', '%' . $keyword . '%');
            });
        }

        // 3. FILTER JENJANG (SUPERADMIN)
        if ($request->filled('jenjang') && $user->role == 'superadmin') {
            $query->where('jenjang', $request->jenjang);
        }

        // HAPUS BAGIAN FILTER STATUS BAYAR DISINI KARENA SUDAH TIDAK DIPAKAI

        $pendaftars = $query->latest()->paginate(10);

        return view('pendaftar.index', compact('pendaftars'));
    }

    // EDIT DATA (ADMIN)
    public function edit($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        if(Auth::user()->role != 'superadmin' && $pendaftar->jenjang != Auth::user()->jenjang_access) {
            return redirect('/pendaftar')->with('error', 'Akses ditolak!');
        }
        return view('edit', compact('pendaftar'));
    }

    // UPDATE DATA (ADMIN)
    public function update(Request $request, $id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        
        // Batasi kolom yang boleh diupdate oleh Admin sesuai schema
        $allowedAdmin = [
            'nama_lengkap',
            'password',
            'nik',
            'tempat_lahir',
            'tgl_lahir',
            'jenis_kelamin',
            'anak_ke',
            'jumlah_saudara',
            'jenjang',
            'pilihan_asrama',
            'asal_sekolah',
            'status_sekolah_asal',
            'npsn_sekolah_asal',
            'kabupaten_sekolah_asal',
            'alamat_jalan',
            'rt_rw',
            'desa',
            'kecamatan',
            'kabupaten',
            'provinsi',
            'kode_pos',
            'nama_ayah',
            'nama_ibu',
            'no_kk',
            'pekerjaan_ayah',
            'pekerjaan_ibu',
            'no_wa',
            'status_pembayaran',
            'status_lulus',
            'ukuran_seragam',
            
            // Tambahan Kolom PAUD
            'nama_panggilan',
            'no_telp_rumah',
            'status_tempat_tinggal',
            'moda_transportasi',
            'jumlah_saudara_kandung',
            'jumlah_saudara_tiri',
            'jumlah_saudara_angkat',
            'status_anak',
            'bahasa_sehari_hari',
            'warga_negara',
            'agama',
            'berkebutuhan_khusus',
            'tempat_lahir_ayah',
            'tgl_lahir_ayah',
            'agama_ayah',
            'nik_ayah',
            'pendidikan_ayah',
            'penghasilan_ayah',
            'warga_negara_ayah',
            'alamat_rumah_ayah',
            'alamat_kantor_ayah',
            'tempat_lahir_ibu',
            'tgl_lahir_ibu',
            'agama_ibu',
            'nik_ibu',
            'pendidikan_ibu',
            'penghasilan_ibu',
            'warga_negara_ibu',
            'alamat_rumah_ibu',
            'alamat_kantor_ibu',
            'tinggi_badan',
            'berat_badan',
            'lingkar_kepala',
            'jarak_ke_sekolah',
            'jarak_ke_sekolah_km',
            'waktu_tempuh',

            // Tambahan Field MDU
            'golongan_darah',
            'riwayat_penyakit',
            'nama_wali',
            'status_masuk_sekolah',
            'pindahan_dari_sekolah',
            'pindahan_dari_tanggal',
            'pindahan_dari_kelas',
            'diterima_tanggal',
            'diterima_kelas',

            // Tambahan Field SDIT
            'nik_wali',
            'pekerjaan_wali',
            'penghasilan_wali',
            'asal_anak',
            'no_ijazah_sebelumnya',

            // Tambahan Field MTS
            'nisn',
            'hobi',
            'cita_cita',
            'jenjang_sekolah_asal',
            'ranking_semester_lalu',
            'jumlah_siswa_ranking',
            'penghasilan_keluarga',
            'prestasi_bidang',
            'prestasi_tingkat',
            'prestasi_peringkat',
            'prestasi_tahun',

            // Tambahan Field MA
            'no_skhun',
            'jumlah_adik',
            'jumlah_kakak',
        ];
        $dataToUpdate = $request->only($allowedAdmin);

        // Upload Berkas (Admin Logic) - Disederhanakan
        $files = ['file_kk_akta' => 'uploads/berkas', 'file_ijazah' => 'uploads/ijazah', 'file_kip_ktp' => 'uploads/berkas', 'file_foto' => 'uploads/foto_diri', 'file_skkb' => 'uploads/berkas'];
        
        foreach($files as $key => $path) {
            if ($request->hasFile($key)) {
                if($pendaftar->$key) Storage::disk('public')->delete($pendaftar->$key);
                $storedPath = $request->file($key)->store($path, 'public');
                
                // Mapping nama kolom khusus
                if($key == 'file_ijazah') $dataToUpdate['foto_ijazah'] = $storedPath;
                else $dataToUpdate[$key] = $storedPath;
            }
        }

        $pendaftar->update($dataToUpdate);
        
        // Redirect kembali ke halaman tabel (index), bukan dashboard
        return redirect()->route('pendaftar.index')->with('success', 'Data berhasil diperbarui!');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $p = Pendaftar::findOrFail($id);
        if(Auth::user()->role != 'superadmin' && $p->jenjang != Auth::user()->jenjang_access) {
            return back()->with('error', 'Anda tidak berhak menghapus data ini!');
        }

        // Hapus File Fisik
        $files = [$p->file_kk_akta, $p->foto_ijazah, $p->file_kip_ktp, $p->file_foto, $p->file_skkb];
        foreach($files as $f) { if($f) Storage::disk('public')->delete($f); }
        
        $p->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }

    // CETAK FORMULIR
    public function cetak($id) {
        $pendaftar = Pendaftar::findOrFail($id);
        return view('cetak', compact('pendaftar'));
    }

    // EXPORT EXCEL
    public function exportExcel(Request $request) {
        return Excel::download(new PendaftarExport($request), 'Data_PPDB_' . date('Y-m-d') . '.xlsx');
    }

    // DOWNLOAD BERKAS
    public function download($id, $jenis)
    {
        $p = Pendaftar::findOrFail($id);
        if(Auth::check() && Auth::user()->role != 'superadmin' && $p->jenjang != Auth::user()->jenjang_access) {
            return back()->with('error', 'Akses file ditolak.');
        }

        $path = null; $name = 'Berkas';
        if ($jenis == 'kk_akta') { $path = $p->file_kk_akta; $name = "KK_Akta"; }
        elseif ($jenis == 'ijazah') { $path = $p->foto_ijazah; $name = "Ijazah_SKL"; }
        elseif ($jenis == 'kip_ktp') { $path = $p->file_kip_ktp; $name = "KIP_KTP"; }
        elseif ($jenis == 'foto') { $path = $p->file_foto; $name = "Pas_Foto"; }
        elseif ($jenis == 'skkb') { $path = $p->file_skkb; $name = "SKKB"; }

        if (!$path || !Storage::disk('public')->exists($path)) return back()->with('error', 'Berkas tidak ditemukan.');
        
        $fullPath = storage_path('app/public/' . $path);
        return response()->download($fullPath, $name . '-' . $p->nama_lengkap . '.' . pathinfo($fullPath, PATHINFO_EXTENSION));
    }
}
