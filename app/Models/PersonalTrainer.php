<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalTrainer extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'personal_trainers';
    protected $fillable = [
        'name',
        'experience'
        
    ];
 
   
    public function fitnessClasses()
    {
        return $this->hasMany(FitnessClass::class);
    }
}
