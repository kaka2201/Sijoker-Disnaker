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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('ak1')->nullable();
            // Tambahkan kolom status untuk setiap dokumen
            $table->enum('ktp_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->enum('kk_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->enum('ijazah_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->enum('ak1_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
