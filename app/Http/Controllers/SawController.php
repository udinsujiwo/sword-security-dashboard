<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LaporanHarian;
use App\Models\Kejadian;
use App\Models\Absensi; // Memanggil model Absensi
use Illuminate\Http\Request;

class SawController extends Controller
{
    public function index()
    {
        // --- 1. PENGAMANAN AKSES (Khusus Supervisor) ---
        if (auth()->user()->role !== 'supervisor') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Halaman penilaian khusus untuk Supervisor.');
        }
        // ------------------------------------------

        // 2. Ambil semua anggota satpam (bukan supervisor)
        $petugas = User::where('role', '!=', 'supervisor')->get();

        if ($petugas->isEmpty()) {
            return view('saw.index')->with('error', 'Belum ada data anggota satpam.');
        }

        // 3. Tentukan Bobot Kriteria (Total 100% / 1.0)
        $bobot_c1 = 0.40; // 40% untuk Kehadiran (Absensi)
        $bobot_c2 = 0.40; // 40% untuk Kerajinan Patroli
        $bobot_c3 = 0.20; // 20% untuk Ketanggapan Insiden

        // 4. Kumpulkan Data Mentah (Matriks Keputusan)
        $data_mentah = [];
        $max_c1 = 0;
        $max_c2 = 0;
        $max_c3 = 0;

        foreach ($petugas as $p) {
            // Hitung total dari masing-masing kriteria
            $c1 = Absensi::where('user_id', $p->id)->count();
            $c2 = LaporanHarian::where('user_id', $p->id)->count();
            $c3 = Kejadian::where('user_id', $p->id)->count();

            $data_mentah[] = [
                'user' => $p,
                'c1' => $c1,
                'c2' => $c2,
                'c3' => $c3
            ];

            // Cari nilai tertinggi untuk pembagi (Normalisasi)
            if ($c1 > $max_c1) $max_c1 = $c1;
            if ($c2 > $max_c2) $max_c2 = $c2;
            if ($c3 > $max_c3) $max_c3 = $c3;
        }

        // Jika data masih kosong sama sekali, cegah error dibagi 0
        if ($max_c1 == 0) $max_c1 = 1;
        if ($max_c2 == 0) $max_c2 = 1;
        if ($max_c3 == 0) $max_c3 = 1;

        // 5. Hitung Nilai Akhir (Normalisasi x Bobot)
        $hasil_akhir = [];
        foreach ($data_mentah as $data) {
            // Rumus Normalisasi Benefit: Nilai / Nilai Max
            $normalisasi_c1 = $data['c1'] / $max_c1;
            $normalisasi_c2 = $data['c2'] / $max_c2;
            $normalisasi_c3 = $data['c3'] / $max_c3;

            // Rumus Nilai Preferensi (V)
            $nilai_v = ($normalisasi_c1 * $bobot_c1) + ($normalisasi_c2 * $bobot_c2) + ($normalisasi_c3 * $bobot_c3);

            $hasil_akhir[] = [
                'user' => $data['user'],
                'total_absen' => $data['c1'], 
                'total_laporan' => $data['c2'],
                'total_kejadian' => $data['c3'],
                'nilai_akhir' => $nilai_v
            ];
        }

        // 6. Urutkan dari nilai tertinggi ke terendah (Perankingan)
        usort($hasil_akhir, function($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        return view('saw.index', compact('hasil_akhir'));
    }
}