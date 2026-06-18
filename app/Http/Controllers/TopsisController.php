<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class TopsisController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data inventaris
        $data_inventaris = Inventaris::all();

        if ($data_inventaris->isEmpty()) {
            return view('topsis.index')->with('error', 'Data inventaris kosong. Tidak dapat melakukan analisis.');
        }

        // ==========================================
        // TAHAP 1: Menentukan Kriteria & Bobot
        // ==========================================
        // K1: Kondisi (Benefit - Semakin rusak semakin prioritas) -> Bobot: 40% (0.4)
        // K2: Usia/Tahun Perolehan (Benefit - Semakin tua semakin prioritas) -> Bobot: 30% (0.3)
        // K3: Estimasi Harga (Cost - Semakin murah semakin mudah di-acc) -> Bobot: 30% (0.3)
        
        $bobot = [
            'kondisi' => 0.4,
            'usia' => 0.3,
            'harga' => 0.3
        ];

        // ==========================================
        // TAHAP 2: Membuat Matriks Keputusan (X)
        // (Mengubah nilai teks menjadi angka)
        // ==========================================
        $matriks_x = [];
        $tahun_sekarang = date('Y');

        foreach ($data_inventaris as $inv) {
            // Konversi Kondisi ke Angka
            $nilai_kondisi = 1; // Default Bagus
            if ($inv->kondisi == 'Rusak Ringan') $nilai_kondisi = 3;
            if ($inv->kondisi == 'Rusak Berat') $nilai_kondisi = 5;

            // Hitung Usia Barang
            $usia = $tahun_sekarang - $inv->tahun_perolehan;
            // Jika baru dibeli tahun ini, anggap usia 1 agar tidak 0
            if ($usia == 0) $usia = 1;

            $matriks_x[$inv->id] = [
                'barang' => $inv, // Simpan data asli untuk ditampilkan nanti
                'kondisi' => $nilai_kondisi,
                'usia' => $usia,
                'harga' => $inv->estimasi_harga
            ];
        }

        // ==========================================
        // TAHAP 3: Matriks Ternormalisasi (R)
        // ==========================================
        // Hitung pembagi (akar dari jumlah kuadrat setiap kolom kriteria)
        $pembagi_kondisi = 0;
        $pembagi_usia = 0;
        $pembagi_harga = 0;

        foreach ($matriks_x as $x) {
            $pembagi_kondisi += pow($x['kondisi'], 2);
            $pembagi_usia += pow($x['usia'], 2);
            $pembagi_harga += pow($x['harga'], 2);
        }

        $pembagi_kondisi = sqrt($pembagi_kondisi);
        $pembagi_usia = sqrt($pembagi_usia);
        $pembagi_harga = sqrt($pembagi_harga);

        $matriks_r = [];
        foreach ($matriks_x as $id => $x) {
            $matriks_r[$id] = [
                'barang' => $x['barang'],
                // Pastikan pembagi tidak 0 untuk menghindari error Division by Zero
                'kondisi' => $pembagi_kondisi != 0 ? $x['kondisi'] / $pembagi_kondisi : 0,
                'usia' => $pembagi_usia != 0 ? $x['usia'] / $pembagi_usia : 0,
                'harga' => $pembagi_harga != 0 ? $x['harga'] / $pembagi_harga : 0,
            ];
        }

        // ==========================================
        // TAHAP 4: Matriks Ternormalisasi Terbobot (Y)
        // ==========================================
        $matriks_y = [];
        foreach ($matriks_r as $id => $r) {
            $matriks_y[$id] = [
                'barang' => $r['barang'],
                'kondisi' => $r['kondisi'] * $bobot['kondisi'],
                'usia' => $r['usia'] * $bobot['usia'],
                'harga' => $r['harga'] * $bobot['harga'],
            ];
        }

        // ==========================================
        // TAHAP 5: Solusi Ideal Positif (A+) & Negatif (A-)
        // ==========================================
        // K1 (Kondisi) -> Benefit (Max)
        // K2 (Usia) -> Benefit (Max)
        // K3 (Harga) -> Cost (Min)

        $y_kondisi = array_column($matriks_y, 'kondisi');
        $y_usia = array_column($matriks_y, 'usia');
        $y_harga = array_column($matriks_y, 'harga');

        $ideal_positif = [
            'kondisi' => max($y_kondisi), // Benefit -> cari yang paling besar (paling rusak)
            'usia' => max($y_usia),       // Benefit -> cari yang paling besar (paling tua)
            'harga' => min($y_harga)      // Cost -> cari yang paling kecil (paling murah)
        ];

        $ideal_negatif = [
            'kondisi' => min($y_kondisi),
            'usia' => min($y_usia),
            'harga' => max($y_harga)
        ];

        // ==========================================
        // TAHAP 6: Jarak ke Solusi Ideal Positif (D+) & Negatif (D-)
        // ==========================================
        $jarak = [];
        foreach ($matriks_y as $id => $y) {
            $d_plus = sqrt(
                pow($y['kondisi'] - $ideal_positif['kondisi'], 2) +
                pow($y['usia'] - $ideal_positif['usia'], 2) +
                pow($y['harga'] - $ideal_positif['harga'], 2)
            );

            $d_min = sqrt(
                pow($y['kondisi'] - $ideal_negatif['kondisi'], 2) +
                pow($y['usia'] - $ideal_negatif['usia'], 2) +
                pow($y['harga'] - $ideal_negatif['harga'], 2)
            );

            $jarak[$id] = [
                'barang' => $y['barang'],
                'd_plus' => $d_plus,
                'd_min' => $d_min
            ];
        }

        // ==========================================
        // TAHAP 7: Menghitung Nilai Preferensi (V)
        // ==========================================
        $hasil_akhir = [];
        foreach ($jarak as $id => $j) {
            $v = 0;
            // Hindari pembagian dengan 0
            if (($j['d_min'] + $j['d_plus']) != 0) {
                $v = $j['d_min'] / ($j['d_min'] + $j['d_plus']);
            }

            $hasil_akhir[] = [
                'barang' => $j['barang'],
                'nilai_preferensi' => $v
            ];
        }

        // ==========================================
        // TAHAP 8: Perankingan
        // Mengurutkan dari nilai V terbesar ke terkecil
        // ==========================================
        usort($hasil_akhir, function($a, $b) {
            return $b['nilai_preferensi'] <=> $a['nilai_preferensi'];
        });

        // Lempar hasil ke halaman view
        return view('topsis.index', compact('hasil_akhir'));
    }
}