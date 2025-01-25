<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
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
}
