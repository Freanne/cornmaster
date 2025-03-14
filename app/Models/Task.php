<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['cultivation_plan_id', 'task_type', 'task_date', 'status'];

    public function cultivationPlan()
    {
        return $this->belongsTo(CultivationPlan::class);
    }
}