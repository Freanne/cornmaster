<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnosis extends Model
{
    use HasFactory;
    
    protected $table = 'diagnosis';

    protected $fillable = ['name', 'description', 'pathogene', 'prevention', 'image_url'];

    protected $casts = [
        'image_url' => 'array', // Le champ image_url sera un tableau
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($diagnosis) {
            $diagnosis->slug = Str::slug($diagnosis->name);
        });

    }

}
