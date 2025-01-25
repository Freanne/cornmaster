<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    
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
}
