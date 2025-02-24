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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_id')->constrained()->onDelete('cascade'); // Lier à un expert
            $table->foreignId('farmer_id')->constrained('users')->onDelete('cascade'); // Lier à un agriculteur (utilisateur)
            $table->text('message');
            $table->enum('status', ['pending', 'confirmed', 'completed'])->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
