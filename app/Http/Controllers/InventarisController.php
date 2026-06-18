<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index()
    {
        // --- PENGAMANAN TINGKAT 1: (Akses untuk Supervisor & Danru) ---
        if (auth()->user()->role !== 'supervisor' && auth()->user()->role !== 'danru') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Halaman ini khusus untuk Supervisor dan Komandan Regu.');
        }
        // ---------------------------------------------------------------

        // Menampilkan data inventaris terbaru
        $inventaris = Inventaris::orderBy('created_at', 'desc')->get();
        return view('inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        // --- PENGAMANAN TINGKAT 2: (Akses KHUSUS Supervisor) ---
        if (auth()->user()->role !== 'supervisor') {
            return redirect()->route('inventaris.index')->with('error', 'Akses ditolak! Hanya Supervisor yang boleh menambah data barang.');
        }

        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'supervisor') {
            return redirect()->route('inventaris.index')->with('error', 'Akses ditolak!');
        }

        // 1. Validasi inputan dari form
        $request->validate([
            'kode_barang' => 'required|string|unique:inventaris,kode_barang', // Kode tidak boleh kembar
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Bagus,Rusak Ringan,Rusak Berat',
            'tahun_perolehan' => 'required|integer',
            'estimasi_harga' => 'required|numeric|min:0',
        ]);

        // 2. Simpan ke database
        Inventaris::create($request->all());

        // 3. Kembali ke tabel dengan pesan sukses
        return redirect()->route('inventaris.index')->with('success', 'Data barang operasional berhasil ditambahkan ke inventaris!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'supervisor') {
            return redirect()->route('inventaris.index')->with('error', 'Akses ditolak! Hanya Supervisor yang boleh mengubah data barang.');
        }

        // Mencari data barang berdasarkan ID
        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'supervisor') {
            return redirect()->route('inventaris.index')->with('error', 'Akses ditolak!');
        }

        // 1. Validasi data
        $request->validate([
            'kode_barang' => 'required|string|unique:inventaris,kode_barang,'.$id,
            'nama_barang' => 'required|string',
            'kategori' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Bagus,Rusak Ringan,Rusak Berat',
            'tahun_perolehan' => 'required|integer',
            'estimasi_harga' => 'required|numeric|min:0',
        ]);

        // 2. Update data di database
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update($request->all());

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'supervisor') {
            return redirect()->route('inventaris.index')->with('error', 'Akses ditolak! Hanya Supervisor yang boleh menghapus data barang.');
        }

        // Menghapus data barang
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil dihapus!');
    }
}