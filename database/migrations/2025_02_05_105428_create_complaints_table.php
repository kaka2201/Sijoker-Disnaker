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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('questioner_id');
            $table->string('title');
            $table->text('question');
            $table->unsignedBigInteger('responsible_id')->nullable();
            $table->text('answer')->nullable();
            $table->integer('likes')->default(0);
            $table->enum('status', ['not answered', 'answered'])->default('not answered');
            $table->timestamps();
            
            $table->foreign('questioner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('responsible_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
