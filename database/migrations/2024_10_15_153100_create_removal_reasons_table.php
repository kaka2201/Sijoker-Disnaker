<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemovalReasonsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('removal_reasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User being removed
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // Admin removing the user
            $table->text('reason'); // Reason for removal
            $table->string('status')->default('unverified'); // Status (unverified/verified)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('removal_reasons');
    }
}
