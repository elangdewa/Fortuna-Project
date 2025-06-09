<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassScheduleInstance extends Model
{
    protected $fillable = [
        'schedule_id', 'class_id', 'date', 'start_time', 'end_time',
    ];

   public function classSchedule()
{
    return $this->belongsTo(ClassSchedule::class, 'schedule_id');
}

    public function class()
    {
        return $this->belongsTo(FitnessClass::class, 'class_id');
    }
    
}
