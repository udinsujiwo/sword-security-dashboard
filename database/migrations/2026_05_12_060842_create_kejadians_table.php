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
        Schema::create('kejadian', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel pengguna (siapa pelapornya)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->date('tanggal_kejadian');
            $table->time('waktu_kejadian');
            $table->string('jenis_kejadian'); // Misal: Pencurian, Kerusakan, Tamu VIP, dll
            $table->text('kronologi'); // Cerita lengkap kejadian
            $table->text('tindakan_diambil'); // Apa yang dilakukan satpam saat itu
            $table->string('foto_kejadian')->nullable(); // Foto bukti insiden
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kejadians');
    }
};
