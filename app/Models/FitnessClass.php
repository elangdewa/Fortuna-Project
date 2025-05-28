<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'description',
        'capacity'
    ];

     public $timestamps = false;

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }
}
