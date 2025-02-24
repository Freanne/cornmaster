<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{   
    use HasFactory;
    
        protected $fillable = [
            'user_id',
            'farm_count',
            'total_area',
            'location',
        ];
    
        public function user()
        {
            return $this->belongsTo(User::class);
        }
        public function consultations()
        {
            return $this->hasMany(Consultation::class, 'farmer_id');
        }

        public function diagnostics()
        {
            return $this->hasMany(Diagnostic::class);
        }

        public function farms()
        {
            return $this->hasMany(Farm::class);
        }
}
