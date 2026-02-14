<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    public function index()
    {
        // Hanya superadmin yang boleh akses
        if (Auth::user()->role !== 'superadmin') {
            return redirect('/admin')->with('error', 'Akses Ditolak!');
        }

        $setting = WebsiteSetting::first();
        if (!$setting) {
            // Create default if not exists (safety net)
            $setting = WebsiteSetting::create([
                'site_title' => 'PPDB Al-Ittihaad',
                'hero_title' => 'Membangun Generasi',
                'hero_title_highlight' => 'Qurani & Berprestasi',
            ]);
        }

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return back()->with('error', 'Akses Ditolak!');
        }

        $setting = WebsiteSetting::first();

        $request->validate([
            'site_title' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_title_highlight' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_badge' => 'nullable|string|max:255',
            'site_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_icon' => 'nullable|file|mimes:jpeg,png,jpg,gif,ico,svg|max:1024',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'feature1_title' => 'nullable|string|max:255',
            'feature1_desc' => 'nullable|string|max:255',
            'feature2_title' => 'nullable|string|max:255',
            'feature2_desc' => 'nullable|string|max:255',
            'feature3_title' => 'nullable|string|max:255',
            'feature3_desc' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'site_title', 'hero_title', 'hero_title_highlight', 
            'hero_description', 'hero_badge',
            'feature1_title', 'feature1_desc',
            'feature2_title', 'feature2_desc',
            'feature3_title', 'feature3_desc'
        ]);

        // Handle File Uploads
        if ($request->hasFile('site_logo')) {
            if ($setting->site_logo) {
                // Hapus file lama jika ada (opsional, tergantung kebutuhan storage)
                // Storage::disk('public')->delete($setting->site_logo); 
            }
            $file = $request->file('site_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            $data['site_logo'] = 'uploads/settings/' . $filename;
        }

        if ($request->hasFile('site_icon')) {
            $file = $request->file('site_icon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            $data['site_icon'] = 'uploads/settings/' . $filename;
        }

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $filename = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            $data['hero_image'] = 'uploads/settings/' . $filename;
        }

        $setting->update($data);

        return back()->with('success', 'Pengaturan Website Berhasil Diupdate!');
    }
}
