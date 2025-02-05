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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Judul pelatihan
            $table->text('description')->nullable(); // Deskripsi pelatihan
            $table->date('start_date'); // Tanggal mulai pelatihan
            $table->time('start_time'); // Waktu mulai pelatihan
            $table->date('end_date')->nullable(); // Tanggal selesai pelatihan (opsional)
            $table->time('end_time')->nullable(); // Waktu selesai pelatihan (opsional)
            $table->integer('capacity'); // Kapasitas peserta pelatihan
            $table->string('location'); // Lokasi pelatihan
            $table->string('image')->nullable(); // Kolom untuk menyimpan path gambar pelatihan (opsional)
            $table->timestamps(); // Menyimpan created_at dan updated_at secara otomatis
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
