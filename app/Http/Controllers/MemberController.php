<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        // Memanggil file view yang ada di folder 'resources/views/anggota/index.blade.php'
        $anggota = User::where('role', '!=', 'supervisor')->get();
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi (Mengecek) data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // memastikan email tidak ganda
            'password' => 'required|string|min:4',
            'role' => 'required|in:petugas,danru',
        ]);

        // 2. Memasukkan data ke Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password otomatis dikunci/enkripsi
            'role' => $request->role,
        ]);

        // 3. Mengembalikan layar ke halaman Daftar Anggota beserta pesan sukses
        return redirect()->route('anggota.index')->with('success', 'Anggota Baru Berhasil Ditambahkan!');
    }

    public function destroy($id)
    {
        // Cari anggota berdasarkan ID, lalu hapus
        $anggota = User::findOrFail($id);
        $anggota->delete();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('anggota.index')->with('success', 'Data Anggota Berhasil Dihapus!');
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data (Pengecualian email agar tidak error jika emailnya tidak diganti)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:petugas,danru',
        ]);

        $anggota = User::findOrFail($id);
        $anggota->name = $request->name;
        $anggota->email = $request->email;
        $anggota->role = $request->role;

        // Jika kolom password diisi, maka update passwordnya. Jika kosong, biarkan password lama.
        if ($request->filled('password')) {
            $anggota->password = Hash::make($request->password);
        }

        $anggota->save();

        return redirect()->route('anggota.index')->with('success', 'Data Anggota Berhasil Diperbarui!');
    }
}