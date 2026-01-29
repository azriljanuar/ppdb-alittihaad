<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('infos')->where('jenjang', 'RA/TA')->update(['jenjang' => 'RA/TK']);
        DB::table('biaya_items')->where('jenjang', 'RA/TA')->update(['jenjang' => 'RA/TK']);
        DB::table('users')->where('jenjang_access', 'RA/TA')->update(['jenjang_access' => 'RA/TK']);
        DB::table('pendaftars')->where('jenjang', 'RA/TA')->update(['jenjang' => 'RA/TK']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('infos')->where('jenjang', 'RA/TK')->update(['jenjang' => 'RA/TA']);
        DB::table('biaya_items')->where('jenjang', 'RA/TK')->update(['jenjang' => 'RA/TA']);
        DB::table('users')->where('jenjang_access', 'RA/TK')->update(['jenjang_access' => 'RA/TA']);
        DB::table('pendaftars')->where('jenjang', 'RA/TK')->update(['jenjang' => 'RA/TA']);
    }
};
