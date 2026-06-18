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
        Schema::create('laporan_harian', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel pengguna (siapa yang menulis laporan)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->date('tanggal');
            $table->time('waktu_laporan');
            $table->text('uraian_kegiatan'); // Teks panjang untuk deskripsi patroli
            $table->string('kondisi'); // Status: Aman / Terdapat Kendala
            $table->string('foto_bukti')->nullable(); // Boleh kosong jika tidak ada foto
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harians');
    }
};
