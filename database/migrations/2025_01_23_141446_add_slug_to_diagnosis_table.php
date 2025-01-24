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
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->string('slug')->nullable(); // Ajoute temporairement la colonne sans contrainte
        });
    
        // Génère un slug pour toutes les lignes existantes
        $diagnoses = \App\Models\Diagnosis::all();
        foreach ($diagnoses as $diagnosis) {
            $diagnosis->slug = \Illuminate\Support\Str::slug($diagnosis->name);
            $diagnosis->save();
        }
    
        // Ajoute la contrainte d'unicité après que tous les slugs soient générés
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->unique('slug');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnosis', function (Blueprint $table) {
            //
        });
    }
};
