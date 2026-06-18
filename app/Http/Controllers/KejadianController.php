<?php

namespace App\Http\Controllers;

use App\Models\Kejadian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KejadianController extends Controller
{
    public function index()
    {
        // Mengambil data kejadian terbaru beserta nama pelapornya
        $kejadian = Kejadian::with('user')->orderBy('tanggal_kejadian', 'desc')->get();
        return view('kejadian.index', compact('kejadian'));
    }

    public function create()
    {
        // Mengambil data petugas untuk form pelapor
        $petugas = User::where('role', '!=', 'supervisor')->get();
        return view('kejadian.create', compact('petugas'));
    }

    public function store(Request $request)
    {
        // 1. Validasi inputan
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_kejadian' => 'required|date',
            'waktu_kejadian' => 'required',
            'jenis_kejadian' => 'required|string',
            'kronologi' => 'required|string',
            'tindakan_diambil' => 'required|string',
            'foto_kejadian' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // 2. Logika untuk menyimpan foto kejadian
        if ($request->hasFile('foto_kejadian')) {
            $file = $request->file('foto_kejadian');
            $filename = time() . '_kejadian_' . $file->getClientOriginalName(); 
            // Menyimpan foto ke folder: storage/app/public/kejadian
            $file->storeAs('public/kejadian', $filename);
            
            $data['foto_kejadian'] = $filename; 
        }

        // 3. Simpan ke database
        Kejadian::create($data);

        // 4. Kembali ke tabel
        return redirect()->route('kejadian.index')->with('success', 'Data Insiden berhasil dicatat ke dalam sistem!');
    }

    public function show($id)
    {
        // Mengambil 1 data kejadian beserta nama pelapornya
        $kejadian = Kejadian::with('user')->findOrFail($id);

        // Melempar data tersebut ke halaman show.blade.php
        return view('kejadian.show', compact('kejadian'));
    }

    public function edit($id)
    {
        $kejadian = Kejadian::findOrFail($id);
        $petugas = User::where('role', '!=', 'supervisor')->get();
        return view('kejadian.edit', compact('kejadian', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_kejadian' => 'required|date',
            'waktu_kejadian' => 'required',
            'jenis_kejadian' => 'required|string',
            'kronologi' => 'required|string',
            'tindakan_diambil' => 'required|string',
            'foto_kejadian' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kejadian = Kejadian::findOrFail($id);
        $data = $request->all();

        // Logika jika ada foto baru yang diunggah
        if ($request->hasFile('foto_kejadian')) {
            // Hapus foto lama dari storage
            if ($kejadian->foto_kejadian) {
                Storage::delete('public/kejadian/' . $kejadian->foto_kejadian);
            }

            // Simpan foto baru
            $file = $request->file('foto_kejadian');
            $filename = time() . '_kejadian_' . $file->getClientOriginalName();
            $file->storeAs('public/kejadian', $filename);
            $data['foto_kejadian'] = $filename;
        }

        $kejadian->update($data);

        return redirect()->route('kejadian.index')->with('success', 'Data Insiden berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kejadian = Kejadian::findOrFail($id);

        // Hapus foto fisik dari server sebelum datanya dihapus dari database
        if ($kejadian->foto_kejadian) {
            Storage::delete('public/kejadian/' . $kejadian->foto_kejadian);
        }

        $kejadian->delete();

        return redirect()->route('kejadian.index')->with('success', 'Data Insiden berhasil dihapus secara permanen!');
    }
}