<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = [
        'class_id', 'day_of_week', 'start_time', 'end_time', 
        'price', 'description', 'capacity'
    ];

    public function fitnessClass()
    {
        return $this->belongsTo(FitnessClass::class, 'class_id');
    }
    
    public function registrations()
    {
        return $this->hasMany(ClassRegistration::class, 'schedule_id');
    }
    
    // Method untuk menghitung sisa kuota
    public function getAvailableSlotsAttribute()
    {
        $totalRegistrations = $this->registrations()->count();
        
   
        if ($this->capacity) {
            return $this->capacity - $totalRegistrations;
        }
        
 
        return $this->fitnessClass->capacity - $totalRegistrations;
    }
    
    // Method untuk mendapatkan kapasitas (dari schedule atau class)
    public function getEffectiveCapacityAttribute()
    {
        return $this->capacity ?: $this->fitnessClass->capacity; 
    }
    
    // Method untuk cek apakah kuota masih tersedia
    public function isFull()
    {
        return $this->available_slots <= 0;
    }
    
    // Method untuk cek apakah user sudah terdaftar di jadwal ini
    public function isRegisteredBy($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }
}