<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            
            $table->string('kode_barang')->unique(); // Contoh: INV-HT-001
            $table->string('nama_barang'); // Contoh: HT Motorola
            $table->string('kategori'); // Contoh: Elektronik, Kendaraan, Seragam
            $table->integer('jumlah'); 
            $table->string('kondisi'); // Bagus, Rusak Ringan, Rusak Berat
            $table->integer('tahun_perolehan'); // Untuk menghitung umur barang (kriteria TOPSIS)
            $table->decimal('estimasi_harga', 15, 2); // Harga perbaikan/beli baru (kriteria TOPSIS)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
