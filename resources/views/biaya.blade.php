@extends('layout_admin') 

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="bi bi-tags me-2"></i>Kelola Rincian Biaya ({{ $selectedJenjang }})</h3>
        {{-- Tombol Kembali ke Info Website (Bukan Dashboard) --}}
        <a href="{{ route('infos.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Info Website
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('biaya.simpan') }}" method="POST" id="formBiaya" 
                data-biaya-items="{{ json_encode($biaya_items) }}" 
                data-selected-jenjang="{{ $selectedJenjang }}">
                @csrf
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <label class="small fw-bold text-muted text-uppercase mb-2">Pilih Kategori:</label>
                        <div class="row g-3">
                            <input type="hidden" name="jenjang" value="{{ $selectedJenjang }}">

                            @if(in_array($selectedJenjang, ['MTS','MA']))
                                <div class="col-md-4">
                                    <select name="kategori" id="pilihKategori" class="form-select" required>
                                        <option value="Asrama">Asrama (Boarding)</option>
                                        <option value="Non-Asrama">Non-Asrama (Full Day)</option>
                                    </select>
                                </div>
                            @elseif(in_array($selectedJenjang, ['PAUD','RA/TK','MDU']))
                                {{-- Kategori Umum untuk jenjang ini --}}
                                <input type="hidden" name="kategori" id="pilihKategori" value="Biaya Pendidikan">
                                <div class="col-md-4 d-flex align-items-center">
                                    <span class="badge text-bg-light border">Kategori: Biaya Pendidikan</span>
                                </div>
                            @else
                                <input type="hidden" name="kategori" id="pilihKategori" value="Non-Asrama">
                                <div class="col-md-4 d-flex align-items-center">
                                    <span class="badge text-bg-light border">Kategori: Non-Asrama</span>
                                </div>
                            @endif

                            {{-- Gender Selection Logic --}}
                            @if(in_array($selectedJenjang, ['PAUD','RA/TK','MDU']))
                                {{-- Jika jenjang ini, gender diset otomatis ke 'Putra' tapi backend akan pakai logika display merged --}}
                                {{-- Kita hide dropdown tapi set value default --}}
                                <input type="hidden" name="gender" id="pilihGender" value="Putra">
                                <div class="col-md-4 d-flex align-items-center">
                                    <span class="badge text-bg-info text-white border"><i class="bi bi-info-circle me-1"></i> Berlaku untuk Semua (Putra/Putri)</span>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <select name="gender" id="pilihGender" class="form-select" required>
                                        <option value="Putra">Putra</option>
                                        <option value="Putri">Putri</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div id="loadingData" class="text-primary small d-none mt-2">
                            <span class="spinner-border spinner-border-sm me-1"></span> Mengambil data...
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="fw-bold">Rincian Item Pembayaran:</label>
                    <button type="button" class="btn btn-success btn-sm" id="btnTambahBaris">
                        <i class="bi bi-plus-lg"></i> Tambah Item
                    </button>
                </div>
                
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Nama Item</th>
                            <th width="30%">Nominal (Rp)</th>
                            <th width="5%">Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="biayaContainer">
                        </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-end fw-bold">TOTAL:</td>
                            <td class="fw-bold text-success fs-5" id="tampilanTotal">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary fw-bold py-2">SIMPAN PERUBAHAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const $form = $('#formBiaya');
        const allData = $form.data('biaya-items');
        const selectedJenjang = $form.data('selected-jenjang');

        // Helper untuk set value aman
        function safeVal(selector, val) {
            $(selector).val(val);
        }

        function renderRow(nama = '', nominal = '') {
            let rowId = Date.now() + Math.random().toString(36).substr(2, 9);
            let html = `
                <tr id="row-${rowId}">
                    <td><input type="text" name="nama_item[]" class="form-control input-nama" placeholder="Contoh: Seragam" required></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text bg-white">Rp</span>
                            <input type="text" name="nominal[]" class="form-control text-end input-nominal" placeholder="0" onkeyup="formatRupiah(this)" required>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm hapus-baris"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>`;
            $('#biayaContainer').append(html);
            
            // Set value menggunakan .val() untuk menghindari masalah quote/karakter khusus
            $(`#row-${rowId} .input-nama`).val(nama);
            $(`#row-${rowId} .input-nominal`).val(nominal);
            
            hitungTotal();
        }

        function loadDataTersimpan(isInitial = false) {
            let jenjang = selectedJenjang;
            let kategori = $('#pilihKategori').val();
            let gender = $('#pilihGender').val();
            if (!jenjang) return; 

            // Logic Auto-Select saat awal load jika data kosong untuk pilihan default
            if (isInitial && allData.length > 0) {
                // Cek apakah kombinasi default (misal Putra) ada datanya?
                let defaultHasData = allData.some(item => item.jenjang == jenjang && item.kategori == kategori && item.gender == gender);
                
                if (!defaultHasData) {
                    // Cari kombinasi yang ADA datanya
                    let existingItem = allData.find(item => item.jenjang == jenjang);
                    if (existingItem) {
                        // Update dropdown/hidden input
                        if ($('#pilihKategori').is('select')) {
                            $('#pilihKategori').val(existingItem.kategori);
                        }
                        $('#pilihGender').val(existingItem.gender);
                        
                        // Update variabel lokal
                        kategori = existingItem.kategori;
                        gender = existingItem.gender;
                    }
                }
            }

            $('#loadingData').removeClass('d-none');
            $('#biayaContainer').empty(); 

            let filtered = allData.filter(item => item.jenjang == jenjang && item.kategori == kategori && item.gender == gender);

            if (filtered.length > 0) {
                filtered.forEach(item => renderRow(item.nama_item, new Intl.NumberFormat('id-ID').format(item.nominal)));
            } else {
                renderRow();
            }
            $('#loadingData').addClass('d-none');
        }

        $('#pilihKategori, #pilihGender').change(function() { loadDataTersimpan(false); });
        $('#btnTambahBaris').click(function() { renderRow(); });
        $(document).on('click', '.hapus-baris', function() {
            if ($('#biayaContainer tr').length > 1) { $(this).closest('tr').remove(); hitungTotal(); }
        });

        window.formatRupiah = function(input) {
            let value = input.value.replace(/[^,\d]/g, '').toString(), split = value.split(','), sisa = split[0].length % 3, rupiah = split[0].substr(0, sisa), ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) { let separator = sisa ? '.' : ''; rupiah += separator + ribuan.join('.'); }
            input.value = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            hitungTotal();
        }

        function hitungTotal() {
            let total = 0;
            $('.input-nominal').each(function() { let val = $(this).val().replace(/\./g, ''); if (val) total += parseInt(val); });
            $('#tampilanTotal').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
        }
        
        // Panggil dengan flag isInitial = true
        loadDataTersimpan(true);
    });
</script>
@endsection
