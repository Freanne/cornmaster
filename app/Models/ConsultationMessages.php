<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationMessages extends Model
{
    use HasFactory;
    
    protected $table = 'consultationmessages';

    protected $fillable = [
        'consultation_id',
        'sender_id',
        'receiver_id',
        'message',
        'sender_type',
    ];

    // Relier le message à la consultation
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    // Relier le message à l'utilisateur qui l'a envoyé
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}