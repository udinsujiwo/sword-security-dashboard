<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarian;
use App\Models\Kejadian;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanHarianController extends Controller
{
   public function index(Request $request)
    {
        // PERUBAHAN: Ubah 'tanggal_laporan' menjadi 'tanggal'
        $laporan = \App\Models\LaporanHarian::with('user')
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('waktu_laporan', 'desc')
                        ->get(); 

        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        // Menyiapkan data petugas untuk dipilih di form
        $petugas = User::where('role', '!=', 'supervisor')->get();
        return view('laporan.create', compact('petugas'));
    }

    public function store(Request $request)
    {
        // 1. Validasi inputan (termasuk membatasi ukuran foto maksimal 2MB)
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'waktu_laporan' => 'required',
            'uraian_kegiatan' => 'required|string',
            'kondisi' => 'required|in:Aman,Terdapat Kendala',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // 2. Logika untuk menyimpan foto (jika petugas mengunggah foto)
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            // Membuat nama file unik agar tidak bentrok jika nama fotonya sama
            $filename = time() . '_' . $file->getClientOriginalName(); 
            // Menyimpan foto ke folder: storage/app/public/laporan
            $file->storeAs('public/laporan', $filename);
            
            // Masukkan nama file unik ini ke dalam database
            $data['foto_bukti'] = $filename; 
        }

        // 3. Simpan semua data ke database
        LaporanHarian::create($data);

        // 4. Kembali ke halaman tabel
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $laporan = LaporanHarian::findOrFail($id);
        $petugas = User::where('role', '!=', 'supervisor')->get();
        return view('laporan.edit', compact('laporan', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'waktu_laporan' => 'required',
            'uraian_kegiatan' => 'required|string',
            'kondisi' => 'required',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $laporan = LaporanHarian::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto_bukti')) {
            // Hapus foto lama jika ada
            if ($laporan->foto_bukti) {
                Storage::delete('public/laporan/' . $laporan->foto_bukti);
            }

            // Simpan foto baru
            $file = $request->file('foto_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/laporan', $filename);
            $data['foto_bukti'] = $filename;
        }

        $laporan->update($data);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $laporan = LaporanHarian::findOrFail($id);

        // Hapus file foto dari folder storage sebelum data di DB dihapus
        if ($laporan->foto_bukti) {
            Storage::delete('public/laporan/' . $laporan->foto_bukti);
        }

        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }

    public function cetakPdf(\Illuminate\Http\Request $request)
    {
        // 1. Siapkan kerangka query dasar
        $query = \App\Models\LaporanHarian::with('user')
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('waktu_laporan', 'desc');

        // 2. Jika user memilih tanggal tertentu, filter datanya!
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        // 3. Tarik datanya
        $laporan = $query->get();

        // 4. Render ke PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact('laporan'));
        $pdf->setPaper('a4', 'portrait');

        // Opsional: Buat nama file dinamis sesuai tanggal
        $namaFile = $request->filled('tanggal') 
            ? 'Laporan_Patroli_' . $request->tanggal . '.pdf' 
            : 'Jurnal_Laporan_Seluruh_Patroli.pdf';

        return $pdf->stream($namaFile);
    }

    public function cetakLengkap(\Illuminate\Http\Request $request)
    {
        $tanggalPilihan = $request->tanggal;

        // 1. Ambil Data Laporan Jurnal Harian (Tabel ini punya kolom 'tanggal')
        $queryLaporan = \App\Models\LaporanHarian::with('user')
                            ->orderBy('waktu_laporan', 'asc');
        
        // 2. Ambil Data Inputan Kejadian (Menggunakan Model Kejadian)
        $queryKejadian = \App\Models\Kejadian::with('user')
                            ->orderBy('created_at', 'asc'); 

        // 3. Terapkan Filter jika tanggal dipilih
        if ($request->filled('tanggal')) {
            // Laporan Harian mencari di kolom 'tanggal'
            $queryLaporan->where('tanggal', $tanggalPilihan);
            
            // PERBAIKAN: Kejadian mencari di kolom 'created_at' menggunakan whereDate
            $queryKejadian->whereDate('created_at', $tanggalPilihan);
        }

        $laporanHarian = $queryLaporan->get();
        $laporanKejadian = $queryKejadian->get();

        // 4. Kirim kedua data ke dalam satu View PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf_lengkap', compact('laporanHarian', 'laporanKejadian', 'tanggalPilihan'));
        $pdf->setPaper('a4', 'portrait');

        $namaFile = $request->filled('tanggal') 
            ? 'Laporan_Lengkap_Sword_Security_' . $tanggalPilihan . '.pdf' 
            : 'Laporan_Lengkap_Sword_Security_Semua_Waktu.pdf';

        return $pdf->stream($namaFile);
    }
}