<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['diagnostic_id', 'expert_id', 'comment'];

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }

    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }
}
