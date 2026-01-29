<?php

namespace App\Http\Controllers;

use App\Models\Brosur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BrosurController extends Controller
{
    public function index()
    {
        $brosurs = Brosur::latest()->get();
        return view('brosur.index', compact('brosurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'file_brosur' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'jenjang' => 'nullable'
        ]);

        if ($request->hasFile('file_brosur')) {
            $path = $request->file('file_brosur')->store('uploads/brosur', 'public');
            
            Brosur::create([
                'judul' => $request->judul,
                'jenjang' => $request->jenjang,
                'file_path' => $path
            ]);
        }

        return back()->with('success', 'Brosur berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $brosur = Brosur::findOrFail($id);
        if(Storage::disk('public')->exists($brosur->file_path)) {
            Storage::disk('public')->delete($brosur->file_path);
        }
        $brosur->delete();
        return back()->with('success', 'Brosur berhasil dihapus!');
    }
    
    public function download($id)
    {
        $brosur = Brosur::findOrFail($id);
        $path = storage_path('app/public/' . $brosur->file_path);
        if (file_exists($path)) {
            return response()->download($path, $brosur->judul . '.' . pathinfo($path, PATHINFO_EXTENSION));
        }
        return back()->with('error', 'File tidak ditemukan.');
    }
}
