<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LaporanHarian;
use App\Models\Kejadian;
use App\Models\Inventaris;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Statistik Cepat
        $hari_ini = date('Y-m-d');
        $bulan_ini = date('m');

        $total_anggota = User::where('role', '!=', 'supervisor')->count();
        $laporan_hari_ini = LaporanHarian::whereDate('tanggal', $hari_ini)->count();
        $kejadian_bulan_ini = Kejadian::whereMonth('tanggal_kejadian', $bulan_ini)->count();

        // 2. Ambil Prioritas 1 dari TOPSIS (Versi Cepat)
        $barang_prioritas = null;
        $data_inventaris = Inventaris::all();
        
        if ($data_inventaris->count() > 0) {
            $matriks_y = [];
            foreach ($data_inventaris as $inv) {
                $nilai_kondisi = ($inv->kondisi == 'Rusak Berat') ? 5 : (($inv->kondisi == 'Rusak Ringan') ? 3 : 1);
                $usia = date('Y') - $inv->tahun_perolehan;
                $usia = ($usia == 0) ? 1 : $usia;
                
                $matriks_y[] = [
                    'barang' => $inv,
                    'skor_kasar' => ($nilai_kondisi * 0.4) + ($usia * 0.3) - ($inv->estimasi_harga * 0.000001)
                ];
            }
            usort($matriks_y, function($a, $b) { return $b['skor_kasar'] <=> $a['skor_kasar']; });
            $barang_prioritas = $matriks_y[0]['barang'];
        }

        // 3. Ambil Pegawai Terbaik dari SAW (Versi Cepat)
        $pegawai_terbaik = null;
        $petugas = User::where('role', '!=', 'supervisor')->get();
        
        if ($petugas->count() > 0) {
            $data_mentah = [];
            $max_c1 = 1; // Default 1 agar tidak error dibagi nol
            $max_c2 = 1;

            foreach ($petugas as $p) {
                $c1 = LaporanHarian::where('user_id', $p->id)->count();
                $c2 = Kejadian::where('user_id', $p->id)->count();
                $data_mentah[] = ['user' => $p, 'c1' => $c1, 'c2' => $c2];
                if ($c1 > $max_c1) $max_c1 = $c1;
                if ($c2 > $max_c2) $max_c2 = $c2;
            }

            $hasil_saw = [];
            foreach ($data_mentah as $data) {
                $v = (($data['c1'] / $max_c1) * 0.60) + (($data['c2'] / $max_c2) * 0.40);
                $hasil_saw[] = ['user' => $data['user'], 'nilai' => $v];
            }

            usort($hasil_saw, function($a, $b) { return $b['nilai'] <=> $a['nilai']; });
            $pegawai_terbaik = $hasil_saw[0]; // Ambil data peringkat 1
        }

        // Lempar semua data ke halaman View
        return view('dashboard', compact(
            'total_anggota', 
            'laporan_hari_ini', 
            'kejadian_bulan_ini', 
            'barang_prioritas',
            'pegawai_terbaik'
        ));
    }
}