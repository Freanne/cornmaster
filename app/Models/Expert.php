<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expert extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'speciality',
        'experience',
        'availability',
        'diploma_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function diagnostics()
    {
        return $this->hasMany(Diagnostic::class);
    }
}
