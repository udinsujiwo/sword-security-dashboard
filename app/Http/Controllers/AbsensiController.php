<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Absensi;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        // Mengambil data absensi beserta nama petugasnya (relasi) dari yang terbaru
        $absensi = Absensi::with('user')->orderBy('tanggal', 'desc')->get();
        return view('absensi.index', compact('absensi'));
    }

    public function create()
    {
        // Mengambil semua data anggota selain supervisor untuk dimasukkan ke pilihan form
        $petugas = User::where('role', '!=', 'supervisor')->get();
        return view('absensi.create', compact('petugas'));
    }

    public function store(Request $request)
    {
        // 1. Cek apakah petugas sudah absen masuk hari ini
        $hariIni = \Carbon\Carbon::today();
        
        // PERUBAHAN: menggunakan 'user_id' dan 'tanggal' sesuai Model Anda
        $cekAbsen = \App\Models\Absensi::where('user_id', auth()->user()->id)
                                        ->whereDate('tanggal', $hariIni)
                                        ->first();

        // Jika sudah ada absen hari ini, tolak absen ganda
        if ($cekAbsen) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen masuk hari ini!');
        }

        // 2. Tentukan Shift Otomatis (Misal: 06:00 - 18:00 = Pagi, sisanya Malam)
        $jamSekarang = date('H');
        $shift = ($jamSekarang >= 6 && $jamSekarang < 18) ? 'Pagi' : 'Malam';

        // 3. Simpan data absen dengan jam server otomatis
        \App\Models\Absensi::create([
            'user_id'          => auth()->user()->id,         // Disesuaikan
            'tanggal'          => now()->toDateString(),      // Disesuaikan
            'waktu_masuk'      => now()->toTimeString(),
            'waktu_keluar'     => null,
            'shift'            => $shift,
            'status_kehadiran' => 'Hadir'                     // Tambahan wajib
        ]);

        return redirect()->route('absensi.index')->with('success', 'Berhasil Absen Masuk pada ' . now()->toTimeString());
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $petugas = User::where('role', '!=', 'supervisor')->get(); // Ambil data petugas untuk pilihan dropdown
        return view('absensi.edit', compact('absensi', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable',
            'shift' => 'required|in:pagi,malam',
            'status_kehadiran' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update($request->all());

        return redirect()->route('absensi.index')->with('success', 'Data Absensi Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Data Absensi Berhasil Dihapus!');
    }
}