<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Models\WebsiteSetting;

class HomeController extends Controller
{
    // HAPUS function __construct di sini. Kita tidak pakai itu lagi.

    public function index()
    {
        $infos = Info::all();
        $setting = WebsiteSetting::first();
        return view('home', compact('infos', 'setting'));
    }
}
