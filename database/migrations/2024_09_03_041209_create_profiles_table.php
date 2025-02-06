<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Relasi ke tabel users
            $table->string('name');
            $table->string('nik', 16)->nullable();
            $table->date('ttl')->nullable();  // Tanggal lahir
            $table->enum('gender', ['pria', 'wanita'])->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('jalan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('nomor', 15)->nullable();
            $table->string('foto')->nullable();  // Kolom untuk menyimpan path file foto
            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
