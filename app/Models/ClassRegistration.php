<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRegistration extends Model
{
    // Sesuaikan dengan kolom yang ada di database
    protected $fillable = ['user_id', 'class_id', 'schedule_id', 'registered_at', 'status', 'payment_status'];

      protected $casts = [
        'registered_at' => 'datetime'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fitnessClass()
    {
        return $this->belongsTo(FitnessClass::class, 'class_id');
    }

    public function schedule()
    {
        return $this->belongsTo(ClassSchedule::class, 'schedule_id');
    }
}
