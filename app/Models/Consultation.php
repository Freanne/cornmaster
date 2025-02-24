<?php

// app/Models/Consultation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = ['expert_id', 'farmer_id', 'message', 'status', 'scheduled_at'];

    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

