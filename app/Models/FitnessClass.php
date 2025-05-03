<?php

namespace App\Models;
use App\Models\PersonalTrainer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessClass extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default
    protected $table = 'fitness_classes';

    // Define fillable fields
    protected $fillable = ['class_name', 'description', 'trainer_id', 'capacity'];


    public function trainer()
    {
        return $this->belongsTo(PersonalTrainer::class, 'trainer_id');
    }


}


