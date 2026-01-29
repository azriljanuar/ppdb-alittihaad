<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;

class PendaftarExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    // Menerima data Request (Filter) dari Controller
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $user = Auth::user();
        $query = Pendaftar::query();

        // 1. FILTER KEAMANAN (WAJIB)
        // Jika bukan Superadmin, paksa hanya download jenjang miliknya
        if ($user->role != 'superadmin') {
            $query->where('jenjang', $user->akses_jenjang);
        }

        // 2. FILTER DARI FORM (Dropdown di halaman Admin)
        
        // Filter Jenjang (Khusus Superadmin)
        if ($this->request->filled('jenjang') && $user->role == 'superadmin') {
            $query->where('jenjang', $this->request->jenjang);
        }

        // Filter Status Bayar
        if ($this->request->filled('status_bayar')) {
            $query->where('status_pembayaran', $this->request->status_bayar);
        }

        // Filter Pencarian Nama
        if ($this->request->filled('cari')) {
            $keyword = $this->request->cari;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_lengkap', 'like', '%' . $keyword . '%')
                  ->orWhere('no_daftar', 'like', '%' . $keyword . '%');
            });
        }

        // Urutkan dari yang terbaru
        return $query->latest();
    }

    // Menentukan Judul Kolom di Excel
    public function headings(): array
    {
        return [
            'No Pendaftaran',
            'Tanggal Daftar',
            'Nama Lengkap',
            'Jenjang',
            'Asal Sekolah',
            'No WA',
            'Pilihan Asrama',
            'Status Pembayaran',
            'Ukuran Seragam',
        ];
    }

    // Menentukan Data apa saja yang masuk ke kolom
    public function map($pendaftar): array
    {
        return [
            $pendaftar->no_daftar,
            $pendaftar->created_at->format('d-m-Y'), // Format Tanggal
            $pendaftar->nama_lengkap,
            $pendaftar->jenjang,
            $pendaftar->asal_sekolah,
            $pendaftar->no_wa . ' ', // Tambah spasi biar tidak jadi format ilmiah di excel
            $pendaftar->pilihan_asrama,
            $pendaftar->status_pembayaran,
            $pendaftar->ukuran_seragam,
        ];
    }
}