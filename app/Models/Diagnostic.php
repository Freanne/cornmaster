<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    use HasFactory;

    protected $fillable = ['farmer_id', 'expert_id', 'description', 'image'];

    public function farmer() {
        return $this->belongsTo(Farmer::class);
    }
    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
