<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CultivationPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'maize_variety',
        'soil_type',
        'season_type',
        'irrigation_method',
        'fertilizer_type',
        'sowing_date',
        'harvest_date'
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
