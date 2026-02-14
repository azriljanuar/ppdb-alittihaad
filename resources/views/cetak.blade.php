<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran - {{ $pendaftar->no_daftar }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; margin: 0; padding: 20px; color: #000; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; border: 1px solid #000; padding: 30px; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2, .header h3, .header p { margin: 0; }
        .header h2 { font-size: 16pt; text-transform: uppercase; }
        .header h3 { font-size: 14pt; }
        .header p { font-size: 10pt; font-style: italic; }
        
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; font-size: 14pt; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td { padding: 4px; vertical-align: top; }
        .label { width: 180px; font-weight: bold; }
        .separator { width: 10px; }
        
        .section-title { font-weight: bold; background-color: #eee; padding: 5px; margin-top: 15px; margin-bottom: 5px; border: 1px solid #000; font-size: 11pt; }
        
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature { text-align: center; width: 200px; }
        .notes { border: 1px dashed #000; padding: 10px; font-size: 9pt; margin-top: 20px; }
        
        .btn-print { background: #064e3b; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 14px; border-radius: 5px; margin-bottom: 20px; }
        @media print { .btn-print, .no-print { display: none; } .container { border: none; padding: 0; } }
    </style>
</head>
<body>

    <center class="no-print">
        <button onclick="window.print()" class="btn-print">🖨️ KLIK UNTUK MENCETAK / SIMPAN PDF</button>
    </center>

    <div class="container">
        <div class="header">
            <h2>PANITIA PENERIMAAN PESERTA DIDIK BARU</h2>
            <h3>PESANTREN PERSATUAN ISLAM 104 AL-ITTIHAAD</h3>
            <p>Jl. Raya Rancapandan km 5, Kabupaten Garut, Jawa Barat</p>
        </div>

        <div class="title">TANDA BUKTI PENDAFTARAN</div>

        <table>
            <tr>
                <td class="label">Nomor Pendaftaran</td><td class="separator">:</td>
                <td style="font-size: 14pt; font-weight: bold;">{{ $pendaftar->no_daftar }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Daftar</td><td class="separator">:</td>
                <td>{{ $pendaftar->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Jenjang Dituju</td><td class="separator">:</td>
                <td><strong>{{ $pendaftar->jenjang }}</strong> ({{ $pendaftar->pilihan_asrama }})</td>
            </tr>
        </table>

        <div class="section-title">A. DATA CALON SANTRI</div>
        <table>
            <tr><td class="label">Nama Lengkap</td><td class="separator">:</td><td>{{ $pendaftar->nama_lengkap }}</td></tr>
            <tr><td class="label">NIK</td><td class="separator">:</td><td>{{ $pendaftar->nik }}</td></tr>
            <tr><td class="label">Jenis Kelamin</td><td class="separator">:</td><td>{{ $pendaftar->jenis_kelamin }}</td></tr>
            <tr><td class="label">Tempat, Tgl Lahir</td><td class="separator">:</td><td>{{ $pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->tgl_lahir)->format('d-m-Y') }}</td></tr>
            <tr><td class="label">Anak Ke</td><td class="separator">:</td><td>{{ $pendaftar->anak_ke }} dari {{ $pendaftar->jumlah_saudara }} bersaudara</td></tr>
            <tr><td class="label">Alamat</td><td class="separator">:</td><td>{{ $pendaftar->alamat_jalan }}, RT/RW {{ $pendaftar->rt_rw }}, Desa {{ $pendaftar->desa }}, Kec. {{ $pendaftar->kecamatan }}, {{ $pendaftar->kabupaten }}</td></tr>
            @if($pendaftar->golongan_darah)
            <tr><td class="label">Golongan Darah</td><td class="separator">:</td><td>{{ $pendaftar->golongan_darah }}</td></tr>
            @endif
            @if($pendaftar->riwayat_penyakit)
            <tr><td class="label">Riwayat Penyakit</td><td class="separator">:</td><td>{{ $pendaftar->riwayat_penyakit }}</td></tr>
            @endif
        </table>

        <div class="section-title">B. SEKOLAH ASAL</div>
        <table>
            <tr><td class="label">Nama Sekolah</td><td class="separator">:</td><td>{{ $pendaftar->asal_sekolah }} ({{ $pendaftar->status_sekolah_asal }})</td></tr>
            <tr><td class="label">NPSN</td><td class="separator">:</td><td>{{ $pendaftar->npsn_sekolah_asal ?? '-' }}</td></tr>
            <tr><td class="label">Lokasi Sekolah</td><td class="separator">:</td><td>{{ $pendaftar->kabupaten_sekolah_asal }}</td></tr>
            @if($pendaftar->asal_anak)
            <tr><td class="label">Asal Anak</td><td class="separator">:</td><td>{{ $pendaftar->asal_anak }}</td></tr>
            @endif
            @if($pendaftar->no_ijazah_sebelumnya)
            <tr><td class="label">No. Ijazah TK/RA</td><td class="separator">:</td><td>{{ $pendaftar->no_ijazah_sebelumnya }}</td></tr>
            @endif
            @if($pendaftar->status_masuk_sekolah)
            <tr><td class="label">Status Masuk</td><td class="separator">:</td><td>{{ $pendaftar->status_masuk_sekolah }}</td></tr>
            @endif
            @if($pendaftar->pindahan_dari_sekolah)
            <tr><td class="label">Pindahan Dari</td><td class="separator">:</td><td>{{ $pendaftar->pindahan_dari_sekolah }}</td></tr>
            @endif
        </table>

        <div class="section-title">C. DATA ORANG TUA</div>
        <table>
            <tr><td class="label">Nama Ayah</td><td class="separator">:</td><td>{{ $pendaftar->nama_ayah }}</td></tr>
            <tr><td class="label">Nama Ibu</td><td class="separator">:</td><td>{{ $pendaftar->nama_ibu }}</td></tr>
            <tr><td class="label">No. WhatsApp</td><td class="separator">:</td><td>{{ $pendaftar->no_wa }}</td></tr>
            @if($pendaftar->nama_wali)
            <tr><td class="label">Nama Wali</td><td class="separator">:</td><td>{{ $pendaftar->nama_wali }}</td></tr>
            @if($pendaftar->nik_wali)
            <tr><td class="label">NIK Wali</td><td class="separator">:</td><td>{{ $pendaftar->nik_wali }}</td></tr>
            @endif
            @if($pendaftar->pekerjaan_wali)
            <tr><td class="label">Pekerjaan Wali</td><td class="separator">:</td><td>{{ $pendaftar->pekerjaan_wali }}</td></tr>
            @endif
            @if($pendaftar->penghasilan_wali)
            <tr><td class="label">Penghasilan Wali</td><td class="separator">:</td><td>{{ $pendaftar->penghasilan_wali }}</td></tr>
            @endif
            @endif
        </table>

        <div class="footer">
            <div style="font-size: 9pt; width: 40%;">
                <strong>INFO AKUN LOGIN:</strong><br>
                Simpan data ini untuk mengecek kelulusan.<br>
                Username: <b>{{ $pendaftar->no_daftar }}</b><br>
                Password: <b>{{ $pendaftar->password }}</b>
            </div>
            <div class="signature">
                Rancapandan, {{ date('d F Y') }}<br>
                Panitia PPDB,<br><br><br><br>
                ( _______________________ )
            </div>
        </div>

        <div class="notes">
            <strong>Catatan Penting:</strong>
            <ol style="margin-top: 5px; margin-bottom: 0; padding-left: 20px;">
                <li>Kartu ini wajib dibawa saat melakukan Daftar Ulang atau Tes Seleksi.</li>
                <li>Simpan Username dan Password untuk login ke sistem PPDB.</li>
                <li>Pantau terus informasi kelulusan melalui website resmi sekolah.</li>
            </ol>
        </div>
    </div>

</body>
</html>