<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaItem extends Model
{
    use HasFactory;

    protected $table = 'biaya_items';

    // Penting: Daftarkan semua kolom agar bisa diisi (Mass Assignment)
    protected $fillable = [
        'jenjang',
        'kategori',
        'gender',
        'nama_item',
        'nominal'
    ];
}