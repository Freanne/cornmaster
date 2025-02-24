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
        Schema::create('crop_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmers')->onDelete('cascade'); // clé étrangère vers farmers
            $table->string('farm_name');
            $table->string('location');
            $table->string('maize_variety');
            $table->string('soil_type');
            $table->string('soil_ph');
            $table->string('soil_fertility');
            $table->boolean('organic_matter');
            $table->string('seed_variety');
            $table->float('seed_quantity');
            $table->float('spacing');
            $table->string('irrigation_type');
            $table->float('irrigation_frequency');
            $table->string('fertilizer_type');
            $table->float('fertilizer_quantity');
            $table->string('fertilizer_application');
            $table->string('pesticides');
            $table->date('start_date');
            $table->integer('duration');
            $table->integer('workforce');
            $table->string('equipment')->nullable();
            $table->string('disease_history');
            $table->string('pest_control');
            $table->date('harvest_date');
            $table->string('harvest_method');
            $table->string('storage_location');
            $table->float('yield_estimation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_plans');
    }
};
