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
        // Kita ubah nama tabelnya menjadi 'absensi' agar lebih rapi berbahasa Indonesia
        Schema::create('absensi', function (Blueprint $table) {
            $table->id(); // Ini adalah id_absensi (Primary Key)
            
            // Ini adalah id_user (Foreign Key yang terhubung ke tabel users)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->date('tanggal');
            $table->time('waktu_masuk')->nullable(); // Boleh kosong jika belum absen
            $table->time('waktu_keluar')->nullable(); // Boleh kosong sampai waktu pulang
            $table->enum('shift', ['pagi', 'malam']);
            $table->string('status_kehadiran'); // Hadir, Sakit, Izin, Alpa
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
