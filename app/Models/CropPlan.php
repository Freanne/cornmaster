<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CropPlan extends Model
{
    use HasFactory;

    // Le nom de la table associée au modèle
    protected $table = 'crop_plans';

    // Les attributs qui sont assignables en masse (mass assignment)
    protected $fillable = [
        'farm_name',
        'location',
        'maize_variety',
        'soil_type',
        'soil_ph',
        'soil_fertility',
        'organic_matter',
        'seed_variety',
        'seed_quantity',
        'spacing',
        'irrigation_type',
        'irrigation_frequency',
        'fertilizer_type',
        'fertilizer_quantity',
        'fertilizer_application',
        'pesticides',
        'start_date',
        'duration',
        'workforce',
        'equipment',
        'disease_history',
        'pest_control',
        'harvest_date',
        'harvest_method',
        'storage_location',
        'yield_estimation',
    ];

    // Si tu veux lier le modèle à un autre modèle, comme un Fermier
    public function farmer()
    {
        return $this->belongsTo(Farmer::class);  // Relation inverse
    }
}
