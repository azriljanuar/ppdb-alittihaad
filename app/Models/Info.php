<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $guarded = [];

    protected $casts = [
        'jadwal_json' => 'array',
        'syarat_json' => 'array',
        'beasiswa_json' => 'array',
        'images' => 'array',
    ];
}
