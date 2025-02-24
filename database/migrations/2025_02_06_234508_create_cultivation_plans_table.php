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
        Schema::create('cultivation_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->onDelete('cascade');
            $table->enum('maize_variety', ['farineux', 'doux']);
            $table->enum('soil_type', ['argileux', 'sablonneux', 'limoneux', 'humifère']);
            $table->enum('season_type', ['sèche', 'pluvieuse']);
            $table->enum('irrigation_method', ['goutte à goutte', 'aspersion']);
            $table->enum('fertilizer_type', ['npk', 'urée']);
            $table->date('sowing_date');
            $table->date('harvest_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultivation_plans');
    }
};
